<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs.
     */
    public function index()
    {
        // TODO: Implement FAQ model and CRUD
        // For now, return empty state
        return view('admin.faqs.index', [
            'faqs' => collect([]),
        ]);
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(Request $request)
    {
        // TODO: Implement FAQ creation
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully!');
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit($id)
    {
        // TODO: Implement FAQ editing
        return view('admin.faqs.edit', ['faq' => null]);
    }

    /**
     * Update the specified FAQ.
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement FAQ update
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified FAQ.
     */
    public function destroy($id)
    {
        // TODO: Implement FAQ deletion
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully!');
    }
}
