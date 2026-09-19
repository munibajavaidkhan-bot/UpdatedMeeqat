@extends('layouts.admin')
@section('title', isset($meeqatLocation) ? 'Edit Location' : 'Add Location')
@section('page_title', isset($meeqatLocation) ? 'Edit Meeqat Location' : 'Add Meeqat Location')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <form action="{{ isset($meeqatLocation) ? route('admin.meeqat-locations.update', $meeqatLocation) : route('admin.meeqat-locations.store') }}"
              method="POST">
            @csrf
            @if(isset($meeqatLocation)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Name (English) *</label>
                    <input type="text" name="name_en" class="form-input"
                           value="{{ old('name_en', $meeqatLocation->name_en ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Name (Arabic) *</label>
                    <input type="text" name="name_ar" class="form-input arabic text-right" dir="rtl"
                           value="{{ old('name_ar', $meeqatLocation->name_ar ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Name (Urdu)</label>
                    <input type="text" name="name_ur" class="form-input"
                           value="{{ old('name_ur', $meeqatLocation->name_ur ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Latitude *</label>
                    <input type="number" name="latitude" step="0.00000001" class="form-input"
                           value="{{ old('latitude', $meeqatLocation->latitude ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Longitude *</label>
                    <input type="number" name="longitude" step="0.00000001" class="form-input"
                           value="{{ old('longitude', $meeqatLocation->longitude ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-input"
                           value="{{ old('sort_order', $meeqatLocation->sort_order ?? 0) }}">
                </div>
                <div>
                    <label class="form-label">Color (hex)</label>
                    <input type="text" name="color" class="form-input" placeholder="#22c55e"
                           value="{{ old('color', $meeqatLocation->color ?? '#22c55e') }}">
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label">For Pilgrims From</label>
                <input type="text" name="for_pilgrims_from" class="form-input"
                       placeholder="e.g. Pakistan, India, Turkey..."
                       value="{{ old('for_pilgrims_from', $meeqatLocation->for_pilgrims_from ?? '') }}">
            </div>

            <div class="mb-5">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea">{{ old('description', $meeqatLocation->description ?? '') }}</textarea>
            </div>

            <div class="flex items-center gap-4 mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer"
                           {{ old('is_active', $meeqatLocation->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-heading font-medium text-sm">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">
                    {{ isset($meeqatLocation) ? 'Update Location' : 'Create Location' }}
                </button>
                <a href="{{ route('admin.meeqat-locations.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
