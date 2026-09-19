@extends('layouts.app')

@section('title', 'Meeqat Distance Finder')
@section('meta_description', 'Find the nearest Meeqat from your location with exact distance using GPS.')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #meeqat-map {
            height: 420px;
            border-radius: 0 0 1rem 1rem;
            z-index: 1;
        }
        .leaflet-popup-content-wrapper {
            background: #fff;
            color: #1e293b;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .leaflet-popup-tip { background: #fff; }
        .leaflet-popup-content { margin: 14px 18px; font-size: 0.85rem; line-height: 1.5; }
        .pulse-ring { animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite; }
        @keyframes pulse-ring {
            0% { transform: scale(0.5); opacity: 0.8; }
            100% { transform: scale(2); opacity: 0; }
        }
    </style>
@endpush

@section('content')

{{-- ═══════════════════════ PAGE HEADER ═══════════════════════ --}}
<div class="relative pt-32 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-10 left-1/4 w-96 h-96 rounded-full blur-3xl bg-primary-500/10 animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 rounded-full blur-3xl bg-primary-500/5 animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>

    <div class="container-app relative">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">Meeqat Distance Finder</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center flex-shrink-0 shadow-glow-green">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-heading font-black text-white leading-tight" style="font-size: clamp(1.8rem, 3.5vw, 2.8rem);">
                        Meeqat <span class="text-primary-400">Distance Finder</span>
                    </h1>
                    <p class="text-dark-300 mt-1 text-body">Find the nearest Meeqat boundary from your location</p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-primary-500/15 border border-primary-500/30">
                    <span class="font-heading font-extrabold text-xl text-primary-400">{{ number_format($totalSearches) }}</span>
                    <span class="text-dark-400 text-body-sm">Total Searches</span>
                </div>
                <a href="{{ route('meeqat.locations') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-body-sm font-semibold text-dark-400 border border-dark-700/50 bg-dark-800/60 hover:border-primary-500/50 hover:text-primary-400 hover:bg-primary-500/10 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    All Meeqat
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════ MAIN CONTENT ═══════════════════════ --}}
<div class="bg-background py-10 pb-20">
<div class="container-app"
     x-data="{
        method: 'gps',
        gpsLoading: false,
        gpsError: '',
        gpsSuccess: false,
        gpsAccuracy: null,
        gpsWatchId: null,
        lat: '',
        lon: '',
        formReady: false,

        // Detect GPS location with best-available accuracy.
        // Uses watchPosition for a short window and keeps the most
        // accurate fix seen (accuracy = radius in meters, smaller is better),
        // instead of just taking whatever the first getCurrentPosition call returns.
        async detectGPS() {
            this.gpsLoading  = true;
            this.gpsError    = '';
            this.gpsSuccess  = false;
            this.gpsAccuracy = null;

            if (!navigator.geolocation) {
                this.gpsError   = 'Your browser does not support GPS. Use Manual mode instead.';
                this.gpsLoading = false;
                this.tryIpFallback();
                return;
            }

            // If page isn't served over HTTPS (and isn't localhost), most
            // browsers silently block geolocation — warn the user clearly.
            const isSecure = window.isSecureContext || location.hostname === 'localhost' || location.hostname === '127.0.0.1';
            if (!isSecure) {
                this.gpsError   = 'GPS ke liye secure (HTTPS) connection zaroori hai. Manual mode use karein.';
                this.gpsLoading = false;
                return;
            }

            const options = {
                enableHighAccuracy: true, // force GPS chip instead of coarse Wi-Fi/IP triangulation
                timeout: 15000,
                maximumAge: 0,             // never reuse a stale cached fix
            };

            let bestFix   = null;
            let settled   = false;
            const REFINE_WINDOW_MS = 4000; // keep listening briefly to let GPS accuracy improve

            const finish = () => {
                if (settled) return;
                settled = true;

                if (this.gpsWatchId !== null) {
                    navigator.geolocation.clearWatch(this.gpsWatchId);
                    this.gpsWatchId = null;
                }

                if (!bestFix) {
                    this.gpsError   = 'Location detect nahi ho saki. Please try again ya Manual mode use karein.';
                    this.gpsLoading = false;
                    this.tryIpFallback();
                    return;
                }

                this.lat         = bestFix.coords.latitude.toFixed(6);
                this.lon         = bestFix.coords.longitude.toFixed(6);
                this.gpsAccuracy = Math.round(bestFix.coords.accuracy || 0);
                this.gpsSuccess  = true;
                this.gpsLoading  = false;
                this.formReady   = true;
                this.updateUserMarker(this.lat, this.lon);
            };

            const onPosition = (position) => {
                // Keep whichever reading has the smallest accuracy radius (most precise)
                if (!bestFix || position.coords.accuracy < bestFix.coords.accuracy) {
                    bestFix = position;
                }
                // Good enough (within ~30m) — no need to keep waiting
                if (position.coords.accuracy <= 30) {
                    finish();
                }
            };

            const onError = (error) => {
                const errors = {
                    1: 'Location permission denied. Please allow in Settings or use Manual mode.',
                    2: 'Location unavailable. Try again or use Manual mode.',
                    3: 'Request timeout. Please try again.',
                };
                if (!bestFix) {
                    this.gpsError   = errors[error.code] || 'Unknown GPS error.';
                    this.gpsLoading = false;
                    if (this.gpsWatchId !== null) {
                        navigator.geolocation.clearWatch(this.gpsWatchId);
                        this.gpsWatchId = null;
                    }
                    settled = true;
                    if (error.code === 1 || error.code === 2) {
                        this.tryIpFallback();
                    }
                } else {
                    finish();
                }
            };

            this.gpsWatchId = navigator.geolocation.watchPosition(onPosition, onError, options);
            setTimeout(finish, REFINE_WINDOW_MS);
        },

        // Fallback for when GPS is denied/unavailable: approximate the
        // user's location from their IP address so distance can still be
        // estimated (city-level accuracy, clearly labelled as approximate).
        async tryIpFallback() {
            try {
                const res  = await fetch('https://ipapi.co/json/');
                if (!res.ok) return;
                const data = await res.json();
                if (data && data.latitude && data.longitude) {
                    this.lat         = parseFloat(data.latitude).toFixed(6);
                    this.lon         = parseFloat(data.longitude).toFixed(6);
                    this.gpsAccuracy = null; // unknown/approximate — IP geolocation, not GPS
                    this.gpsSuccess  = true;
                    this.formReady   = true;
                    this.gpsError    = 'Exact GPS na milne ki wajah se approximate (IP-based) location use ki gayi hai — behtar accuracy ke liye Manual mode ya GPS permission allow karein.';
                    this.updateUserMarker(this.lat, this.lon);
                }
            } catch (e) {
                // Silent fail — user still has Manual mode available
            }
        },

        updateUserMarker(lat, lon) {
            if (window.meeqatMap && window.userMarker) {
                window.userMarker.setLatLng([lat, lon]).addTo(window.meeqatMap);
                window.meeqatMap.flyTo([lat, lon], 5, { duration: 1.5 });
            }
        }
     }"
>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- =============================================
            LEFT: FORM SECTION
        ============================================= --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Detection Method Card --}}
            <div class="card overflow-hidden">

                {{-- Tabs --}}
                <div class="flex border-b border-border bg-dark-50">
                    <button @click="method = 'gps'"
                            class="flex-1 py-4 text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2"
                            :class="method === 'gps'
                                ? 'text-primary-600 border-b-2 border-primary-500 bg-surface'
                                : 'text-muted border-b-2 border-transparent bg-transparent'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        GPS Auto
                    </button>
                    <button @click="method = 'manual'"
                            class="flex-1 py-4 text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2"
                            :class="method === 'manual'
                                ? 'text-primary-600 border-b-2 border-primary-500 bg-surface'
                                : 'text-muted border-b-2 border-transparent bg-transparent'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.172 1.075l-2.357 1.433.838-2.339a4.5 4.5 0 011.075-1.172l10.15-10.15z"/>
                        </svg>
                        Manual
                    </button>
                </div>

                <div class="card-body">
                    <form action="{{ route('meeqat.calculate') }}" method="POST" id="meeqatForm">
                        @csrf
                        <input type="hidden" name="method"    :value="method">
                        <input type="hidden" name="latitude"  :value="lat">
                        <input type="hidden" name="longitude" :value="lon">

                        {{-- ── GPS Panel ── --}}
                        <div x-show="method === 'gps'" x-transition>
                            <div class="text-center py-3">

                                {{-- GPS Icon --}}
                                <div class="relative inline-flex mb-4">
                                    <div class="w-14 h-14 rounded-full bg-primary-50 border-2 border-primary-200 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                    </div>
                                    <template x-if="gpsLoading">
                                        <div class="absolute inset-0 rounded-full border-2 border-primary-500 pulse-ring"></div>
                                    </template>
                                    <template x-if="gpsSuccess">
                                        <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-primary-500 flex items-center justify-center border-2 border-surface">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </template>
                                </div>

                                {{-- Error message --}}
                                <template x-if="gpsError">
                                    <div class="bg-red-50 border border-red-200 rounded-xl p-3 flex items-start gap-2 text-left mb-4">
                                        <svg class="w-4 h-4 flex-shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-body-sm text-red-600 leading-snug" x-text="gpsError"></p>
                                    </div>
                                </template>

                                {{-- Success message --}}
                                <template x-if="gpsSuccess">
                                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 text-left mb-4">
                                        <div class="flex items-center gap-2.5 mb-2">
                                            <svg class="w-4 h-4 flex-shrink-0 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-body-sm font-semibold text-primary-600">Location Detected Successfully!</p>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2 mt-2">
                                            <div class="bg-white rounded-lg p-2 border border-primary-100">
                                                <p class="text-caption text-muted mb-0.5">Latitude</p>
                                                <p class="text-heading text-body-sm font-semibold font-mono" x-text="parseFloat(lat).toFixed(6)"></p>
                                            </div>
                                            <div class="bg-white rounded-lg p-2 border border-primary-100">
                                                <p class="text-caption text-muted mb-0.5">Longitude</p>
                                                <p class="text-heading text-body-sm font-semibold font-mono" x-text="parseFloat(lon).toFixed(6)"></p>
                                            </div>
                                        </div>
                                        <template x-if="gpsAccuracy !== null">
                                            <p class="text-caption text-muted mt-2" x-text="'Accuracy: ±' + gpsAccuracy + ' m'"></p>
                                        </template>
                                    </div>
                                </template>

                                {{-- Default state --}}
                                <template x-if="!gpsSuccess && !gpsError && !gpsLoading">
                                    <div class="mb-4">
                                        <p class="text-heading font-semibold text-body mb-1.5">Automatic GPS Detection</p>
                                        <p class="text-muted text-body-sm leading-relaxed">
                                            Press the button — your browser will automatically detect your location
                                        </p>
                                    </div>
                                </template>

                                {{-- Detect button --}}
                                <button type="button" @click="detectGPS()" :disabled="gpsLoading"
                                        class="btn btn-primary w-full"
                                        :class="gpsLoading ? 'opacity-50 cursor-not-allowed' : ''">
                                    <template x-if="!gpsLoading">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                            </svg>
                                            <span x-text="gpsSuccess ? 'Detect Again' : 'Detect My Location'"></span>
                                        </span>
                                    </template>
                                    <template x-if="gpsLoading">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Detecting Location...
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>

                        {{-- ── Manual Panel ── --}}
                        <div x-show="method === 'manual'" x-transition>
                            <div class="space-y-4">
                                <div class="alert-info text-caption">
                                    <svg class="w-4 h-4 flex-shrink-0 text-primary-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                    </svg>
                                    <p class="text-primary-700 leading-snug">Enter your country or city — the system will automatically find coordinates</p>
                                </div>

                                <div>
                                    <label for="country" class="form-label">Country <span class="text-red-500">*</span></label>
                                    <select name="country" id="country" class="form-select" @change="formReady = $event.target.value !== ''">
                                        <option value="">-- Select Country --</option>
                                        @foreach([
                                            'Pakistan', 'India', 'Bangladesh', 'Indonesia', 'Malaysia',
                                            'Turkey', 'Egypt', 'Iran', 'Iraq', 'Saudi Arabia',
                                            'UAE', 'Kuwait', 'Qatar', 'Bahrain', 'Oman',
                                            'Jordan', 'Syria', 'Morocco', 'Algeria', 'Tunisia',
                                            'Nigeria', 'United Kingdom', 'United States', 'Canada',
                                            'Australia', 'France', 'Germany', 'Netherlands', 'Belgium',
                                        ] as $c)
                                            <option value="{{ $c }}" {{ old('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="form-label">City <span class="text-muted font-normal">(Optional)</span></label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                                           placeholder="e.g. Karachi, Istanbul..." class="form-input">
                                    <p class="form-hint">Providing a city gives more accurate results</p>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-5">
                            <button type="submit" :disabled="method === 'gps' && !formReady"
                                    class="btn btn-primary w-full"
                                    :class="(method === 'manual' || formReady) ? '' : 'opacity-50 cursor-not-allowed'">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                                </svg>
                                Calculate Meeqat Distance
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Previous Search (Auth) --}}
            @auth
                @if($lastSearch)
                <div class="card card-body">
                    <h3 class="text-heading font-semibold text-body-sm flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Your Previous Search
                    </h3>
                    <a href="{{ route('meeqat.result', $lastSearch->id) }}"
                       class="block p-3 rounded-xl bg-dark-50 border border-border hover:border-primary-300 hover:bg-primary-50/50 transition-all duration-200">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-heading font-semibold text-body-sm">{{ $lastSearch->nearestMeeqat->name_en ?? 'N/A' }}</span>
                            <span class="badge-green">{{ number_format($lastSearch->nearest_distance_km, 1) }} km</span>
                        </div>
                        <p class="text-muted text-caption">{{ $lastSearch->created_at->diffForHumans() }} · {{ ucfirst($lastSearch->detection_method) }}</p>
                    </a>
                </div>
                @endif
            @endauth

            {{-- What is Meeqat? --}}
            <div class="card card-body">
                <h3 class="text-heading font-semibold text-body-sm flex items-center gap-2 mb-3.5">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                    What is Meeqat?
                </h3>
                <p class="text-muted text-body-sm leading-relaxed mb-4">
                    Meeqat is the boundary where pilgrims must enter the state of Ihram before crossing for Hajj or Umrah.
                    Crossing without Ihram is not permissible.
                </p>
                <div class="max-h-[200px] overflow-y-auto no-scrollbar">
                    <div class="flex flex-col gap-1">
                        @foreach($meeqatLocations as $loc)
                        <div class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-dark-50 transition-colors duration-150">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                                 style="background: {{ $loc->color }}15; border: 1px solid {{ $loc->color }}30;">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" style="color: {{ $loc->color }};" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-dark-600 text-caption font-medium truncate">{{ $loc->name_en }}</p>
                                <p class="text-muted text-[0.7rem]">{{ $loc->name_ar }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- =============================================
            RIGHT: MAP + CARDS
        ============================================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Map Card --}}
            <div class="card overflow-hidden">
                <div class="card-header flex items-center justify-between">
                    <div>
                        <h2 class="text-heading font-heading font-bold text-body flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                            </svg>
                            Interactive Map
                        </h2>
                        <p class="text-muted text-caption mt-0.5">5 Meeqat locations — click markers to see details</p>
                    </div>
                    <button onclick="resetMapView()"
                            class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-btn text-caption font-semibold text-muted border border-border bg-dark-50 hover:border-primary-500/50 hover:text-primary-500 hover:bg-primary-50 transition-all duration-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset View
                    </button>
                </div>
                <div id="meeqat-map"></div>
            </div>

            {{-- Meeqat Location Cards --}}
            <div>
                <h3 class="text-heading font-heading font-bold text-body-lg mb-4 flex items-center gap-2.5">
                    <span class="w-1 h-5 bg-primary-500 rounded-full" aria-hidden="true"></span>
                    All Meeqat Locations
                    <span class="badge-green">5</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($meeqatLocations as $loc)
                    <div class="card hover:-translate-y-1 hover:shadow-card-hover hover:border-primary-300 transition-all duration-300 animate-slide-up"
                         style="animation-delay: {{ $loop->index * 0.05 }}s;">
                        <div class="card-body">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                                         style="background: {{ $loc->color }}15; border: 1px solid {{ $loc->color }}30;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" style="color: {{ $loc->color }};" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-heading font-semibold text-body-sm leading-tight">
                                            {{ Str::before($loc->name_en, '(') ?: $loc->name_en }}
                                        </h4>
                                        <p class="text-body-sm" style="color: {{ $loc->color }}; direction: rtl; text-align: right; font-family: serif;">
                                            {{ $loc->name_ar }}
                                        </p>
                                    </div>
                                </div>
                                <button onclick="flyToMeeqat({{ $loc->latitude }}, {{ $loc->longitude }}, '{{ addslashes($loc->name_en) }}')"
                                        class="text-muted bg-dark-50 border border-border rounded-btn p-1.5 hover:text-primary-500 hover:border-primary-300 hover:bg-primary-50 transition-all duration-200 flex-shrink-0"
                                        title="View on map">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                </button>
                            </div>

                            <p class="text-muted text-caption leading-relaxed mb-3.5 line-clamp-2">{{ $loc->for_pilgrims_from }}</p>

                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ $loc->google_maps_url }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1 text-caption text-muted bg-dark-50 border border-border px-3 py-1 rounded-btn hover:bg-primary-50 hover:border-primary-300 hover:text-primary-500 transition-all duration-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    Google Maps
                                </a>
                                <span class="text-dark-300 text-[0.7rem] font-mono">{{ number_format($loc->latitude, 4) }}, {{ number_format($loc->longitude, 4) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Ihram Reminder --}}
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-primary-50 via-primary-100 to-primary-50 border border-primary-200">
                <div class="p-7 flex items-start gap-5">
                    <svg class="w-10 h-10 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                    </svg>
                    <div>
                        <h3 class="text-primary-800 font-heading font-bold text-body-lg mb-2">Time to Prepare for Ihram</h3>
                        <p class="text-primary-700 text-body-sm leading-relaxed mb-4">
                            It is obligatory to put on Ihram <strong class="text-primary-900">before</strong> crossing the Meeqat.
                            Crossing the Meeqat without Ihram is <strong class="text-red-600">not permissible</strong> —
                            doing so requires a sacrifice (Dam).
                        </p>
                        <div class="flex flex-wrap gap-2.5">
                            <a href="{{ route('ihram.index') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-body-sm font-semibold text-primary-800 border border-primary-400 bg-surface hover:bg-primary-100 hover:border-primary-500 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                                View Ihram Rules
                            </a>
                            <a href="{{ route('niyat.index') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-body-sm font-semibold text-muted border border-border bg-surface hover:border-dark-300 hover:text-heading transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                                View Niyat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const meeqatData = @json($mapData);

window.meeqatMap = L.map('meeqat-map', {
    center: [22.0, 40.0],
    zoom: 5,
    zoomControl: true,
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
}).addTo(window.meeqatMap);

const meeqatMarkers = [];

meeqatData.forEach(function(m) {
    const icon = L.divIcon({
        html: `<div style="width:28px;height:28px;background:${m.color};border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid #fff;box-shadow:0 4px 16px rgba(0,0,0,0.25)"></div>`,
        className: '',
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -32],
    });

    const marker = L.marker([m.lat, m.lng], { icon })
        .addTo(window.meeqatMap)
        .bindPopup(`
            <div style="min-width:210px">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                    <span style="font-size:1.2rem">${m.icon}</span>
                    <strong style="color:${m.color};font-size:0.9rem">${m.name_en.split('(')[0].trim()}</strong>
                </div>
                <p style="font-family:serif;font-size:1rem;text-align:right;direction:rtl;color:#059669;margin-bottom:8px">${m.name_ar}</p>
                <p style="font-size:0.72rem;color:#64748b;margin-bottom:12px;line-height:1.5">${m.for}</p>
                <a href="${m.gmaps_url}" target="_blank"
                   style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;color:#059669;font-size:0.72rem;text-decoration:none">
                   Google Maps
                </a>
            </div>
        `);

    meeqatMarkers.push({ marker, lat: m.lat, lng: m.lng });
});

const userIcon = L.divIcon({
    html: `<div style="width:16px;height:16px;background:#10b981;border-radius:50%;border:3px solid #fff;box-shadow:0 0 0 4px rgba(16,185,129,0.25)"></div>`,
    className: '',
    iconSize: [22, 22],
    iconAnchor: [11, 11],
});
window.userMarker = L.marker([0, 0], { icon: userIcon });

function resetMapView() {
    window.meeqatMap.flyTo([22.0, 40.0], 5, { duration: 1.2 });
}

function flyToMeeqat(lat, lng, name) {
    window.meeqatMap.flyTo([lat, lng], 9, { duration: 1.5 });
    setTimeout(() => {
        meeqatMarkers.forEach(m => {
            if (Math.abs(m.lat - lat) < 0.01 && Math.abs(m.lng - lng) < 0.01) {
                m.marker.openPopup();
            }
        });
    }, 1700);
}
</script>
@endpush