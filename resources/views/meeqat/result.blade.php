@extends('layouts.app')

@section('title', 'Meeqat Result — ' . ($result['nearest_meeqat']->name_en ?? ''))

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <style>
        #result-map {
            height: 350px;
            border-radius: 1rem;
        }
        .leaflet-popup-content-wrapper {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid #334155;
            border-radius: 12px;
        }
        .leaflet-popup-tip { background: #1e293b; }
        .distance-bar {
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endpush

@section('content')

<div class="relative pt-32 pb-20 min-h-screen">
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute top-20 left-1/4 w-80 h-80 bg-primary-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-1/4 w-80 h-80 bg-blue-500/3 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back --}}
        <a href="{{ route('meeqat.finder') }}" class="inline-flex items-center gap-2 text-muted hover:text-primary-600 text-sm mb-8 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Meeqat Finder
        </a>

        {{-- Header --}}
        <div class="text-center mb-8 animate-slide-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 text-primary-700 border border-primary-200 text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Nearest Meeqat Found!
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-heading">
                Your <span class="text-primary-600">Nearest Meeqat</span> Found!
            </h1>
        </div>

        {{-- Ihram Warning --}}
        @if($result['ihram_warning'])
            @php $warning = $result['ihram_warning']; @endphp
            <div class="mb-6 animate-slide-up
                {{ $warning['color'] === 'red'  ? 'alert-error'   : '' }}
                {{ $warning['color'] === 'gold' ? 'alert-warning' : '' }}
                {{ $warning['color'] === 'blue' ? 'alert-info'    : '' }}
            ">
                <span class="flex-shrink-0">
                    @if($warning['color'] === 'red')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    @elseif($warning['color'] === 'gold')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    @endif
                </span>
                <p class="font-semibold">{{ $warning['message'] }}</p>
            </div>
        @endif

        {{-- MAIN RESULT CARD --}}
        <div class="card overflow-hidden mb-6 animate-slide-up">
            <div class="h-1 w-full bg-gradient-to-r from-primary-500 via-blue-500 to-primary-500"></div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Left: Nearest Meeqat --}}
                    <div class="text-center md:text-left">
                        <p class="text-muted text-sm font-semibold uppercase tracking-wider mb-3">Nearest Meeqat</p>

                        <div class="flex items-center gap-4 mb-4 justify-center md:justify-start">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center border-2"
                                 style="background: {{ $result['nearest_meeqat']->color }}15; border-color: {{ $result['nearest_meeqat']->color }}30;">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" style="color: {{ $result['nearest_meeqat']->color }};" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-heading font-black text-xl">
                                    {{ explode('(', $result['nearest_meeqat']->name_en)[0] }}
                                </h2>
                                <p class="arabic text-secondary-600 text-lg">
                                    {{ $result['nearest_meeqat']->name_ar }}
                                </p>
                                @if($result['nearest_meeqat']->name_ur)
                                    <p class="urdu text-muted text-sm">
                                        {{ $result['nearest_meeqat']->name_ur }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="card p-4 inline-block text-sm text-muted text-left">
                            <p class="text-muted text-xs uppercase tracking-wider mb-1">For Pilgrims From</p>
                            <p class="text-heading">{{ $result['nearest_meeqat']->for_pilgrims_from }}</p>
                        </div>
                    </div>

                    {{-- Right: Distance Stats --}}
                    <div class="space-y-4">
                        {{-- Big Distance --}}
                        <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-primary-500/10 to-primary-600/5 border border-primary-500/20">
                            <p class="text-primary-500 text-xs uppercase tracking-wider mb-1">Distance</p>
                            <div class="flex items-end justify-center gap-2">
                                <span class="text-5xl font-black text-heading" id="distanceKm">0</span>
                                <span class="text-2xl text-primary-600 font-bold mb-1">km</span>
                            </div>
                            <p class="text-muted text-sm mt-1">
                                ≈ <span id="distanceMi">0</span> miles
                            </p>
                        </div>

                        {{-- Travel Time --}}
                        @if(isset($result['nearest']['travel_info']))
                            <div class="grid grid-cols-3 gap-2">
                                <div class="text-center p-3 rounded-xl bg-surface border border-border">
                                    <div class="text-primary-500 mb-1 flex justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12z"/></svg>
                                    </div>
                                    <p class="text-heading font-bold text-sm">{{ $result['nearest']['travel_info']['by_air'] }}</p>
                                    <p class="text-muted text-xs">By Air</p>
                                </div>
                                <div class="text-center p-3 rounded-xl bg-surface border border-border">
                                    <div class="text-primary-500 mb-1 flex justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0h6m-9 0H3.375A1.125 1.125 0 013 16.875V6.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-heading font-bold text-sm">{{ $result['nearest']['travel_info']['by_car'] }}</p>
                                    <p class="text-muted text-xs">By Car</p>
                                </div>
                                <div class="text-center p-3 rounded-xl bg-surface border border-border">
                                    <div class="text-primary-500 mb-1 flex justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0h6m-9 0H3.375A1.125 1.125 0 013 16.875V6.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-heading font-bold text-sm">{{ $result['nearest']['travel_info']['by_bus'] }}</p>
                                    <p class="text-muted text-xs">By Bus</p>
                                </div>
                            </div>
                        @endif

                        {{-- Direction --}}
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-surface border border-border">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 font-bold">
                                {{ $result['nearest']['direction'] ?? 'N' }}
                            </div>
                            <div>
                                <p class="text-muted text-xs">Direction</p>
                                <p class="text-heading font-semibold text-sm">
                                    {{ $result['nearest']['direction'] ?? '' }} from your location
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALL DISTANCES TABLE --}}
        <div class="card overflow-hidden mb-6 animate-slide-up" style="animation-delay: 0.1s;">
            <div class="p-5 border-b border-border">
                <h3 class="text-heading font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    Distance from All Meeqat
                </h3>
            </div>
            <div class="p-5 space-y-3">
                @foreach($result['all_distances'] as $index => $distanceData)
                    @php
                        $isNearest = $index === 0;
                        $maxDist   = $result['all_distances']->last()['distance_km'];
                        $percent   = $maxDist > 0 ? ($distanceData['distance_km'] / $maxDist) * 100 : 0;
                    @endphp
                    <div class="p-4 rounded-xl {{ $isNearest ? 'bg-primary-50 border border-primary-200' : 'bg-surface border border-border' }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                @if($isNearest)
                                    <span class="badge-green text-xs">Nearest</span>
                                @else
                                    <span class="text-muted text-sm">#{{ $index + 1 }}</span>
                                @endif
                                <div>
                                    <p class="{{ $isNearest ? 'text-heading' : 'text-heading' }} font-semibold text-sm">
                                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background: {{ $distanceData['meeqat']->color }}"></span>
                                        {{ explode('(', $distanceData['meeqat']->name_en)[0] ?? $distanceData['meeqat']->name_en }}
                                    </p>
                                    <p class="arabic text-xs text-muted">{{ $distanceData['meeqat']->name_ar }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-4">
                                <p class="{{ $isNearest ? 'text-primary-600' : 'text-heading' }} font-bold">
                                    {{ $distanceData['distance_text'] }}
                                </p>
                                <p class="text-muted text-xs">{{ number_format($distanceData['distance_mi'], 1) }} mi</p>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="progress-bar">
                            <div
                                class="distance-bar h-full rounded-full {{ $isNearest ? 'bg-gradient-to-r from-primary-500 to-primary-600' : 'bg-dark-200' }}"
                                style="width: 0%"
                                data-width="{{ $percent }}"
                            ></div>
                        </div>

                        {{-- Links --}}
                        <div class="flex gap-2 mt-3">
                            <a
                                href="{{ $distanceData['meeqat']->google_maps_url }}"
                                target="_blank"
                                class="text-xs flex items-center gap-1 text-muted hover:text-heading bg-surface hover:bg-dark-50 px-2.5 py-1.5 rounded-lg transition-colors border border-border"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                Google Maps
                            </a>
                            <a
                                href="{{ $distanceData['meeqat']->waze_url }}"
                                target="_blank"
                                class="text-xs flex items-center gap-1 text-muted hover:text-heading bg-surface hover:bg-dark-50 px-2.5 py-1.5 rounded-lg transition-colors border border-border"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                Waze
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- RESULT MAP --}}
        <div class="card overflow-hidden mb-6 animate-slide-up" style="animation-delay: 0.15s;">
            <div class="p-5 border-b border-border">
                <h3 class="text-heading font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    Location Map
            </div>
            <div id="result-map"></div>
        </div>

        {{-- Meeqat Info --}}
        <div class="card p-6 mb-6 animate-slide-up" style="animation-delay: 0.2s;">
            <h3 class="text-heading font-bold mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                {{ $result['nearest_meeqat']->name_en }} — Information
            </h3>
            <p class="text-body text-sm leading-relaxed mb-4">
                {{ $result['nearest_meeqat']->description }}
            </p>
            @if($result['nearest_meeqat']->description_ur)
                <p class="urdu text-muted text-sm leading-loose">
                    {{ $result['nearest_meeqat']->description_ur }}
                </p>
            @endif
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 animate-slide-up" style="animation-delay: 0.25s;">
            <a href="{{ route('meeqat.finder') }}" class="btn-outline text-sm py-3 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Search Again
            </a>

            <button onclick="shareResult()" class="btn-outline text-sm py-3 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                Share
            </button>

            <a href="{{ $result['nearest_meeqat']->google_maps_url }}" target="_blank" class="btn-outline text-sm py-3 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                Google Maps
            </a>

            <a href="{{ route('ihram.index') }}" class="btn-primary text-sm py-3 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                Ihram Guide
            </a>
        </div>

        {{-- Guest Prompt --}}
        @guest
            <div class="mt-8 card p-6 text-center animate-slide-up">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                    <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <h3 class="text-heading font-bold mb-2">Want to Save Your Search History?</h3>
                <p class="text-muted text-sm mb-5">Login to have all your searches automatically saved.</p>
                <div class="flex gap-3 justify-center">
                    <a href="{{ route('login') }}" class="btn-primary py-2.5 px-6 text-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn-outline py-2.5 px-6 text-sm">Register Free</a>
                </div>
            </div>
        @endguest

    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // =========================================
    // COUNTER ANIMATIONS
    // =========================================
    const targetKm = {{ $result['nearest_distance_km'] }};
    const targetMi = {{ $result['nearest']['distance_mi'] ?? 0 }};

    animateNumber('distanceKm', targetKm, 1);
    animateNumber('distanceMi', targetMi, 1);

    function animateNumber(elId, target, decimals) {
        const el  = document.getElementById(elId);
        if (!el)  return;
        let start = 0;
        const step = target / 60;
        const timer = setInterval(() => {
            start += step;
            if (start >= target) {
                el.textContent = target.toFixed(decimals);
                clearInterval(timer);
            } else {
                el.textContent = start.toFixed(decimals);
            }
        }, 20);
    }

    // =========================================
    // PROGRESS BARS ANIMATION
    // =========================================
    setTimeout(() => {
        document.querySelectorAll('.distance-bar').forEach(bar => {
            bar.style.width = bar.dataset.width + '%';
        });
    }, 500);

    // =========================================
    // RESULT MAP
    // =========================================
    const map = L.map('result-map').setView([
        {{ ($log->user_latitude + $result['nearest_meeqat']->latitude) / 2 }},
        {{ ($log->user_longitude + $result['nearest_meeqat']->longitude) / 2 }}
    ], 4);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // User location marker
    const userIcon = L.divIcon({
        html: `<div style="width:16px;height:16px;background:#3b82f6;border-radius:50%;border:3px solid white;box-shadow:0 0 0 5px rgba(59,130,246,0.3);"></div>`,
        className: '',
        iconSize: [22, 22],
        iconAnchor: [11, 11],
    });

    L.marker([{{ $log->user_latitude }}, {{ $log->user_longitude }}], { icon: userIcon })
        .addTo(map)
        .bindPopup('<strong>Your Location</strong>')
        .openPopup();

    // All Meeqat markers
    @foreach($meeqatLocations as $meeqat)
        @php $isNearest = $meeqat->id === $result['nearest_meeqat']->id; @endphp
        L.marker([{{ $meeqat->latitude }}, {{ $meeqat->longitude }}], {
            icon: L.divIcon({
                html: `<div style="
                    width: {{ $isNearest ? '36' : '28' }}px;
                    height: {{ $isNearest ? '36' : '28' }}px;
                    background: {{ $meeqat->color }};
                    border-radius: 50% 50% 50% 0;
                    transform: rotate(-45deg);
                    border: {{ $isNearest ? '4' : '2' }}px solid white;
                    box-shadow: 0 4px 16px rgba(0,0,0,0.5);
                "></div>`,
                className: '',
                iconSize: [{{ $isNearest ? 36 : 28 }}, {{ $isNearest ? 36 : 28 }}],
                iconAnchor: [{{ $isNearest ? 18 : 14 }}, {{ $isNearest ? 36 : 28 }}],
                popupAnchor: [0, -40],
            })
        })
        .addTo(map)
        .bindPopup(`
            <strong style="color: {{ $meeqat->color }}">{{ $isNearest ? 'NEAREST — ' : '' }}{{ $meeqat->name_en }}</strong><br>
            <span style="font-family:serif;direction:rtl;display:block;text-align:right;color:#fbbf24;margin:4px 0;">{{ $meeqat->name_ar }}</span>
            <small style="color:#94a3b8;">{{ $meeqat->for_pilgrims_from }}</small>
        `);
    @endforeach

    // Line connecting user to nearest Meeqat
    const line = L.polyline([
        [{{ $log->user_latitude }}, {{ $log->user_longitude }}],
        [{{ $result['nearest_meeqat']->latitude }}, {{ $result['nearest_meeqat']->longitude }}]
    ], {
        color: '#22c55e',
        weight: 2,
        opacity: 0.7,
        dashArray: '8, 6',
    }).addTo(map);

    // Fit bounds to show both points
    map.fitBounds(line.getBounds(), { padding: [40, 40] });
});

// =========================================
// SHARE
// =========================================
function shareResult() {
    const data = {
        title: 'Meeqat.io — Distance Finder',
        text: `My nearest Meeqat: {{ $result['nearest_meeqat']->name_en }} — {{ number_format($result['nearest_distance_km'], 1) }} km away. Check your Meeqat:`,
        url: '{{ route("meeqat.finder") }}'
    };
    if (navigator.share) {
        navigator.share(data);
    } else {
        navigator.clipboard.writeText(data.text + '\n' + data.url);
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message: 'Result copied!', type: 'success' }
        }));
    }
}
</script>
@endpush