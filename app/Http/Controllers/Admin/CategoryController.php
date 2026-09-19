<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {

    public function index() {
        $categories = Category::withCount('duas')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name_en' => 'required|string|max:100',
            'icon'    => 'nullable|string|max:10',
        ]);

        Category::create([
            'name_en'  => $request->name_en,
            'name_ar'  => $request->name_ar,
            'slug'     => Str::slug($request->name_en) . '-' . uniqid(),
            'icon'     => $request->icon ?? '📂',
            'is_active'=> true,
        ]);

        return back()->with('success', 'Category created!');
    }

    public function update(Request $request, Category $category) {
        $category->update($request->only(['name_en', 'name_ar', 'icon', 'is_active']));
        return back()->with('success', 'Category updated!');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Category deleted!');
    }
}