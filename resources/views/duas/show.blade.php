@extends('layouts.app')
@section('title', $dua->title_en)

@section('content')
<div class="pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <a href="{{ route('duas.index') }}" class="text-primary-600 hover:underline mb-6 inline-block">&larr; Back to Library</a>
    
    <div class="card p-8 md:p-12 relative overflow-hidden">
        
        <div class="flex justify-between items-start mb-8 relative z-10">
            <span class="badge-green">{{ $dua->category->name_en }}</span>
            <form action="{{ route('duas.bookmark', $dua->id) }}" method="POST">
                @csrf                            <button type="submit" class="p-2 rounded-full {{ $isBookmarked ? 'bg-primary-500 text-white' : 'bg-dark-100 text-muted' }} hover:scale-110 transition" aria-label="Toggle bookmark">
                                    <svg class="w-5 h-5" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                </button>
            </form>
        </div>

        <h1 class="text-3xl font-black text-heading mb-2 relative z-10">{{ $dua->title_en }}</h1>
        @if($dua->title_ur)
            <p class="urdu text-xl text-muted mb-8 relative z-10" style="font-weight:700">{{ $dua->title_ur }}</p>
        @endif
        
        <div class="bg-surface p-6 rounded-2xl border border-border mb-8 relative z-10">
            <p class="arabic text-2xl md:text-4xl text-primary-600 leading-loose text-right mb-6" style="font-weight:400">{{ $dua->arabic_text }}</p>
        </div>

        <div class="space-y-6 relative z-10">
            <div>
                <h3 class="text-primary-600 font-bold mb-2">Transliteration</h3>
                <p class="text-heading text-lg italic">{{ $dua->transliteration }}</p>
            </div>
            <div>
                <h3 class="text-primary-600 font-bold mb-2">English Translation</h3>
                <p class="text-body">{{ $dua->translation_en }}</p>
            </div>
            @if($dua->translation_ur)
                <div>
                    <h3 class="text-primary-600 font-bold mb-2">اردو ترجمہ</h3>
                    <p class="text-body text-lg leading-loose" style="direction: rtl; text-align: right;">{{ $dua->translation_ur }}</p>
                </div>
            @endif
            @if($dua->reference)
                <div class="pt-4 border-t border-border">
                    <p class="text-muted text-sm">Reference: {{ $dua->reference }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection