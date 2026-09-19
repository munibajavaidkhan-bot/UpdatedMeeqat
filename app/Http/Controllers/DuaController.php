<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Dua;
use Illuminate\Http\Request;

class DuaController extends Controller {
    public function index(Request $request) {
        $categories = Category::where('is_active', true)->withCount('duas')->get();
        
        $query = Dua::where('is_active', true)->with('category');
        
        // Category filter
        if ($request->has('category') && $request->category > 0) {
            $query->where('category_id', $request->category);
        }
        
        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%$search%")
                  ->orWhere('translation_en', 'like', "%$search%")
                  ->orWhere('translation_ur', 'like', "%$search%");
            });
        }
        
        $duas = $query->paginate(12);
        
        return view('duas.index', compact('categories', 'duas'));
    }

    public function show($id) {
        $dua = Dua::with('category')->findOrFail($id);
        $isBookmarked = auth()->check() ? auth()->user()->bookmarkedDuas()->where('dua_id', $id)->exists() : false;
        
        return view('duas.show', compact('dua', 'isBookmarked'));
    }

    public function category(string $slug) {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $duas = Dua::where('is_active', true)
            ->where('category_id', $category->id)
            ->with('category')
            ->paginate(12);
        $categories = Category::where('is_active', true)->withCount('duas')->get();
        $activeCategory = $category->id;
        
        return view('duas.index', compact('categories', 'duas', 'activeCategory'));
    }

    public function bookmark($id) {
        if (!auth()->check()) { return back()->with('error', 'Please login to bookmark.'); }
        
        $user = auth()->user();
        if ($user->bookmarkedDuas()->where('dua_id', $id)->exists()) {
            $user->bookmarkedDuas()->detach($id);
            return back()->with('success', 'Bookmark removed!');
        } else {
            $user->bookmarkedDuas()->attach($id);
            return back()->with('success', 'Dua bookmarked!');
        }
    }

    public function removeBookmark($id) {
        if (!auth()->check()) { return back()->with('error', 'Please login first.'); }
        auth()->user()->bookmarkedDuas()->detach($id);
        return back()->with('success', 'Bookmark removed!');
    }
}