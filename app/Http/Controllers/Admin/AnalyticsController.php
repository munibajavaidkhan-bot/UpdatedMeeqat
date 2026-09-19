<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChaddarCalculation;
use App\Models\MeeqatDistanceLog;
use App\Models\User;
use App\Models\ActivityLog;

class AnalyticsController extends Controller {

    public function index() {
        // Last 30 days data
        $last30Days = now()->subDays(30);

        $stats = [
            'total_users'    => User::count(),
            'total_calcs'    => ChaddarCalculation::count(),
            'total_searches' => MeeqatDistanceLog::count(),
            'calcs_month'    => ChaddarCalculation::where('created_at', '>=', $last30Days)->count(),
            'searches_month' => MeeqatDistanceLog::where('created_at', '>=', $last30Days)->count(),
        ];

        // Most used chaddar styles
        $styleStats = ChaddarCalculation::selectRaw('style, count(*) as total')
            ->groupBy('style')
            ->pluck('total', 'style');

        // Top countries from meeqat searches
        $topCountries = MeeqatDistanceLog::whereNotNull('user_country')
            ->selectRaw('user_country, count(*) as total')
            ->groupBy('user_country')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Recent activity logs
        $recentLogs = ActivityLog::with('user')
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('admin.analytics', compact('stats', 'styleStats', 'topCountries', 'recentLogs'));
    }
}