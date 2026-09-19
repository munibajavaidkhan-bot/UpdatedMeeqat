@extends('layouts.admin')
@section('title', 'Edit FAQ')
@section('page_title', 'Edit FAQ')

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
                <p class="text-heading font-heading font-bold text-xl">Edit FAQ</p>
                <p class="text-muted text-sm mt-1">Update FAQ details</p>
            </div>
        </div>

        <form action="{{ route('admin.faqs.update', $faq->id ?? 1) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-5 mb-5">
                <div>
                    <label class="form-label">Question <span class="text-red-500">*</span></label>
                    <input type="text" name="question" class="form-input" value="{{ $faq->question ?? '' }}" required>
                </div>
                <div>
                    <label class="form-label">Answer <span class="text-red-500">*</span></label>
                    <textarea name="answer" rows="5" class="form-textarea" required>{{ $faq->answer ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="General">General</option>
                            <option value="Ihram">Ihram</option>
                            <option value="Meeqat">Meeqat</option>
                            <option value="Duas">Duas</option>
                            <option value="Chaddar">Chaddar</option>
                            <option value="Hajj">Hajj</option>
                            <option value="Umrah">Umrah</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ ($faq->is_active ?? true) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !($faq->is_active ?? true) ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="h-11 px-6 rounded-xl bg-primary-500 text-white text-sm font-semibold hover:bg-primary-600 transition-all duration-200 shadow-sm inline-flex items-center justify-center">Update FAQ</button>
                <a href="{{ route('admin.faqs.index') }}" class="h-11 px-6 rounded-xl bg-white text-heading text-sm font-semibold border border-primary-200 hover:bg-primary-50 transition-all duration-200 inline-flex items-center justify-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
