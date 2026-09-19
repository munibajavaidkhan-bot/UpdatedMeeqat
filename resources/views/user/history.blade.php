@extends('layouts.app')
@section('title', 'My History')

@section('content')

{{-- Page Header --}}
<div class="relative pt-32 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-1/4 -right-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>

    <div class="container-app relative">
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">My History</span>
        </nav>

        <h1 class="text-3xl font-black text-white mb-4">My <span class="text-primary-400">History</span></h1>
        <p class="text-dark-300 text-body">View your past calculations and searches.</p>
    </div>
</div>

{{-- Main Content --}}
<div class="bg-background py-10 pb-20">
    <div class="container-app">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Chaddar History --}}
            <div>
                <h2 class="text-xl font-bold text-heading mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    Chaddar Calculations
                </h2>
                @forelse($calculations as $calc)
                    <a href="{{ route('calculator.chaddar.result', $calc->id) }}"
                       class="card p-5 mb-3 flex justify-between items-center hover:border-primary-300 hover:shadow-card-hover transition-all block">
                        <div>
                            <p class="text-heading font-semibold">{{ $calc->height_cm }} cm — {{ ucfirst($calc->style) }} style</p>
                            <p class="text-muted text-xs mt-1">{{ $calc->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            <span class="badge-green">{{ $calc->calculated_meters }}m</span>
                            @if($calc->size_label)
                                <p class="text-muted text-xs mt-1">{{ $calc->size_label }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="card p-8 text-center">
                        <p class="text-muted text-sm mb-3">No calculations found.</p>
                        <a href="{{ route('calculator.chaddar') }}" class="view-all-link">Calculate Now</a>
                    </div>
                @endforelse
                <div class="mt-3">{{ $calculations->links() }}</div>
            </div>

            {{-- Meeqat History --}}
            <div>
                <h2 class="text-xl font-bold text-heading mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                    Meeqat Searches
                </h2>
                @forelse($searches as $search)
                    <a href="{{ route('meeqat.result', $search->id) }}"
                       class="card p-5 mb-3 flex justify-between items-center hover:border-primary-300 hover:shadow-card-hover transition-all block">
                        <div>
                            <p class="text-heading font-semibold">{{ $search->nearestMeeqat?->name_en ?? 'N/A' }}</p>
                            <p class="text-muted text-xs mt-1">{{ $search->created_at->format('M d, Y') }} · {{ ucfirst($search->detection_method ?? '') }}</p>
                        </div>
                        <span class="badge-green flex-shrink-0 ml-4">{{ number_format($search->nearest_distance_km, 1) }} km</span>
                    </a>
                @empty
                    <div class="card p-8 text-center">
                        <p class="text-muted text-sm mb-3">No searches found.</p>
                        <a href="{{ route('meeqat.finder') }}" class="view-all-link">Find Meeqat</a>
                    </div>
                @endforelse
                <div class="mt-3">{{ $searches->links() }}</div>
            </div>
        </div>
    </div>
</div>

<style>
    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #059669;
        text-decoration: none;
        padding: 6px 14px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        background: #f0fdf4;
        transition: all 0.2s;
    }
    .view-all-link:hover {
        background: #dcfce7;
        border-color: #10b981;
    }
</style>

@endsection
