<?php
namespace App\Http\Controllers;

use App\Models\ChaddarCalculation;
use App\Models\MeeqatDistanceLog;

class UserDashboardController extends Controller {

    public function index() {
        $recentCalculations = ChaddarCalculation::where('user_id', auth()->id())
            ->latest('created_at')->take(5)->get();

        $recentSearches = MeeqatDistanceLog::where('user_id', auth()->id())
            ->with('nearestMeeqat')->latest('created_at')->take(5)->get();

        return view('user.dashboard', compact('recentCalculations', 'recentSearches'));
    }

    public function bookmarks() {
        $bookmarks = auth()->user()->bookmarkedDuas()->with('category')->get();
        return view('user.bookmarks', compact('bookmarks'));
    }

    public function history() {
        $calculations = ChaddarCalculation::where('user_id', auth()->id())
            ->latest('created_at')->paginate(10);
        $searches = MeeqatDistanceLog::where('user_id', auth()->id())
            ->with('nearestMeeqat')->latest('created_at')->paginate(10);
        return view('user.history', compact('calculations', 'searches'));
    }
}