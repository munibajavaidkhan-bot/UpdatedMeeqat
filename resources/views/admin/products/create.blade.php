@extends('layouts.admin')
@section('title', 'Add Product')
@section('page_title', 'Add New Product')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-primary-100">
            <div class="w-12 h-12 rounded-2xl bg-primary-50 border border-primary-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
            </div>
            <div>
                <p class="text-heading font-heading font-bold text-xl">Create Product</p>
                <p class="text-muted text-sm mt-1">Products database integration is coming soon. This form is a placeholder.</p>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="sm:col-span-2">
                    <label class="form-label">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-input" placeholder="e.g. Premium Ihram Set" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-textarea" placeholder="Describe your product..."></textarea>
                </div>
                <div>
                    <label class="form-label">Price ($) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" class="form-input" step="0.01" min="0" placeholder="29.99" required>
                </div>
                <div>
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-input" min="0" placeholder="100">
                </div>
                <div>
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="Ihram">Ihram</option>
                        <option value="Caps">Caps</option>
                        <option value="Books">Books</option>
                        <option value="Accessories">Accessories</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="block w-full text-sm text-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-600 file:font-medium file:cursor-pointer">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
