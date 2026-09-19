@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-primary-100">
            <div class="w-12 h-12 rounded-2xl bg-primary-50 border border-primary-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-heading font-heading font-bold text-xl">Edit Product</p>
                <p class="text-muted text-sm mt-1">Update product details</p>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product->id ?? 1) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="sm:col-span-2">
                    <label class="form-label">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ $product->name ?? '' }}" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-textarea">{{ $product->description ?? '' }}</textarea>
                </div>
                <div>
                    <label class="form-label">Price ($) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" class="form-input" step="0.01" min="0" value="{{ $product->price ?? '' }}" required>
                </div>
                <div>
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-input" min="0" value="{{ $product->stock ?? '' }}">
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
                        <option value="1" {{ ($product->is_active ?? true) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !($product->is_active ?? true) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
