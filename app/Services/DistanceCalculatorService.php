<?php

namespace App\Services;

use App\Models\MeeqatLocation;
use Illuminate\Support\Collection;

class DistanceCalculatorService
{
    // Earth radius in KM
    private const EARTH_RADIUS_KM = 6371.0;

    // =========================================
    // HAVERSINE FORMULA
    // =========================================

    /**
     * Do points ke beech distance calculate karo (KM mein)
     */
    public function haversine(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(self::EARTH_RADIUS_KM * $c, 2);
    }

    // =========================================
    // MAIN CALCULATION
    // =========================================

    /**
     * User location se tamam Meeqat distances calculate karo
     */
    public function calculateFromUserLocation(
        float $userLat,
        float $userLon
    ): array {
        $meeqatLocations = MeeqatLocation::active()->get();

        if ($meeqatLocations->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Meeqat locations database mein nahi hain.',
            ];
        }

        // Har Meeqat ka distance calculate karo
        $distances = $meeqatLocations->map(function (MeeqatLocation $meeqat) use ($userLat, $userLon) {
            $distanceKm = $this->haversine(
                $userLat, $userLon,
                $meeqat->latitude, $meeqat->longitude
            );

            return [
                'meeqat'        => $meeqat,
                'meeqat_id'     => $meeqat->id,
                'distance_km'   => $distanceKm,
                'distance_mi'   => round($distanceKm * 0.621371, 2),
                'distance_text' => $this->formatDistance($distanceKm),
                'travel_info'   => $this->getTravelInfo($distanceKm),
                'direction'     => $this->getCompassDirection($userLat, $userLon, $meeqat->latitude, $meeqat->longitude),
            ];
        });

        // Distance ke hisab se sort karo (nearest first)
        $sorted = $distances->sortBy('distance_km')->values();

        // Nearest Meeqat
        $nearest = $sorted->first();

        return [
            'success'             => true,
            'user_lat'            => $userLat,
            'user_lon'            => $userLon,
            'nearest'             => $nearest,
            'all_distances'       => $sorted,
            'nearest_meeqat'      => $nearest['meeqat'],
            'nearest_distance_km' => $nearest['distance_km'],
            'ihram_warning'       => $this->getIhramWarning($nearest['distance_km']),
            'all_distances_array' => $sorted->map(fn($d) => [
                'id'          => $d['meeqat_id'],
                'name'        => $d['meeqat']->name_en,
                'distance_km' => $d['distance_km'],
            ])->toArray(),
        ];
    }

    // =========================================
    // HELPERS
    // =========================================

    /**
     * Distance format karo
     */
    public function formatDistance(float $km): string
    {
        if ($km < 1) {
            return round($km * 1000) . ' m';
        }
        return number_format($km, 1) . ' km';
    }

    /**
     * Travel time estimate
     */
    public function getTravelInfo(float $km): array
    {
        $roadKm = $this->estimateRoadDistance($km);

        return [
            'by_air'   => $this->travelTime($km, 700),   // real avg flight speed including procedures
            'by_car'   => $this->travelTime($roadKm, 100),
            'by_bus'   => $this->travelTime($roadKm, 80),
        ];
    }

    /**
     * Straight-line to road distance multiplier for realistic estimates
     */
    private function estimateRoadDistance(float $km): float
    {
        if ($km <= 200) {
            return $km * 1.0;
        }
        if ($km <= 500) {
            return $km * 1.3;
        }
        if ($km <= 1000) {
            return $km * 1.5;
        }
        return $km * 2.2;
    }

    private function travelTime(float $km, int $speedKmh): string
    {
        $hours   = $km / $speedKmh;
        $h       = floor($hours);
        $minutes = round(($hours - $h) * 60);

        if ($h === 0) {
            return "{$minutes} min";
        }
        if ($minutes === 0) {
            return "{$h}h";
        }
        return "{$h}h {$minutes}m";
    }

    /**
     * Compass direction calculate karo
     */
    public function getCompassDirection(
        float $fromLat,
        float $fromLon,
        float $toLat,
        float $toLon
    ): string {
        $dLon    = deg2rad($toLon - $fromLon);
        $fromLat = deg2rad($fromLat);
        $toLat   = deg2rad($toLat);

        $y = sin($dLon) * cos($toLat);
        $x = cos($fromLat) * sin($toLat) - sin($fromLat) * cos($toLat) * cos($dLon);

        $bearing = rad2deg(atan2($y, $x));
        $bearing = fmod($bearing + 360, 360);

        $directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
        $index = round($bearing / 45) % 8;

        return $directions[$index];
    }

    /**
     * Ihram warning — Meeqat qareeb hai to alert
     */
    public function getIhramWarning(float $nearestDistanceKm): ?array
    {
        if ($nearestDistanceKm <= 50) {
            return [
                'level'   => 'critical',
                'message' => '⚠️ URGENT! Aap Meeqat se sirf ' . round($nearestDistanceKm) . ' km door hain! Foran Ihram pehnen!',
                'color'   => 'red',
            ];
        }
        if ($nearestDistanceKm <= 200) {
            return [
                'level'   => 'warning',
                'message' => '⚡ Agah! Aap Meeqat se ' . round($nearestDistanceKm) . ' km door hain. Ihram ki tayari shuru karein.',
                'color'   => 'secondary',
            ];
        }
        if ($nearestDistanceKm <= 500) {
            return [
                'level'   => 'info',
                'message' => '📋 Meeqat ' . round($nearestDistanceKm) . ' km door hai. Aapke paas Ihram ki tayari ka waqt hai.',
                'color'   => 'blue',
            ];
        }

        return null;
    }

    /**
     * Bearing angle (Google Maps direction link ke liye)
     */
    public function getBearing(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLon = deg2rad($lon2 - $lon1);
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        $y = sin($dLon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);

        return fmod(rad2deg(atan2($y, $x)) + 360, 360);
    }
}