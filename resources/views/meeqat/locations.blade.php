@extends('layouts.app')
@section('title', 'All Meeqat Locations')

@section('content')

{{-- Page Header --}}
<div class="relative pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-20 left-1/4 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>

    <div class="container-app relative">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">Meeqat Locations</span>
        </nav>

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/15 border border-primary-500/30 text-primary-400 text-sm font-semibold mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                5 Mawaqit-e-Ihram
            </div>
            <h1 class="section-title">All <span class="text-primary-600">Meeqat Locations</span></h1>
            <p class="section-subtitle max-w-xl mx-auto">
                The five designated stations where pilgrims enter the state of Ihram for Hajj or Umrah
            </p>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="bg-background py-10 pb-20">
    <div class="container-app">

        {{-- Meeqat Cards --}}
        <div class="space-y-6">
            @foreach($locations as $index => $loc)
                <div class="card overflow-hidden animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="grid grid-cols-1 md:grid-cols-4">

                        {{-- Number --}}
                        <div class="md:col-span-1 p-8 flex flex-col items-center justify-center text-center border-b md:border-b-0 md:border-r border-border"
                             style="background: linear-gradient(135deg, {{ $loc->color }}12, transparent);">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-3" style="background: {{ $loc->color }}15; border: 1px solid {{ $loc->color }}30;">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" style="color: {{ $loc->color }};" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                            <div class="text-5xl font-black" style="color: {{ $loc->color }}">{{ $index + 1 }}</div>
                            <div class="text-muted text-xs uppercase tracking-widest mt-1">Meeqat</div>
                        </div>

                        {{-- Details --}}
                        <div class="md:col-span-3 p-8">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-5">
                                <div>
                                    <h2 class="text-2xl font-black text-heading mb-1">{{ $loc->name_en }}</h2>
                                    <p class="arabic text-xl mb-1" style="color: {{ $loc->color }}">{{ $loc->name_ar }}</p>
                                    @if($loc->name_ur)
                                        <p class="urdu text-muted">{{ $loc->name_ur }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <a href="{{ $loc->google_maps_url }}" target="_blank" class="btn btn-secondary btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        Maps
                                    </a>
                                    <a href="{{ route('meeqat.finder') }}" class="btn btn-primary btn-sm">
                                        Distance Check
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-muted text-xs uppercase tracking-wider mb-2">Description</p>
                                    <p class="text-body text-sm leading-relaxed">{{ $loc->description }}</p>
                                    @if($loc->description_ur)
                                        <p class="urdu text-muted text-sm leading-loose mt-3">{{ $loc->description_ur }}</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-muted text-xs uppercase tracking-wider mb-2">For Pilgrims From</p>
                                    <p class="text-body text-sm leading-relaxed mb-4">{{ $loc->for_pilgrims_from }}</p>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="p-3 rounded-xl bg-surface border border-border">
                                            <p class="text-muted text-xs">Latitude</p>
                                            <p class="text-heading font-mono font-bold">{{ $loc->latitude }}°</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-surface border border-border">
                                            <p class="text-muted text-xs">Longitude</p>
                                            <p class="text-heading font-mono font-bold">{{ $loc->longitude }}°</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="text-center mt-12">
            <a href="{{ route('meeqat.finder') }}" class="btn btn-primary btn-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Find My Nearest Meeqat
            </a>
        </div>
    </div>
</div>

@endsection
