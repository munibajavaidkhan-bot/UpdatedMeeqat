@extends('layouts.admin')
@section('title', isset($ihramGuide) ? 'Edit Guide' : 'Add Guide')
@section('page_title', isset($ihramGuide) ? 'Edit Ihram Guide' : 'Add New Ihram Guide')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <form action="{{ isset($ihramGuide) ? route('admin.ihram-guides.update', $ihramGuide) : route('admin.ihram-guides.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($ihramGuide)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Category <span class="text-red-500">*</span></label>
                    <select name="category" class="form-select">
                        @foreach(['general' => 'General', 'men' => 'Men', 'women' => 'Women', 'prohibited' => 'Prohibited', 'recommended' => 'Recommended'] as $val => $label)
                            <option value="{{ $val }}" {{ old('category', $ihramGuide->category ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-input"
                           value="{{ old('sort_order', $ihramGuide->sort_order ?? 0) }}">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_en" class="form-input"
                           value="{{ old('title_en', $ihramGuide->title_en ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Title (Urdu)</label>
                    <input type="text" name="title_ur" class="form-input urdu text-right" dir="rtl"
                           value="{{ old('title_ur', $ihramGuide->title_ur ?? '') }}">
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label">Content (English)</label>
                <textarea name="content_en" rows="4" class="form-textarea"
                          placeholder="Detailed description in English...">{{ old('content_en', $ihramGuide->content_en ?? '') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="form-label">Content (Urdu)</label>
                <textarea name="content_ur" rows="4" class="form-textarea urdu text-right leading-loose"
                          dir="rtl" placeholder="تفصیل اردو میں...">{{ old('content_ur', $ihramGuide->content_ur ?? '') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="form-label">Guide Image (Optional)</label>
                @if(isset($ihramGuide) && $ihramGuide->image)
                    <div class="mb-3">
                        <img src="{{ Storage::url($ihramGuide->image) }}" class="h-32 rounded-xl object-cover" alt="Current image">
                        <p class="text-muted text-xs mt-1">Current image — upload new to replace</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="block w-full text-sm text-muted file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-600 file:font-medium hover:file:bg-primary-100 file:cursor-pointer cursor-pointer">
                <p class="text-muted text-xs mt-1.5">Recommended: 800×400px, max 2MB</p>
            </div>

            <div class="flex items-center gap-5 mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer"
                           {{ old('is_active', $ihramGuide->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-heading font-medium text-sm">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">{{ isset($ihramGuide) ? 'Update Guide' : 'Create Guide' }}</button>
                <a href="{{ route('admin.ihram-guides.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
