<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IhramGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IhramGuideController extends Controller {

    public function index() {
        $guides = IhramGuide::orderBy('category')->orderBy('sort_order')->paginate(15);
        return view('admin.ihram-guides.index', compact('guides'));
    }

    public function create() {
        return view('admin.ihram-guides.create');
    }

    public function store(Request $request) {
        $request->validate([
            'category'   => 'required|in:men,women,general,prohibited,recommended',
            'title_en'   => 'required|string|max:200',
            'content_en' => 'nullable|string',
            'icon'       => 'nullable|string|max:10',
            'image'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ihram-guides', 'public');
        }

        IhramGuide::create($data);
        return redirect()->route('admin.ihram-guides.index')->with('success', 'Guide created!');
    }

    public function edit(IhramGuide $ihramGuide) {
        return view('admin.ihram-guides.edit', compact('ihramGuide'));
    }

    public function update(Request $request, IhramGuide $ihramGuide) {
        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            if ($ihramGuide->image) {
                Storage::disk('public')->delete($ihramGuide->image);
            }
            $data['image'] = $request->file('image')->store('ihram-guides', 'public');
        }

        $ihramGuide->update($data);
        return redirect()->route('admin.ihram-guides.index')->with('success', 'Guide updated!');
    }

    public function destroy(IhramGuide $ihramGuide) {
        if ($ihramGuide->image) {
            Storage::disk('public')->delete($ihramGuide->image);
        }
        $ihramGuide->delete();
        return redirect()->route('admin.ihram-guides.index')->with('success', 'Guide deleted!');
    }
}