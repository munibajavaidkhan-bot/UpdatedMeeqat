@extends('layouts.app')
@section('title', $niyat->title_en . ' - Niyat')

@section('content')
<div class="pt-32 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <a href="{{ route('niyat.index') }}" class="inline-flex items-center gap-2 text-muted hover:text-primary-600 text-sm mb-8 transition-all duration-200 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Niyat
    </a>

    <div class="card overflow-hidden animate-slide-up">
        <div class="p-8 md:p-12">
            {{-- Type Badge --}}
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium 
                         bg-primary-500/10 border border-primary-500/25 text-primary-400 mb-6">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ ucfirst($niyat->type) }}
            </span>

            {{-- Title --}}
            <h1 class="text-3xl md:text-4xl font-black text-heading mb-8">{{ $niyat->title_en }}</h1>

            {{-- Arabic Text --}}
            <div class="card p-6 mb-6 border-r-4 border-r-primary-500 bg-gradient-to-l from-primary-50/30 to-transparent">
                <h3 class="text-primary-600 font-bold mb-4 flex items-center justify-end gap-2">
                    Arabic Text
                </h3>
                <p class="arabic text-2xl md:text-3xl text-primary-600 text-right leading-loose" style="font-weight:400">{{ $niyat->arabic_text }}</p>
            </div>

            {{-- Transliteration --}}
            @if($niyat->transliteration)
                <div class="card p-6 mb-6 border-l-4 border-l-primary-500">
                    <h3 class="text-primary-600 font-bold mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        Transliteration
                    </h3>
                    <p class="text-heading text-lg italic">{{ $niyat->transliteration }}</p>
                </div>
            @endif

            {{-- Translation --}}
            @if($niyat->translation_en)
                <div class="card p-6 border-l-4 border-l-primary-500">
                    <h3 class="text-primary-600 font-bold mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                        Translation
                    </h3>
                    <p class="text-body leading-relaxed">{{ $niyat->translation_en }}</p>
                </div>
            @endif

            {{-- Urdu Translation --}}
            @if($niyat->translation_ur)
                <div class="card p-6 mt-6 border-r-4 border-r-primary-500">
                    <h3 class="text-primary-600 font-bold mb-3 flex items-center justify-end gap-2">
                        Urdu Translation
                    </h3>
                    <p class="urdu text-xl text-right leading-loose">{{ $niyat->translation_ur }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mt-8 animate-fade-in" style="animation-delay: 0.2s">
        <a href="{{ route('niyat.index') }}" class="btn btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            All Niyat
        </a>
    </div>
</div>
@endsection
