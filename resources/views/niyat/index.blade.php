@extends('layouts.app')
@section('title', 'Niyat (Intentions)')

@section('content')
<div class="pt-32 pb-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <div class="flex items-center justify-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-glow-green">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h1 class="text-4xl font-black text-white">Niyat <span class="text-primary-400">(Intentions)</span></h1>
        </div>
        <p class="text-dark-400 text-center">Find correct intentions for your rituals</p>
    </div>

    <div class="space-y-12">
        @foreach($niyats as $type => $group)
            <div>
                <h2 class="text-2xl font-bold text-heading uppercase tracking-wider mb-6 border-b border-border pb-2">{{ $type }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($group as $niyat)
                        <div class="card p-6">
                            <h3 class="text-lg font-bold text-heading mb-4">{{ $niyat->title_en }}</h3>
                            <p class="arabic text-2xl text-primary-600 text-right mb-4">{{ $niyat->arabic_text }}</p>
                            <p class="text-heading italic mb-2">{{ $niyat->transliteration }}</p>
                            <p class="text-muted text-sm">{{ $niyat->translation_en }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection