@extends('layouts.admin')
@section('title', isset($niyat) ? 'Edit Niyat' : 'Add Niyat')
@section('page_title', isset($niyat) ? 'Edit Niyat' : 'Add New Niyat')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <form action="{{ isset($niyat) ? route('admin.niyat.update', $niyat) : route('admin.niyat.store') }}"
              method="POST">
            @csrf
            @if(isset($niyat)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Type <span class="text-red-500">*</span></label>
                    <select name="type" class="form-select">
                        @foreach(['hajj' => 'Hajj', 'umrah' => 'Umrah', 'tawaf' => 'Tawaf', 'sai' => 'Sai', 'other' => 'Other'] as $val => $label)
                            <option value="{{ $val }}" {{ old('type', $niyat->type ?? '') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_en" class="form-input"
                           placeholder="e.g. Niyat for Umrah"
                           value="{{ old('title_en', $niyat->title_en ?? '') }}">
                    @error('title_en') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label">Arabic Text <span class="text-red-500">*</span></label>
                <textarea name="arabic_text" rows="3"
                          class="form-textarea arabic text-right text-xl leading-loose"
                          dir="rtl"
                          placeholder="عربی متن یہاں لکھیں...">{{ old('arabic_text', $niyat->arabic_text ?? '') }}</textarea>
                @error('arabic_text') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="form-label">Transliteration (Roman)</label>
                <textarea name="transliteration" rows="2" class="form-textarea"
                          placeholder="e.g. Labbayk Allahumma Umratan...">{{ old('transliteration', $niyat->transliteration ?? '') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="form-label">Translation (English)</label>
                <textarea name="translation_en" rows="2" class="form-textarea"
                          placeholder="English translation...">{{ old('translation_en', $niyat->translation_en ?? '') }}</textarea>
            </div>

            <div class="flex items-center gap-5 mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer"
                           {{ old('is_active', $niyat->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-heading font-medium text-sm">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">
                    {{ isset($niyat) ? 'Update Niyat' : 'Create Niyat' }}
                </button>
                <a href="{{ route('admin.niyat.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
