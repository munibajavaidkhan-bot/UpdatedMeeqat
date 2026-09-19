@extends('layouts.admin')
@section('title', isset($dua) ? 'Edit Dua' : 'Add Dua')
@section('page_title', isset($dua) ? 'Edit Dua' : 'Add New Dua')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm p-8">
        <form action="{{ isset($dua) ? route('admin.duas.update', $dua) : route('admin.duas.store') }}"
              method="POST">
            @csrf
            @if(isset($dua)) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="form-label">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $dua->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name_en }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title_en" class="form-input" placeholder="Dua title..."
                           value="{{ old('title_en', $dua->title_en ?? '') }}">
                    @error('title_en') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label">Arabic Text <span class="text-red-500">*</span></label>
                <textarea name="arabic_text" rows="4"
                          class="form-textarea arabic text-right text-xl leading-loose"
                          dir="rtl" placeholder="عربی متن یہاں لکھیں...">{{ old('arabic_text', $dua->arabic_text ?? '') }}</textarea>
                @error('arabic_text') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="form-label">Transliteration (Roman)</label>
                <textarea name="transliteration" rows="3" class="form-textarea"
                          placeholder="e.g. Rabbana atina fid-dunya hasanatan...">{{ old('transliteration', $dua->transliteration ?? '') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="form-label">Translation (English)</label>
                <textarea name="translation_en" rows="3" class="form-textarea"
                          placeholder="English translation...">{{ old('translation_en', $dua->translation_en ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                <div>
                    <label class="form-label">Reference (Quran/Hadith)</label>
                    <input type="text" name="reference" class="form-input" placeholder="e.g. Quran 2:201"
                           value="{{ old('reference', $dua->reference ?? '') }}">
                </div>
                <div class="flex items-end gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer"
                               {{ old('is_featured', $dua->is_featured ?? false) ? 'checked' : '' }}>
                        <span class="text-heading font-medium text-sm">Featured</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-primary-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer"
                               {{ old('is_active', $dua->is_active ?? true) ? 'checked' : '' }}>
                        <span class="text-heading font-medium text-sm">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">{{ isset($dua) ? 'Update Dua' : 'Create Dua' }}</button>
                <a href="{{ route('admin.duas.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
