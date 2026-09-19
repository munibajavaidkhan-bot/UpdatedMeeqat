{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Meeqat.io — Smart Hajj & Umrah Companion')

@section('content')

{{-- ══════════════════════════════════════════════════════════
    HERO SECTION - Modern Professional Design
    ══════════════════════════════════════════════════════════ --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20 bg-hero-glow">
    
    {{-- Animated Mesh Background --}}
    <div class="absolute inset-0 opacity-30" aria-hidden="true">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-secondary-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    {{-- Background gradient overlay -- bg-hero-glow already provides the visual --}}
    <div class="absolute inset-0 bg-gradient-to-b from-dark-900/85 via-dark-900/70 to-dark-900/90"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-dark-900/40 to-transparent"></div>

    {{-- Glowing Orbs --}}
    <div class="absolute top-1/4 -left-40 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-1/4 -right-40 w-96 h-96 bg-secondary-500/15 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-primary-500/8 rounded-full blur-3xl" aria-hidden="true"></div>

    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-[0.04]"
         style="background-image: linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 50px 50px;"
         aria-hidden="true"></div>

    <div class="relative container-app text-center py-20">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                     bg-primary-500/15 border border-primary-500/30
                     text-primary-400 text-body-sm font-medium mb-8
                     animate-fade-in backdrop-blur-sm">
            <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
            Smart Tools for Every Pilgrim
        </div>

        {{-- Main Heading --}}
        <h1 class="font-heading font-black text-white mb-6 animate-slide-up leading-tight"
            style="font-size: clamp(2.5rem, 6vw, 4.5rem); line-height: 1.1; letter-spacing: -0.02em;">
            Your Smart<br>
            <span class="text-primary-400">Hajj & Umrah</span><br>
            Companion
        </h1>

        {{-- Subtitle --}}
        <p class="text-body-lg md:text-xl text-dark-300 mb-10 max-w-2xl mx-auto animate-slide-up leading-relaxed"
           style="animation-delay: 0.1s;">
            Chaddar size calculator, Meeqat distance finder, Duas library, Ihram guide — all in one place for your spiritual journey.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-wrap items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.2s;">
            <a href="{{ route('calculator.chaddar') }}"
               class="btn btn-primary btn-lg shadow-2xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Start Calculator
            </a>
            <a href="{{ route('duas.index') }}"
               class="btn-hero-outline text-body px-8 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Browse Duas
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-16 animate-slide-up" style="animation-delay: 0.3s;">
            @php
                $stats = [
                    ['value' => '5+',    'label' => 'Smart Tools',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.66-5.66a2 2 0 010-2.83l4.24-4.24a2 2 0 012.83 0l5.66 5.66a2 2 0 010 2.83l-4.24 4.24a2 2 0 01-2.83 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.5 20.5l-4.95-4.95"/>'],
                    ['value' => '500+', 'label' => 'Duas & Niyat',    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                    ['value' => '5',    'label' => 'Meeqat Locations', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                    ['value' => 'Free', 'label' => 'Always Free',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-card p-5 text-center
                            transition-all duration-300 hover:bg-white/15">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-400"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                             aria-hidden="true">
                            {!! $stat['icon'] !!}
                        </svg>
                    </div>
                    <div class="text-h2 font-heading font-black text-white">{{ $stat['value'] }}</div>
                    <div class="text-dark-300 text-caption mt-0.5">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-dark-500 animate-bounce" aria-hidden="true">
        <span class="text-caption uppercase tracking-widest">Scroll</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
    FEATURES SECTION
    ══════════════════════════════════════════════════════════ --}}
<section class="py-24 relative overflow-hidden bg-white">
    <div class="absolute inset-0 bg-section-glow" aria-hidden="true"></div>
    <div class="absolute inset-0 pattern-dots opacity-30" aria-hidden="true"></div>

    <div class="container-app relative">

        {{-- Section Header --}}
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full
                         bg-secondary-50 border border-secondary-200
                         text-secondary-600 text-caption font-semibold uppercase tracking-wider mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                </svg>
                Our Features
            </div>

            <h2 class="section-title">
                Everything You Need For<br>
                <span class="text-primary-400">Your Sacred Journey</span>
            </h2>
            <p class="section-subtitle max-w-xl mx-auto">
                All essential tools designed specifically for Hajj & Umrah pilgrims
            </p>
        </div>

        {{-- Features Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $features = [
                    [
                        'title'    => 'Chaddar Size Calculator',
                        'desc'     => 'Calculate exact fabric meters needed for Irani Chaddar based on your height and preferred style.',
                        'border'   => 'border-primary-200 hover:border-primary-400',
                        'badge'    => 'Most Popular',
                        'badgecls' => 'badge-green',
                        'image'    => 'images/Chaddar Size Calculator.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>',
                        'route'    => 'calculator.chaddar',
                        'cta'      => 'Calculate Now',
                    ],
                    [
                        'title'    => 'Meeqat Distance Finder',
                        'desc'     => 'Find the nearest Meeqat from your location with exact distance and directions using GPS.',
                        'border'   => 'border-blue-200 hover:border-blue-400',
                        'badge'    => 'GPS Powered',
                        'badgecls' => 'badge-blue',
                        'image'    => 'images/Meeqat Location.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        'route'    => 'meeqat.finder',
                        'cta'      => 'Find Meeqat',
                    ],
                    [
                        'title'    => 'Duas & Niyat Library',
                        'desc'     => 'Complete collection of Hajj & Umrah duas with Arabic text, transliteration, and audio recitation.',
                        'border'   => 'border-secondary-200 hover:border-secondary-400',
                        'badge'    => '500+ Duas',
                        'badgecls' => 'badge-gold',
                        'image'    => 'images/Dua Library.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                        'route'    => 'duas.index',
                        'cta'      => 'Browse Duas',
                    ],
                    [
                        'title'    => 'Ihram Visual Guide',
                        'desc'     => 'Comprehensive Ihram rules with visual cards — prohibited acts, men & women guidelines.',
                        'border'   => 'border-purple-200 hover:border-purple-400',
                        'badge'    => 'Detailed Guide',
                        'badgecls' => 'badge-purple',
                        'image'    => 'images/Ihram Guide.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                        'route'    => 'ihram.index',
                        'cta'      => 'View Guide',
                    ],
                    [
                        'title'    => 'Virtual Try-On',
                        'desc'     => 'Try prayer caps and Ihram garments virtually using your camera or uploaded photo.',
                        'border'   => 'border-pink-200 hover:border-pink-400',
                        'badge'    => 'AI Powered',
                        'badgecls' => 'badge-pink',
                        'image'    => 'images/Virtual TryOn.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                        'route'    => 'tryon.index',
                        'cta'      => 'Try Now',
                    ],
                    [
                        'title'    => 'Hajj Checklist',
                        'desc'     => 'Interactive checklist for all your Hajj and Umrah preparations with progress tracking and automatic save.',
                        'border'   => 'border-primary-200 hover:border-primary-400',
                        'badge'    => 'New Tool',
                        'badgecls' => 'badge-green',
                        'image'    => 'images/Pilgrim Journey.png',
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'route'    => 'tools.hajj-checklist',
                        'cta'      => 'Open Checklist',
                    ],
                    [
                        'title'    => 'Qibla Direction',
                        'desc'     => 'Find the exact Qibla direction from your location using the interactive compass. Works with your device sensors.',
                        'border'   => 'border-secondary-200 hover:border-secondary-400',
                        'badge'    => 'GPS Powered',
                        'badgecls' => 'badge-gold',
                        'image'    => null,
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>',
                        'route'    => 'tools.qibla',
                        'cta'      => 'Find Direction',
                    ],
                    [
                        'title'    => 'Prayer Times',
                        'desc'     => 'Automatic prayer times calculator based on your location. Uses ISNA calculation method with next prayer countdown.',
                        'border'   => 'border-blue-200 hover:border-blue-400',
                        'badge'    => 'Auto Detect',
                        'badgecls' => 'badge-blue',
                        'image'    => null,
                        'icon'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>',
                        'route'    => 'tools.prayer-times',
                        'cta'      => 'View Times',
                    ],
                ];
            @endphp

            @foreach($features as $index => $feature)
                <a
                    href="{{ route($feature['route']) }}"
                    class="group relative card overflow-hidden p-0 border-2 {{ $feature['border'] }}
                           transition-all duration-300 hover:-translate-y-1.5 hover:shadow-card-hover animate-slide-up"
                    style="animation-delay: {{ $index * 0.08 }}s"
                >
                    {{-- Card Image / Placeholder --}}
                    <div class="relative h-56 overflow-hidden @if($feature['image']) bg-dark-800 @else bg-gradient-to-br from-primary-500/10 via-primary-400/5 to-dark-800/50 @endif flex items-center justify-center">
                        @if($feature['image'])
                            <img
                                src="{{ asset($feature['image']) }}"
                                alt="{{ $feature['title'] }}"
                                class="absolute inset-0 w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-900/85 via-dark-900/30 to-dark-900/20"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 to-transparent"></div>
                        @endif

                        {{-- Badge --}}
                        <div class="absolute top-4 right-4 z-10">
                            <span class="{{ $feature['badgecls'] }} backdrop-blur-sm shadow-lg">
                                {{ $feature['badge'] }}
                            </span>
                        </div>

                        {{-- Large Icon --}}
                        <div class="w-16 h-16 rounded-2xl bg-dark-900/70 backdrop-blur-md
                                    border border-white/15 flex items-center justify-center shadow-xl z-10">
                            <svg class="w-8 h-8 text-primary-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                 aria-hidden="true">
                                {!! $feature['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-6">
                        <h3 class="text-heading font-heading font-bold text-h4 mb-2
                                   group-hover:text-primary-600 transition-colors duration-300">
                            {{ $feature['title'] }}
                        </h3>
                        <p class="text-muted text-body-sm leading-relaxed mb-5">
                            {{ $feature['desc'] }}
                        </p>

                        {{-- CTA --}}
                        <div class="flex items-center gap-2 text-primary-600 text-body-sm font-semibold
                                    group-hover:gap-3 transition-all duration-300">
                            {{ $feature['cta'] }}
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
    PRODUCT SHOWCASE
    ══════════════════════════════════════════════════════════ --}}
<section class="py-16 relative overflow-hidden">
    <div class="container-app">
        <div class="relative rounded-card overflow-hidden bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900
                    border border-dark-700/50 shadow-elevated">
            <div class="absolute inset-0 bg-hero-glow" aria-hidden="true"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary-500/8 rounded-full blur-3xl" aria-hidden="true"></div>

            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 md:p-12 items-center">

                {{-- Content --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                 bg-primary-500/10 border border-primary-500/25
                                 text-primary-400 text-caption font-semibold uppercase tracking-wider mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.841m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        </svg>
                        New Feature
                    </div>

                    <h2 class="font-heading font-black text-h1 text-white mb-4 leading-tight">
                        All-in-One<br>
                        <span class="text-primary-400">Pilgrim Companion</span>
                    </h2>

                    <p class="text-dark-300/70 text-body-lg mb-6 leading-relaxed max-w-md">
                        From calculating your Chaddar size to finding the nearest Meeqat — everything you need for a smooth spiritual journey.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('calculator.chaddar') }}" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                            </svg>
                            Get Started
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline border-white/30 text-white hover:bg-white/10">
                            Learn More
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Mini Stats --}}
                    <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-dark-700/50">
                        <div>
                            <p class="font-heading font-black text-h2 text-white">8+</p>
                            <p class="text-caption text-dark-500">Smart Tools</p>
                        </div>
                        <div>
                            <p class="font-heading font-black text-h2 text-white">500+</p>
                            <p class="text-caption text-dark-500">Duas & Niyat</p>
                        </div>
                        <div>
                            <p class="font-heading font-black text-h2 text-white">Free</p>
                            <p class="text-caption text-dark-500">Always Free</p>
                        </div>
                    </div>
                </div>

                {{-- Gradient Showcase Box --}}
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary-500/20 via-secondary-500/10 to-primary-500/20
                                rounded-card blur-2xl opacity-60" aria-hidden="true"></div>
                    <div class="relative rounded-card shadow-elevated w-full aspect-[4/3] bg-gradient-to-br from-dark-800 via-dark-700 to-dark-900
                                border border-dark-600/50 flex items-center justify-center overflow-hidden">
                        {{-- Decorative circles --}}
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-500/20 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-secondary-500/15 rounded-full blur-2xl"></div>
                        {{-- App mockup --}}
                        <div class="relative z-10 text-center px-6">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-glow-green">
                                <span class="text-white font-black text-2xl">M</span>
                            </div>
                            <p class="text-white font-heading font-bold text-h4">Meeqat<span class="text-primary-400">.io</span></p>
                            <p class="text-dark-400 text-sm mt-1">All-in-One Pilgrim Companion</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
    CTA BANNER
    ══════════════════════════════════════════════════════════ --}}
<section class="py-20">
    <div class="container-app">
        <div class="relative rounded-card overflow-hidden">

            {{-- Background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-primary-800 via-primary-700 to-dark-900"></div>
            <div class="absolute inset-0 opacity-10" aria-hidden="true"
                 style="background-image: linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 40px 40px;"></div>
            <div class="absolute top-0 right-0 w-72 h-72 bg-secondary-500/20 rounded-full blur-3xl" aria-hidden="true"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-primary-400/20 rounded-full blur-3xl" aria-hidden="true"></div>

            {{-- Background decorative pattern (gradient handles the visual) --}}

            <div class="relative px-8 md:px-16 py-16 flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="font-heading font-black text-h1 text-white mb-3 leading-tight">
                        Ready for Your<br>
                        <span class="text-primary-400">Sacred Journey?</span>
                    </h2>
                    <p class="text-primary-200/80 text-body-lg max-w-md">
                        Create a free account to save your calculations, bookmark duas, and access all premium features.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    @guest
                        <a href="{{ route('register') }}"
                           class="btn btn-gold btn-lg text-body px-8 whitespace-nowrap shadow-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                            </svg>
                            Create Free Account
                        </a>
                        <a href="{{ route('login') }}"
                           class="btn btn-outline btn-lg text-body px-8 whitespace-nowrap
                                  border-white/30 text-white hover:bg-white/10 backdrop-blur-sm">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route('calculator.chaddar') }}"
                           class="btn btn-gold btn-lg text-body px-8 whitespace-nowrap shadow-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                            </svg>
                            Start Calculating
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

@endsection