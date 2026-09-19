<?php
namespace App\Http\Controllers;

use App\Models\IhramGuide;
use Illuminate\Http\Request;

class IhramGuideController extends Controller {

    public function index(Request $request) {
        $activeFilter = $request->get('filter', 'all');

        // Single query
        $allGuides = IhramGuide::active()->get();

        // Counts from collection
        $counts = $allGuides->groupBy('category')->map->count();

        // Filter in memory
        $filteredGuides = $activeFilter !== 'all'
            ? $allGuides->where('category', $activeFilter)
            : $allGuides;

        $allGuides = $allGuides->groupBy('category');

        return view('guides.ihram', compact('allGuides', 'filteredGuides', 'activeFilter', 'counts'));
    }

    public function show(int $id) {
        $guide = IhramGuide::findOrFail($id);

        // Related guides same category se
        $related = IhramGuide::active()
            ->where('category', $guide->category)
            ->where('id', '!=', $id)
            ->take(3)
            ->get();

        return view('guides.ihram-show', compact('guide', 'related'));
    }
}