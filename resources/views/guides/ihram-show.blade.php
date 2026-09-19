@extends('layouts.app')
@section('title', $guide->title_en . ' — Ihram Guide')

@push('head')
<style>
    .ihram-show-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        padding: 8px 14px;
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        background: rgba(255,255,255,0.06);
        transition: all 0.2s;
        margin-bottom: 28px;
    }
    .back-link:hover {
        border-color: rgba(52,211,153,0.4);
        color: #34d399;
        background: rgba(52,211,153,0.1);
    }
    .back-link:hover .back-arrow { transform: translateX(-3px); }
    .back-arrow { transition: transform 0.2s; }

    .cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        border: 1px solid rgba(52,211,153,0.3);
        background: rgba(52,211,153,0.12);
        color: #34d399;
    }

    .main-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .main-card-top-bar {
        height: 4px;
        width: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
    }
    .guide-reference-image {
        margin-bottom: 24px;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .guide-reference-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .main-card-body {
        padding: 36px;
    }
    @media(min-width: 768px) {
        .main-card-body { padding: 48px; }
    }

    .guide-big-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(255,255,255,0.08);
        border: 1.5px solid rgba(255,255,255,0.12);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    .guide-big-icon:hover {
        transform: scale(1.06) rotate(4deg);
    }

    .content-section {
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
        border: 1px solid #e2e8f0;
    }
    .content-section-en {
        background: #f8fafc;
        border-left: 4px solid #10b981;
    }
    .content-section-ur {
        background: #fafaf9;
        border-right: 4px solid #10b981;
        direction: rtl;
        text-align: right;
    }
    .section-lang-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        margin-bottom: 12px;
        color: #059669;
    }
    .lang-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #10b981;
    }
    .content-text-en {
        color: #334155;
        font-size: 1rem;
        line-height: 1.8;
    }
    .content-text-ur {
        color: #374151;
        font-size: 1.15rem;
        line-height: 2;
        font-family: 'Noto Nastaliq Urdu', serif;
    }

    .related-section { margin-top: 40px; }
    .related-title {
        color: #0f172a;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }
    .related-title-bar {
        width: 4px;
        height: 20px;
        border-radius: 999px;
        background: #10b981;
        flex-shrink: 0;
    }
    .related-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        text-decoration: none;
        display: block;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .related-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #059669);
        opacity: 0;
        transition: opacity 0.25s;
    }
    .related-card:hover {
        border-color: #bbf7d0;
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.09);
    }
    .related-card:hover::before { opacity: 1; }
    .related-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        transition: transform 0.25s;
    }
    .related-card:hover .related-icon { transform: scale(1.1) rotate(3deg); }
    .related-card-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 0.88rem;
        margin-bottom: 6px;
        line-height: 1.4;
        transition: color 0.2s;
    }
    .related-card:hover .related-card-title { color: #059669; }
    .related-card-text {
        color: #94a3b8;
        font-size: 0.77rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .related-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }

    .actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 36px;
        padding-top: 28px;
        border-top: 1px solid #f1f5f9;
    }
    .action-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 11px;
        font-size: 0.83rem;
        font-weight: 600;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        text-decoration: none;
        transition: all 0.2s;
    }
    .action-btn-outline:hover {
        border-color: #10b981;
        color: #059669;
        background: #f0fdf4;
    }
    .action-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 11px;
        font-size: 0.83rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #10b981, #059669);
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(5,150,105,0.28);
    }
    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5,150,105,0.35);
    }

    .sidebar-sticky {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .sidebar-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .sidebar-card-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .step-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        list-style: none;
        padding: 0; margin: 0;
    }
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.5;
    }
    .step-dot {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #f0fdf4;
        border: 1.5px solid #bbf7d0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeUp 0.4s ease forwards; }
    .anim-2 { animation: fadeUp 0.4s ease 0.1s forwards; opacity: 0; }
    .anim-3 { animation: fadeUp 0.4s ease 0.18s forwards; opacity: 0; }
    .anim-4 { animation: fadeUp 0.4s ease 0.26s forwards; opacity: 0; }
    .related-card { opacity: 0; animation: fadeUp 0.4s ease forwards; }
    .related-card:nth-child(1) { animation-delay: 0.05s; }
    .related-card:nth-child(2) { animation-delay: 0.12s; }
    .related-card:nth-child(3) { animation-delay: 0.19s; }
</style>
@endpush

@section('content')

@php
$catCfg = [
    'general' => [
        'color' => '#10b981', 'bg' => '#f0fdf4', 'border' => '#bbf7d0',
        'badge_bg' => '#dcfce7', 'badge_text' => '#059669',
        'bar' => 'linear-gradient(90deg,#10b981,#059669)', 'label' => 'General Rules',
    ],
    'men' => [
        'color' => '#10b981', 'bg' => '#f0fdf4', 'border' => '#bbf7d0',
        'badge_bg' => '#dcfce7', 'badge_text' => '#059669',
        'bar' => 'linear-gradient(90deg,#10b981,#059669)', 'label' => "Men's Rules",
    ],
    'women' => [
        'color' => '#10b981', 'bg' => '#f0fdf4', 'border' => '#bbf7d0',
        'badge_bg' => '#dcfce7', 'badge_text' => '#059669',
        'bar' => 'linear-gradient(90deg,#10b981,#059669)', 'label' => "Women's Rules",
    ],
    'prohibited' => [
        'color' => '#10b981', 'bg' => '#f0fdf4', 'border' => '#bbf7d0',
        'badge_bg' => '#dcfce7', 'badge_text' => '#059669',
        'bar' => 'linear-gradient(90deg,#10b981,#059669)', 'label' => 'Prohibited Acts',
    ],
    'recommended' => [
        'color' => '#10b981', 'bg' => '#f0fdf4', 'border' => '#bbf7d0',
        'badge_bg' => '#dcfce7', 'badge_text' => '#059669',
        'bar' => 'linear-gradient(90deg,#10b981,#059669)', 'label' => 'Recommended Acts',
    ],
];
$cfg = $catCfg[$guide->category] ?? $catCfg['general'];
@endphp

<div style="background:#f8fafc;min-height:100vh" class="ihram-show-page">

{{-- HERO STRIP (dark bg-mesh, matching calculator/meeqat style) --}}
<div class="bg-mesh" style="position:relative;padding-top:128px;padding-bottom:64px">

    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        <nav class="flex items-center gap-2 text-sm mb-6 anim-1" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('ihram.index') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Ihram Guide</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium overflow-hidden text-ellipsis whitespace-nowrap max-w-[200px]">{{ $guide->title_en }}</span>
        </nav>

        <a href="{{ route('ihram.index') }}" class="back-link anim-1">
            <svg class="back-arrow" style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Ihram Guide
        </a>

        <div class="anim-2" style="display:flex;align-items:flex-start;gap:24px;flex-wrap:wrap">
            <div class="guide-big-icon">
                {!! $guide->svg_icon !!}
            </div>

            <div style="flex:1;min-width:0;padding-top:4px">
                <span class="cat-badge" style="margin-bottom:12px">
                    {!! $guide->category_svg_icon !!}
                    {{ $cfg['label'] }}
                </span>

                <h1 class="font-heading font-black text-white" style="letter-spacing:-0.025em;line-height:1.1;font-size:clamp(1.6rem,3.5vw,2.5rem);margin-top:10px;margin-bottom:8px">
                    {{ $guide->title_en }}
                </h1>

                @if($guide->title_ur)
                    <p style="color:rgba(255,255,255,0.6);font-size:1.05rem;direction:rtl;text-align:right;font-family:'Noto Nastaliq Urdu',serif;line-height:1.8;margin-top:4px">
                        {{ $guide->title_ur }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div style="background:#f8fafc;padding:40px 0 80px">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- MAIN COLUMN (2/3) --}}
        <div class="lg:col-span-2 space-y-6">

            <div class="main-card anim-2">
                <div class="main-card-top-bar"></div>
                <div class="main-card-body">

                    @if($guide->image)
                        <div class="guide-reference-image">
                            <img src="{{ asset($guide->image) }}" alt="{{ $guide->title_en }}">
                        </div>
                    @endif

                    <div class="content-section content-section-en">
                        <div class="section-lang-label">
                            <span class="lang-dot"></span>
                            English
                            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </div>
                        <p class="content-text-en">{{ $guide->content_en }}</p>
                    </div>

                    @if($guide->content_ur)
                        <div class="content-section content-section-ur">
                            <div class="section-lang-label" style="justify-content:flex-end">
                                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                                </svg>
                                اردو
                                <span class="lang-dot"></span>
                            </div>
                            <p class="content-text-ur">{{ $guide->content_ur }}</p>
                        </div>
                    @endif

                    <div class="actions-row">
                        <a href="{{ route('ihram.index') }}" class="action-btn-outline">
                            <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            All Rules
                        </a>
                        <a href="{{ route('ihram.index', ['filter' => $guide->category]) }}" class="action-btn-outline" style="border-color:#bbf7d0;color:#059669;background:#f0fdf4">
                            {!! $guide->category_svg_icon !!}
                            {{ $cfg['label'] }}
                        </a>
                        <a href="{{ route('duas.index') }}" class="action-btn-outline">
                            <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Browse Duas
                        </a>
                        <a href="{{ route('niyat.index') }}" class="action-btn-primary">
                            <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            View Niyat
                        </a>
                    </div>
                </div>
            </div>

            @if($related->count() > 0)
                <div class="related-section anim-3">
                    <h3 class="related-title">
                        <span class="related-title-bar"></span>
                        More {{ $cfg['label'] }}
                        <span style="background:#dcfce7;color:#059669;border:1px solid #bbf7d0;padding:2px 10px;border-radius:999px;font-size:0.72rem;font-weight:600">{{ $related->count() }}</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($related as $rel)
                            <a href="{{ route('ihram.show', $rel->id) }}" class="related-card">
                                <div class="related-icon">{!! $rel->svg_icon !!}</div>
                                <h4 class="related-card-title">{{ $rel->title_en }}</h4>
                                <p class="related-card-text">{{ $rel->content_en }}</p>
                                <div class="related-card-footer">
                                    <span style="font-size:0.75rem;font-weight:600;color:#059669;display:flex;align-items:center;gap:5px">
                                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Read rule
                                    </span>
                                    <svg style="width:14px;height:14px;color:#cbd5e1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- SIDEBAR (1/3) --}}
        <div class="hidden lg:block anim-4">
            <div class="sidebar-sticky">

                <div class="sidebar-card">
                    <div class="sidebar-card-title">
                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        About This Rule
                    </div>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#f8fafc;border-radius:10px;border:1px solid #f1f5f9">
                            <span style="font-size:0.78rem;color:#64748b;font-weight:500">Category</span>
                            <span class="cat-badge" style="font-size:0.72rem;padding:3px 10px">{{ $cfg['label'] }}</span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#f8fafc;border-radius:10px;border:1px solid #f1f5f9">
                            <span style="font-size:0.78rem;color:#64748b;font-weight:500">Languages</span>
                            <div style="display:flex;gap:5px">
                                <span style="background:#f0fdf4;color:#059669;border:1px solid #bbf7d0;padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:600">EN</span>
                                @if($guide->content_ur)
                                    <span style="background:#f0fdf4;color:#059669;border:1px solid #bbf7d0;padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:600">اردو</span>
                                @endif
                            </div>
                        </div>
                        @if($related->count() > 0)
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#f8fafc;border-radius:10px;border:1px solid #f1f5f9">
                                <span style="font-size:0.78rem;color:#64748b;font-weight:500">Related Rules</span>
                                <span style="font-size:0.78rem;font-weight:700;color:#1e293b">{{ $related->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-card-title">
                        <svg style="width:13px;height:13px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        Before Ihram
                    </div>
                    <ul class="step-list">
                        @foreach(['Read all rules thoroughly','Memorize key duas for each step','Check your Meeqat distance','Prepare Ihram garments in advance','Make intention (Niyat) sincerely'] as $tip)
                            <li class="step-item">
                                <div class="step-dot">
                                    <svg style="width:10px;height:10px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                {{ $tip }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-card-title">
                        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Related Tools
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px">
                        @foreach([['label' => 'Meeqat Finder','route' => 'meeqat.finder'],['label' => 'Niyat Guide','route' => 'niyat.index'],['label' => 'Duas Library','route' => 'duas.index'],['label' => 'Chaddar Calc','route' => 'calculator.chaddar']] as $link)
                            <a href="{{ route($link['route']) }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-primary-50 transition-colors duration-150 group">
                                <span class="w-2 h-2 rounded-full bg-primary-500 flex-shrink-0"></span>
                                <span class="text-body-sm font-medium text-muted group-hover:text-heading flex-1 transition-colors">{{ $link['label'] }}</span>
                                <svg class="w-3.5 h-3.5 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

</div>{{-- /.ihram-show-page --}}
@endsection