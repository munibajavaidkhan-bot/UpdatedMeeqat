<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeeqatDistanceRequest;
use App\Models\MeeqatLocation;
use App\Models\MeeqatDistanceLog;
use App\Services\DistanceCalculatorService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MeeqatController extends Controller
{
    public function __construct(
        private readonly DistanceCalculatorService $distanceService
    ) {}

    // =========================================
    // INDEX — Finder Page
    // =========================================
    public function index()
    {
        // Sab Meeqat locations map ke liye
        $meeqatLocations = MeeqatLocation::active()->get();

        // User ka last search (agar logged in)
        $lastSearch = null;
        if (auth()->check()) {
            $lastSearch = MeeqatDistanceLog::where('user_id', auth()->id())
                ->with('nearestMeeqat')
                ->latest('created_at')
                ->first();
        }

        // Stats
        $totalSearches = MeeqatDistanceLog::count();

        // Map data for Leaflet JS
        $mapData = $meeqatLocations->map(fn($m) => [
            'id'        => $m->id,
            'name_en'   => $m->name_en,
            'name_ar'   => $m->name_ar,
            'name_ur'   => $m->name_ur,
            'lat'       => $m->latitude,
            'lng'       => $m->longitude,
            'color'     => $m->color,
            'icon'      => $m->icon,
            'for'       => $m->for_pilgrims_from,
            'gmaps_url' => $m->google_maps_url,
        ]);

        return view('meeqat.finder', compact(
            'meeqatLocations',
            'lastSearch',
            'totalSearches',
            'mapData'
        ));
    }

    // =========================================
    // CALCULATE — Distance Calculate Karo
    // =========================================
    public function calculate(MeeqatDistanceRequest $request)
    {
        $userLat = null;
        $userLon = null;
        $country = null;
        $city    = null;
        $method  = $request->input('method');

        // ---- GPS Method ----
        if ($method === 'gps') {
            $userLat = (float) $request->latitude;
            $userLon = (float) $request->longitude;
        }

        // ---- Manual Method ----
        if ($method === 'manual') {
            $geoResult = $this->geocodeCity(
                $request->city ?? '',
                $request->country
            );

            if (!$geoResult['success']) {
                return back()
                    ->withInput()
                    ->with('error', 'City/Country coordinates nahi mili. Doosri location try karein.');
            }

            $userLat = $geoResult['lat'];
            $userLon = $geoResult['lon'];
            $country = $request->country;
            $city    = $request->city;
        }

        // Distance calculate karo
        $result = $this->distanceService->calculateFromUserLocation($userLat, $userLon);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        // Database mein save karo
        $log = MeeqatDistanceLog::create([
            'user_id'             => auth()->id(),
            'session_id'          => session()->getId(),
            'user_latitude'       => $userLat,
            'user_longitude'      => $userLon,
            'user_country'        => $country,
            'user_city'           => $city,
            'nearest_meeqat_id'   => $result['nearest_meeqat']->id,
            'nearest_distance_km' => $result['nearest_distance_km'],
            'all_distances'       => $result['all_distances_array'],
            'detection_method'    => $method,
            'ip_address'          => $request->ip(),
        ]);

        // Activity log
        ActivityLogService::log(
            action:  'meeqat_search',
            module:  'meeqat_finder',
            details: [
                'method'     => $method,
                'nearest'    => $result['nearest_meeqat']->name_en,
                'distance'   => $result['nearest_distance_km'],
                'country'    => $country,
            ]
        );

        return redirect()->route('meeqat.result', $log->id);
    }

    // =========================================
    // RESULT — Show Result Page
    // =========================================
    public function result(int $id)
    {
        $log = MeeqatDistanceLog::with('nearestMeeqat')->findOrFail($id);

        // Security check: owner ya same session wala hi dekh sakta hai
        if ($log->user_id && $log->user_id !== auth()->id()) {
            abort(403);
        }
        if (!$log->user_id && $log->session_id !== session()->getId()) {
            abort(403);
        }

        // Distance recalculate for display
        $result = $this->distanceService->calculateFromUserLocation(
            $log->user_latitude,
            $log->user_longitude
        );

        $meeqatLocations = MeeqatLocation::active()->get();

        return view('meeqat.result', compact('log', 'result', 'meeqatLocations'));
    }

    // =========================================
    // ALL LOCATIONS PAGE
    // =========================================
    public function locations()
    {
        $locations = MeeqatLocation::active()->get();
        return view('meeqat.locations', compact('locations'));
    }

    // =========================================
    // AJAX — GPS Calculate (JSON)
    // =========================================
    public function ajaxCalculate(Request $request): JsonResponse
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $result = $this->distanceService->calculateFromUserLocation(
            (float) $request->latitude,
            (float) $request->longitude
        );

        if (!$result['success']) {
            return response()->json(['success' => false, 'message' => $result['message']], 400);
        }

        // Log save
        $log = MeeqatDistanceLog::create([
            'user_id'             => auth()->id(),
            'session_id'          => session()->getId(),
            'user_latitude'       => $request->latitude,
            'user_longitude'      => $request->longitude,
            'nearest_meeqat_id'   => $result['nearest_meeqat']->id,
            'nearest_distance_km' => $result['nearest_distance_km'],
            'all_distances'       => $result['all_distances_array'],
            'detection_method'    => 'gps',
            'ip_address'          => $request->ip(),
        ]);

        return response()->json([
            'success'     => true,
            'redirect_to' => route('meeqat.result', $log->id),
            'nearest'     => [
                'name'        => $result['nearest_meeqat']->name_en,
                'name_ar'     => $result['nearest_meeqat']->name_ar,
                'distance_km' => $result['nearest_distance_km'],
            ],
        ]);
    }

    // =========================================
    // GEOCODE CITY (Manual Method)
    // =========================================
    private function geocodeCity(string $city, string $country): array
    {
        // Predefined coordinates for common countries/cities
        $predefined = $this->getPredefinedCoordinates();

        $key = strtolower(trim($city . ', ' . $country));
        if (isset($predefined[$key])) {
            return array_merge(['success' => true], $predefined[$key]);
        }

        // Country se try karo
        $countryKey = strtolower(trim($country));
        if (isset($predefined[$countryKey])) {
            return array_merge(['success' => true], $predefined[$countryKey]);
        }

        // OpenStreetMap Nominatim API (free)
        try {
            $query = $city ? "{$city}, {$country}" : $country;
            $url   = "https://nominatim.openstreetmap.org/search?q=" . urlencode($query) . "&format=json&limit=1";

            $context = stream_context_create([
                'http' => [
                    'header'  => "User-Agent: Meeqat.io/1.0\r\n",
                    'timeout' => 5,
                ]
            ]);

            $response = @file_get_contents($url, false, $context);

            if ($response) {
                $data = json_decode($response, true);
                if (!empty($data)) {
                    return [
                        'success' => true,
                        'lat'     => (float) $data[0]['lat'],
                        'lon'     => (float) $data[0]['lon'],
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Geocoding error: ' . $e->getMessage());
        }

        return ['success' => false];
    }

    // =========================================
    // PREDEFINED COORDINATES
    // =========================================
    private function getPredefinedCoordinates(): array
    {
        return [
            // Pakistan
            'pakistan'          => ['lat' => 30.3753, 'lon' => 69.3451],
            'karachi, pakistan' => ['lat' => 24.8607, 'lon' => 67.0011],
            'lahore, pakistan'  => ['lat' => 31.5204, 'lon' => 74.3587],
            'islamabad, pakistan' => ['lat' => 33.6844, 'lon' => 73.0479],
            'peshawar, pakistan'  => ['lat' => 34.0151, 'lon' => 71.5249],
            'quetta, pakistan'    => ['lat' => 30.1798, 'lon' => 66.9750],
            'multan, pakistan'    => ['lat' => 30.1575, 'lon' => 71.5249],

            // India
            'india'             => ['lat' => 20.5937, 'lon' => 78.9629],
            'delhi, india'      => ['lat' => 28.7041, 'lon' => 77.1025],
            'mumbai, india'     => ['lat' => 19.0760, 'lon' => 72.8777],
            'hyderabad, india'  => ['lat' => 17.3850, 'lon' => 78.4867],
            'kolkata, india'    => ['lat' => 22.5726, 'lon' => 88.3639],

            // Bangladesh
            'bangladesh'        => ['lat' => 23.6850, 'lon' => 90.3563],
            'dhaka, bangladesh' => ['lat' => 23.8103, 'lon' => 90.4125],

            // Indonesia
            'indonesia'         => ['lat' => -0.7893, 'lon' => 113.9213],
            'jakarta, indonesia'=> ['lat' => -6.2088, 'lon' => 106.8456],

            // Malaysia
            'malaysia'          => ['lat' => 4.2105, 'lon' => 101.9758],

            // Turkey
            'turkey'            => ['lat' => 38.9637, 'lon' => 35.2433],
            'istanbul, turkey'  => ['lat' => 41.0082, 'lon' => 28.9784],
            'ankara, turkey'    => ['lat' => 39.9334, 'lon' => 32.8597],

            // UK
            'united kingdom'    => ['lat' => 55.3781, 'lon' => -3.4360],
            'london, uk'        => ['lat' => 51.5074, 'lon' => -0.1278],
            'london, united kingdom' => ['lat' => 51.5074, 'lon' => -0.1278],

            // USA
            'united states'     => ['lat' => 37.0902, 'lon' => -95.7129],
            'usa'               => ['lat' => 37.0902, 'lon' => -95.7129],
            'new york, usa'     => ['lat' => 40.7128, 'lon' => -74.0060],

            // Canada
            'canada'            => ['lat' => 56.1304, 'lon' => -106.3468],

            // Egypt
            'egypt'             => ['lat' => 26.8206, 'lon' => 30.8025],
            'cairo, egypt'      => ['lat' => 30.0444, 'lon' => 31.2357],

            // Iran
            'iran'              => ['lat' => 32.4279, 'lon' => 53.6880],
            'tehran, iran'      => ['lat' => 35.6892, 'lon' => 51.3890],

            // Saudi Arabia
            'saudi arabia'      => ['lat' => 23.8859, 'lon' => 45.0792],
            'riyadh, saudi arabia' => ['lat' => 24.7136, 'lon' => 46.6753],
            'jeddah, saudi arabia' => ['lat' => 21.4858, 'lon' => 39.1925],

            // UAE
            'uae'               => ['lat' => 23.4241, 'lon' => 53.8478],
            'dubai, uae'        => ['lat' => 25.2048, 'lon' => 55.2708],
            'abu dhabi, uae'    => ['lat' => 24.4539, 'lon' => 54.3773],

            // Morocco
            'morocco'           => ['lat' => 31.7917, 'lon' => -7.0926],

            // Nigeria
            'nigeria'           => ['lat' => 9.0820, 'lon' => 8.6753],
            'lagos, nigeria'    => ['lat' => 6.5244, 'lon' => 3.3792],

            // Australia
            'australia'         => ['lat' => -25.2744, 'lon' => 133.7751],
        ];
    }
}