<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        // TODO: Implement Product model and CRUD
        // For now, return empty state
        return view('admin.products.index', [
            'products' => collect([]),
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // TODO: Implement product creation
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        // TODO: Implement product editing
        return view('admin.products.edit', ['product' => null]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement product update
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy($id)
    {
        // TODO: Implement product deletion
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
