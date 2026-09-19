<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dua;
use App\Models\Category;
use Illuminate\Http\Request;

class DuaController extends Controller {

    public function index(Request $request) {
        $query = Dua::with('category');

        if ($request->search) {
            $query->where('title_en', 'like', "%{$request->search}%");
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $duas       = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.duas.index', compact('duas', 'categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.duas.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'title_en'        => 'required|string|max:200',
            'arabic_text'     => 'required|string',
            'transliteration' => 'nullable|string',
            'translation_en'  => 'nullable|string',
            'reference'       => 'nullable|string|max:255',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
        ]);

        Dua::create($request->only([
            'category_id', 'title_en', 'title_ur', 'arabic_text',
            'transliteration', 'translation_en', 'translation_ur',
            'reference', 'is_featured', 'is_active',
        ]));

        return redirect()->route('admin.duas.index')
            ->with('success', 'Dua created successfully!');
    }

    public function edit(Dua $dua) {
        $categories = Category::all();
        return view('admin.duas.edit', compact('dua', 'categories'));
    }

    public function update(Request $request, Dua $dua) {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title_en'    => 'required|string|max:200',
            'arabic_text' => 'required|string',
        ]);

        $dua->update($request->only([
            'category_id', 'title_en', 'title_ur', 'arabic_text',
            'transliteration', 'translation_en', 'translation_ur',
            'reference', 'is_featured', 'is_active',
        ]));

        return redirect()->route('admin.duas.index')
            ->with('success', 'Dua updated successfully!');
    }

    public function destroy(Dua $dua) {
        $dua->delete();
        return redirect()->route('admin.duas.index')
            ->with('success', 'Dua deleted!');
    }
}