<?php
namespace App\Http\Controllers;
use App\Models\Niyat;

class NiyatController extends Controller {
    public function index() {
        $niyats = Niyat::where('is_active', true)->get()->groupBy('type');
        return view('niyat.index', compact('niyats'));
    }

    public function show($id) {
        $niyat = Niyat::findOrFail($id);
        return view('niyat.show', compact('niyat'));
    }
}