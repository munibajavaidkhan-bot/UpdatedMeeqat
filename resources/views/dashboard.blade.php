{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard - Meeqat.io')

@section('content')

{{-- ══════════════════════════════════════════════════════════
    DASHBOARD HEADER
    ══════════════════════════════════════════════════════════ --}}
<div class="relative pt-32 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    
    {{-- Glowing Elements --}}
    <div class="absolute top-1/4 -right-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-1/4 -left-32 w-80 h-80 bg-secondary-500/8 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1s;" aria-hidden="true"></div>

    <div class="relative container-app">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-muted text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors duration-200">
                Home
            </a>
            <svg class="w-3.5 h-3.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-600 font-medium">Dashboard</span>
        </nav>

        {{-- Page Title --}}
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                        bg-primary-500/15 border border-primary-500/30
                        text-primary-400 text-caption font-semibold uppercase tracking-wider mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
                Your Dashboard
            </div>
            
            <h1 class="font-heading font-black text-white mb-4 leading-tight"
                style="font-size: clamp(1.75rem, 4vw, 2.5rem);">
                Welcome back, <span class="text-gradient-primary">{{ auth()->user()->name }}</span>
            </h1>
            
            <p class="text-dark-300 text-body-lg">
                Manage your Hajj & Umrah tools and saved calculations from your personal dashboard.
            </p>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
    MAIN DASHBOARD CONTENT
    ══════════════════════════════════════════════════════════ --}}
<div class="container-app pb-24">
    {{-- Welcome Card --}}
    <div class="card-premium p-8 mb-8">
        <div class="flex items-center gap-6">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700
                        flex items-center justify-center flex-shrink-0 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-heading font-heading font-bold text-xl mb-2">
                    <span class="text-gradient-primary">You're all set!</span>
                </h2>
                <p class="text-muted text-body-sm">
                    Access your saved calculations, bookmarked duas, and personalized Hajj & Umrah planning tools.
                </p>
            </div>
        </div>
    </div>

    {{-- Quick Actions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $quickActions = [
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    'title' => 'Chaddar Calculator',
                    'desc' => 'Calculate your Ihram fabric size',
                    'route' => 'calculator.chaddar',
                    'color' => 'primary',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'title' => 'Meeqat Finder',
                    'desc' => 'Find nearest Meeqat location',
                    'route' => 'meeqat.finder',
                    'color' => 'blue',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                    'title' => 'Duas & Niyat',
                    'desc' => 'Browse prayer collection',
                    'route' => 'duas.index',
                    'color' => 'secondary',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    'title' => 'Ihram Guide',
                    'desc' => 'Learn proper Ihram rules',
                    'route' => 'ihram.index',
                    'color' => 'amber',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                    'title' => 'Virtual Try-On',
                    'desc' => 'Try prayer caps virtually',
                    'route' => 'tryon.index',
                    'color' => 'purple',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>',
                    'title' => 'My Bookmarks',
                    'desc' => 'View saved duas',
                    'route' => 'user.bookmarks',
                    'color' => 'primary',
                ],
            ];
        @endphp

        @foreach($quickActions as $index => $action)
            <a href="{{ route($action['route']) }}" 
               class="group card-premium p-6 transition-all duration-300 hover:-translate-y-1"
               style="animation-delay: {{ $index * 0.05 }}s">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-{{ $action['color'] }}-500/15 border border-{{ $action['color'] }}-500/25
                                flex items-center justify-center flex-shrink-0 group-hover:bg-{{ $action['color'] }}-500/25 transition-colors">
                        <svg class="w-6 h-6 text-{{ $action['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            {!! $action['icon'] !!}
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-heading font-heading font-bold text-h5 mb-1 group-hover:text-{{ $action['color'] }}-600 transition-colors">
                            {{ $action['title'] }}
                        </h3>
                        <p class="text-muted text-body-sm">{{ $action['desc'] }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>

@endsection