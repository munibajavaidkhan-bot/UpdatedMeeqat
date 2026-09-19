<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Niyat;
use Illuminate\Http\Request;

class NiyatController extends Controller {

    public function index() {
        $niyats = Niyat::latest()->paginate(15);
        return view('admin.niyat.index', compact('niyats'));
    }

    public function create() {
        return view('admin.niyat.create');
    }

    public function store(Request $request) {
        $request->validate([
            'type'       => 'required|in:hajj,umrah,tawaf,sai,other',
            'title_en'   => 'required|string|max:200',
            'arabic_text'=> 'required|string',
        ]);
        Niyat::create($request->only([
            'type', 'title_en', 'arabic_text',
            'transliteration', 'translation_en', 'translation_ur', 'is_active',
        ]));
        return redirect()->route('admin.niyat.index')->with('success', 'Niyat created!');
    }

    public function edit(Niyat $niyat) {
        return view('admin.niyat.edit', compact('niyat'));
    }

    public function update(Request $request, Niyat $niyat) {
        $request->validate([
            'type'       => 'required|in:hajj,umrah,tawaf,sai,other',
            'title_en'   => 'required|string|max:200',
            'arabic_text'=> 'required|string',
        ]);
        $niyat->update($request->only([
            'type', 'title_en', 'arabic_text',
            'transliteration', 'translation_en', 'translation_ur', 'is_active',
        ]));
        return redirect()->route('admin.niyat.index')->with('success', 'Niyat updated!');
    }

    public function destroy(Niyat $niyat) {
        $niyat->delete();
        return redirect()->route('admin.niyat.index')->with('success', 'Niyat deleted!');
    }
}