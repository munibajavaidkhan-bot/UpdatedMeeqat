@extends('layouts.app')
@section('title', 'Ihram Rules Visual Guide')

@push('head')
<style>
    .ihram-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 14px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 500;
        color: rgba(255,255,255,0.7);
        transition: all 0.2s;
        backdrop-filter: blur(8px);
    }
    .stat-pill:hover {
        border-color: rgba(52,211,153,0.4);
        background: rgba(52,211,153,0.12);
        color: #34d399;
    }
    .stat-pill .pill-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .stat-pill strong { font-weight: 700; }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 6px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        width: fit-content;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 12px;
        font-size: 0.83rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        color: #64748b;
        white-space: nowrap;
    }
    .filter-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .filter-btn.active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        box-shadow: 0 4px 14px rgba(5,150,105,0.28);
    }
    .filter-btn .count-badge {
        font-size: 0.7rem;
        opacity: 0.75;
        font-weight: 500;
    }

    .cat-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .cat-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .cat-title-bar {
        width: 5px;
        height: 28px;
        border-radius: 999px;
        flex-shrink: 0;
        background: linear-gradient(180deg,#10b981,#059669);
    }
    .cat-icon-wrap {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }
    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #10b981;
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

    .guide-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.28s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .guide-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #059669);
        transition: opacity 0.25s;
        opacity: 0;
    }
    .guide-card:hover {
        border-color: #bbf7d0;
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(16,185,129,0.12);
    }
    .guide-card:hover::before { opacity: 1; }

    .guide-card-body {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .guide-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .guide-icon-box {
        width: 46px; height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .guide-card:hover .guide-icon-box {
        transform: scale(1.08) rotate(3deg);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }
    .guide-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        background: #dcfce7;
        color: #059669;
    }
    .guide-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 0.95rem;
        line-height: 1.4;
        margin-bottom: 10px;
        transition: color 0.2s;
    }
    .guide-card:hover .guide-title { color: #059669; }
    .guide-content {
        color: #64748b;
        font-size: 0.8rem;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }
    .guide-urdu {
        color: #94a3b8;
        font-size: 0.8rem;
        direction: rtl;
        text-align: right;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .guide-card-footer {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .read-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        color: #10b981;
        transition: all 0.2s;
        position: relative;
    }
    .read-link::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0;
        width: 0; height: 1.5px;
        background: #10b981;
        transition: width 0.25s;
    }
    .guide-card:hover .read-link::after { width: 100%; }

    .cta-banner {
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #065f46 0%, #047857 40%, #059669 100%);
        margin-top: 64px;
    }
    .cta-banner::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 400px; height: 100%;
        background: radial-gradient(ellipse at right, rgba(255,255,255,0.08) 0%, transparent 65%);
        pointer-events: none;
    }
    .cta-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0.04;
        background-image: linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }
    .cta-inner {
        position: relative;
        z-index: 1;
        padding: 48px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }
    @media(min-width:768px) {
        .cta-inner { flex-direction: row; align-items: center; justify-content: space-between; }
    }
    .cta-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        border: 1.5px solid rgba(255,255,255,0.25);
        text-decoration: none;
        transition: all 0.22s;
        background: rgba(255,255,255,0.06);
    }
    .cta-btn-outline:hover {
        background: rgba(255,255,255,0.14);
        border-color: rgba(255,255,255,0.5);
        color: #fff;
    }
    .cta-btn-solid {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        color: #065f46;
        background: #fff;
        text-decoration: none;
        transition: all 0.22s;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .cta-btn-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .guide-image-wrapper {
        background: #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        aspect-ratio: 16/9;
        border-bottom: 1px solid #dcfce7;
    }
    .guide-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .guide-card {
        opacity: 0;
        animation: fadeUp 0.4s ease forwards;
    }
    .guide-card:nth-child(1) { animation-delay: 0.05s; }
    .guide-card:nth-child(2) { animation-delay: 0.10s; }
    .guide-card:nth-child(3) { animation-delay: 0.15s; }
    .guide-card:nth-child(4) { animation-delay: 0.20s; }
    .guide-card:nth-child(5) { animation-delay: 0.25s; }
    .guide-card:nth-child(6) { animation-delay: 0.30s; }
    .guide-card:nth-child(7) { animation-delay: 0.35s; }
    .guide-card:nth-child(8) { animation-delay: 0.40s; }
    .guide-card:nth-child(9) { animation-delay: 0.45s; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @media(max-width: 640px) {
        .filter-bar {
            flex-wrap: nowrap;
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
            border-radius: 14px;
        }
        .filter-bar::-webkit-scrollbar { display: none; }
    }
</style>
@endpush

@section('content')

@php
$catConfig = [
    'general'     => ['label' => 'General Rules'],
    'men'         => ['label' => 'Men Rules'],
    'women'       => ["label" => "Women's Rules"],
    'prohibited'  => ['label' => 'Prohibited Acts'],
    'recommended' => ['label' => 'Recommended Acts'],
];
$statPills = [
    ['key' => 'general',     'label' => 'General'],
    ['key' => 'men',         'label' => 'Men'],
    ['key' => 'women',       'label' => 'Women'],
    ['key' => 'prohibited',  'label' => 'Prohibited'],
    ['key' => 'recommended', 'label' => 'Recommended'],
];
$filterTabs = [
    ['key' => 'all',         'label' => 'All Rules'],
    ['key' => 'general',     'label' => 'General'],
    ['key' => 'men',         'label' => 'For Men'],
    ['key' => 'women',       'label' => 'For Women'],
    ['key' => 'prohibited',  'label' => 'Prohibited'],
    ['key' => 'recommended', 'label' => 'Recommended'],
];
$totalGuides = $counts instanceof \Illuminate\Support\Collection ? $counts->sum() : array_sum($counts ?? []);
@endphp

<div style="background:#f8fafc;min-height:100vh" class="ihram-page">

{{-- HERO HEADER (dark bg-mesh, matching calculator/meeqat style) --}}
<div class="bg-mesh" style="position:relative;padding-top:128px;padding-bottom:64px">

    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>

    <div class="container-app relative">
        <nav class="flex items-center gap-2 text-sm mb-8 animate-fade-in" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">Ihram Guide</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-10 mb-10">

            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:999px;font-size:0.78rem;font-weight:600;color:#34d399;margin-bottom:18px;backdrop-filter:blur(8px)">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Visual Rules Guide
                </div>

                <div style="display:flex;align-items:flex-start;gap:18px;margin-bottom:14px">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center flex-shrink-0 shadow-glow-green" style="margin-top:2px">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-heading font-black text-white leading-tight" style="letter-spacing:-0.03em;font-size:clamp(1.9rem,4vw,3rem)">
                            Ihram Rules
                            <span class="text-primary-400">Visual Guide</span>
                        </h1>
                        <p class="text-dark-300 mt-2" style="font-size:0.92rem;max-width:480px;line-height:1.65">
                            Complete guide with rules for men, women, prohibited &
                            recommended acts — carefully compiled for Hajj & Umrah pilgrims.
                        </p>
                    </div>
                </div>

            </div>

            <div style="flex-shrink:0;max-width:280px;width:100%">
                <div style="background:rgba(255,255,255,0.07);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:22px;position:relative;overflow:hidden">
                    <div style="position:absolute;top:0;right:0;width:70px;height:70px;background:linear-gradient(135deg,#10b981,#059669);border-radius:0 20px 0 70px;opacity:0.12"></div>

                    <p style="font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:14px">
                        Rule Categories
                    </p>

                    <div style="display:flex;flex-direction:column;gap:8px">
                        @foreach($catConfig as $key => $cfg)
                            <a href="{{ route('ihram.index', ['filter' => $key]) }}" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:10px;text-decoration:none;transition:background .15s;border:1px solid transparent" onmouseover="this.style.background='rgba(255,255,255,0.06)';this.style.borderColor='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">
                                <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0"></span>
                                <span style="font-size:0.82rem;font-weight:500;color:rgba(255,255,255,0.7);flex:1">{{ $cfg['label'] }}</span>
                                <span style="font-size:0.75rem;font-weight:700;color:#34d399">{{ $counts[$key] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        <div class="flex flex-wrap gap-2 mt-8">
            @foreach($statPills as $pill)
                <a href="{{ route('ihram.index', ['filter' => $pill['key']]) }}" class="stat-pill" style="text-decoration:none">
                    <span class="pill-dot" style="background:#10b981"></span>
                    {{ $pill['label'] }}:
                    <strong>{{ $counts[$pill['key']] ?? 0 }}</strong>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div style="background:#f8fafc;padding:40px 0 80px">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="filter-bar" style="margin-bottom:36px">
        @foreach($filterTabs as $tab)
            <a href="{{ route('ihram.index', $tab['key'] !== 'all' ? ['filter' => $tab['key']] : []) }}" class="filter-btn {{ $activeFilter === $tab['key'] ? 'active' : '' }}">
                @switch($tab['key'])
                    @case('all')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        @break
                    @case('general')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @break
                    @case('men')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @break
                    @case('women')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v6m-3-3h6M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        @break
                    @case('prohibited')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @break
                    @case('recommended')
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                        @break
                @endswitch
                {{ $tab['label'] }}
                @if($tab['key'] !== 'all' && isset($counts[$tab['key']]))
                    <span class="count-badge">({{ $counts[$tab['key']] }})</span>
                @endif
            </a>
        @endforeach
    </div>

    @if($activeFilter === 'all')
        @foreach($allGuides as $categoryName => $categoryGuides)
            @php $cfg = $catConfig[$categoryName] ?? $catConfig['general']; @endphp
            <div style="margin-bottom:56px">
                <div class="cat-section-header">
                    <div class="cat-section-title">
                        <span class="cat-title-bar"></span>
                        <span class="cat-icon-wrap">
                            @switch($categoryName)
                                @case('general')
                                    <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @break
                                @case('men')
                                    <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    @break
                                @case('women')
                                    <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v6m-3-3h6M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    @break
                                @case('prohibited')
                                    <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @break
                                @case('recommended')
                                    <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                    @break
                            @endswitch
                        </span>
                        {{ $cfg['label'] }}
                        <span style="background:#dcfce7;color:#059669;border:1px solid #bbf7d0;padding:2px 10px;border-radius:999px;font-size:0.72rem;font-weight:600">{{ $categoryGuides->count() }}</span>
                    </div>
                    <a href="{{ route('ihram.index', ['filter' => $categoryName]) }}" class="view-all-link">
                        View all
                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($categoryGuides as $guide)
                        <div class="guide-card">
                            @if($guide->image)
                                <div class="guide-image-wrapper">
                                    <img src="{{ asset($guide->image) }}" alt="{{ $guide->title_en }}" class="guide-image" loading="lazy">
                                </div>
                            @endif
                            <div class="guide-card-body">
                                <div class="guide-card-top">
                                    <div class="guide-icon-box">{!! $guide->svg_icon !!}</div>
                                    <span class="guide-cat-badge">{{ $cfg['label'] }}</span>
                                </div>
                                <h3 class="guide-title">{{ $guide->title_en }}</h3>
                                <p class="guide-content">{{ $guide->content_en }}</p>
                                @if($guide->title_ur)
                                    <p class="guide-urdu">{{ $guide->title_ur }}</p>
                                @endif
                                <div class="guide-card-footer">
                                    <a href="{{ route('ihram.show', $guide->id) }}" class="read-link">
                                        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Read Full Rule
                                    </a>
                                    <svg style="width:16px;height:16px;color:#e2e8f0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        @php $cfg = $catConfig[$activeFilter] ?? $catConfig['general']; @endphp
        <div class="cat-section-header" style="margin-bottom:28px">
            <div class="cat-section-title">
                <span class="cat-title-bar"></span>
                <span class="cat-icon-wrap">
                    @switch($activeFilter)
                        @case('general')
                            <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @break
                        @case('men')
                            <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @break
                        @case('women')
                            <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v6m-3-3h6M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            @break
                        @case('prohibited')
                            <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @break
                        @case('recommended')
                            <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            @break
                    @endswitch
                </span>
                {{ $cfg['label'] }}
                <span style="background:#dcfce7;color:#059669;border:1px solid #bbf7d0;padding:2px 10px;border-radius:999px;font-size:0.72rem;font-weight:600">{{ $filteredGuides->count() }}</span>
            </div>
            <a href="{{ route('ihram.index') }}" class="view-all-link" style="color:#64748b;border-color:#e2e8f0;background:#f8fafc">
                <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Clear filter
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($filteredGuides as $guide)
                <div class="guide-card">
                    @if($guide->image)
                        <div class="guide-image-wrapper">
                            <img src="{{ asset($guide->image) }}" alt="{{ $guide->title_en }}" class="guide-image" loading="lazy">
                        </div>
                    @endif
                    <div class="guide-card-body">
                        <div class="guide-card-top">
                            <div class="guide-icon-box">{!! $guide->svg_icon !!}</div>
                            <span class="guide-cat-badge">{{ $cfg['label'] }}</span>
                        </div>
                        <h3 class="guide-title">{{ $guide->title_en }}</h3>
                        <p class="guide-content">{{ $guide->content_en }}</p>
                        @if($guide->title_ur)
                            <p class="guide-urdu">{{ $guide->title_ur }}</p>
                        @endif
                        <div class="guide-card-footer">
                            <a href="{{ route('ihram.show', $guide->id) }}" class="read-link">
                                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Read Full Rule
                            </a>
                            <svg style="width:16px;height:16px;color:#e2e8f0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="cta-banner">
        <div class="cta-inner">
            <div style="display:flex;align-items:flex-start;gap:18px">
                <div style="width:58px;height:58px;border-radius:16px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:28px;height:28px;color:rgba(255,255,255,0.9)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 style="color:#fff;font-weight:800;font-size:1.5rem;letter-spacing:-0.02em;margin-bottom:6px">Ready for Your Ihram?</h3>
                    <p style="color:rgba(255,255,255,0.72);font-size:0.88rem;max-width:400px;line-height:1.65">Study all rules carefully before entering the sacred state. Check Meeqat distance and memorize your duas beforehand.</p>
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0">
                <a href="{{ route('meeqat.finder') }}" class="cta-btn-outline">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    Meeqat Finder
                </a>
                <a href="{{ route('duas.index') }}" class="cta-btn-outline">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Browse Duas
                </a>
                <a href="{{ route('niyat.index') }}" class="cta-btn-solid">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    View Niyat
                </a>
            </div>
        </div>
    </div>

</div>
</div>

</div>{{-- /.ihram-page --}}
@endsection