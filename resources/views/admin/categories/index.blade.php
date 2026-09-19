@extends('layouts.admin')
@section('title', 'Categories')
@section('page_title', 'Dua Categories')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Add Form --}}
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-6">
        <h3 class="text-heading font-bold text-lg mb-5">Add New Category</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Name (English) *</label>
                <input type="text" name="name_en" class="form-input" placeholder="e.g. Tawaf" value="{{ old('name_en') }}">
            </div>
            <div>
                <label class="form-label">Name (Arabic)</label>
                <input type="text" name="name_ar" class="form-input arabic text-right" dir="rtl" placeholder="طواف" value="{{ old('name_ar') }}">
            </div>
            <button type="submit" class="w-full h-11 px-5 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">Add Category</button>
        </form>
    </div>

    {{-- Categories List --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-primary-100">
            <h3 class="text-heading font-bold text-lg">All Categories ({{ $categories->count() }})</h3>
        </div>
        <div class="overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-primary-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Category</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Arabic</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Duas</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                        <tr class="border-b border-primary-50 last:border-0 hover:bg-primary-50/30 transition-colors">
                            <td class="px-5 py-4">
                                <span class="text-heading font-medium">{{ $cat->name_en }}</span>
                            </td>
                            <td class="px-5 py-4 arabic text-primary-600">{{ $cat->name_ar }}</td>
                            <td class="px-5 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold border border-primary-200">{{ $cat->duas_count }}</span></td>
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete category?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-100 hover:border-red-500 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
