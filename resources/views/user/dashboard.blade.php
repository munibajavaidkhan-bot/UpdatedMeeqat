@extends('layouts.app')
@section('title', 'My Dashboard - Meeqat.io')

@push('head')
<style>
    /* ═══════════════════════════════════════════════════
       DASHBOARD — Unique Modern Animated Design
       ═══════════════════════════════════════════════════ */

    /* Hero Welcome */
    .dash-hero {
        position: relative;
        overflow: hidden;
        padding: 128px 0 64px;
        background: linear-gradient(135deg, #064e3b 0%, #047857 40%, #059669 100%);
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: linear-gradient(rgba(255,255,255,0.4) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,0.4) 1px, transparent 1px);
        background-size: 40px 40px;
        opacity: 0.04;
        pointer-events: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Floating particles */
    .particle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        animation: particleFloat 6s ease-in-out infinite;
    }
    @keyframes particleFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.6; }
        50% { transform: translateY(-20px) rotate(180deg); opacity: 0.2; }
    }

    /* Greeting badge */
    .greeting-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        margin-bottom: 20px;
        animation: fadeSlideIn 0.5s ease-out forwards;
        opacity: 0;
    }
    .greeting-badge .pulse-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #34d399;
        animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.5; }
    }

    /* User avatar ring */
    .avatar-ring {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #34d399, #059669, #10b981);
        padding: 3px;
        animation: ringRotate 8s linear infinite;
        flex-shrink: 0;
    }
    @keyframes ringRotate {
        0% { background: linear-gradient(0deg, #34d399, #059669, #10b981); }
        25% { background: linear-gradient(90deg, #34d399, #059669, #10b981); }
        50% { background: linear-gradient(180deg, #34d399, #059669, #10b981); }
        75% { background: linear-gradient(270deg, #34d399, #059669, #10b981); }
        100% { background: linear-gradient(360deg, #34d399, #059669, #10b981); }
    }
    .avatar-inner {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: #065f46;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Stagger animations */
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    .anim-1 { animation: fadeSlideIn 0.5s ease-out 0.1s forwards; opacity: 0; }
    .anim-2 { animation: fadeSlideIn 0.5s ease-out 0.2s forwards; opacity: 0; }
    .anim-3 { animation: fadeSlideIn 0.5s ease-out 0.3s forwards; opacity: 0; }
    .anim-4 { animation: fadeSlideIn 0.5s ease-out 0.4s forwards; opacity: 0; }
    .anim-5 { animation: fadeSlideIn 0.5s ease-out 0.5s forwards; opacity: 0; }

    /* Tool Cards */
    .tool-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .tool-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .tool-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    .tool-card:hover::before { opacity: 1; }
    .tool-card:hover .tool-icon { transform: scale(1.1) rotate(-5deg); }

    .tool-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    .tool-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #1e293b;
        line-height: 1.3;
    }
    .tool-card-desc {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
    }
    .tool-card-arrow {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: gap 0.3s;
    }
    .tool-card:hover .tool-card-arrow { gap: 10px; }

    /* Card color variants — all green */
    .tool-green .tool-icon { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .tool-green .tool-icon svg { color: #059669; }
    .tool-green::before { background: linear-gradient(90deg, #10b981, #059669); }
    .tool-green .tool-card-arrow { color: #059669; }
    .tool-green:hover { border-color: #bbf7d0; background: #fafffe; }

    /* Activity Section */
    .activity-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .activity-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }
    .activity-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .activity-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 0.95rem;
        color: #1e293b;
    }
    .activity-header-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .activity-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        text-decoration: none;
        transition: background 0.2s;
        border-bottom: 1px solid #f8fafc;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: #f8fafc; }
    .activity-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .activity-info { flex: 1; min-width: 0; }
    .activity-title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .activity-time {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 2px;
    }
    .activity-badge {
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        flex-shrink: 0;
    }
    .activity-empty {
        padding: 40px 24px;
        text-align: center;
    }
    .activity-empty-icon {
        width: 56px; height: 56px;
        border-radius: 50%;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .activity-empty-text {
        font-size: 0.9rem;
        color: #94a3b8;
        margin-bottom: 12px;
    }

    /* Stats Row */
    .stat-block {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.3s;
    }
    .stat-block:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .stat-icon-wrap {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.4rem;
        color: #0f172a;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    /* View all link */
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

    /* Islamic pattern for hero */
    .islamic-pattern {
        position: absolute;
        top: 0; right: 0;
        width: 300px; height: 300px;
        opacity: 0.06;
        pointer-events: none;
    }

    /* Section headers */
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-head-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        color: #0f172a;
    }
    .section-head-bar {
        width: 4px; height: 22px;
        border-radius: 999px;
        background: linear-gradient(180deg, #10b981, #059669);
        flex-shrink: 0;
    }

    @media(max-width: 640px) {
        .dash-hero { padding: 110px 0 48px; }
        .avatar-ring { width: 60px; height: 60px; }
        .tool-card { padding: 22px; }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     HERO WELCOME SECTION
     ═══════════════════════════════════════════════════ --}}
<section class="dash-hero">

    {{-- Floating Particles --}}
    <div class="particle" style="top:20%;left:10%;width:6px;height:6px;background:rgba(52,211,153,0.4);animation-delay:0s" aria-hidden="true"></div>
    <div class="particle" style="top:40%;right:15%;width:8px;height:8px;background:rgba(52,211,153,0.3);animation-delay:1.5s" aria-hidden="true"></div>
    <div class="particle" style="bottom:25%;left:20%;width:5px;height:5px;background:rgba(255,255,255,0.25);animation-delay:3s" aria-hidden="true"></div>
    <div class="particle" style="top:60%;right:30%;width:4px;height:4px;background:rgba(52,211,153,0.3);animation-delay:4.5s" aria-hidden="true"></div>

    {{-- Glowing orbs --}}
    <div style="position:absolute;top:0;left:-100px;width:350px;height:350px;background:radial-gradient(circle,rgba(52,211,153,0.15) 0%,transparent 70%);animation:pulse 6s ease-in-out infinite" aria-hidden="true"></div>
    <div style="position:absolute;bottom:-50px;right:-50px;width:300px;height:300px;background:radial-gradient(circle,rgba(52,211,153,0.1) 0%,transparent 70%);animation:pulse 6s ease-in-out 2s infinite" aria-hidden="true"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8 anim-1" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-white/60 hover:text-white transition-colors">Home</a>
            <svg style="width:14px;height:14px;color:rgba(255,255,255,0.3)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white font-medium">Dashboard</span>
        </nav>

        <div class="flex flex-col sm:flex-row items-start gap-6 anim-2">

            {{-- Avatar --}}
            <div class="avatar-ring">
                <div class="avatar-inner">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>

            <div class="flex-1 min-w-0">
                {{-- Greeting Badge --}}
                <div class="greeting-badge">
                    <span class="pulse-dot"></span>
                    @php
                        $hour = now()->hour;
                        $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
                    @endphp
                    {{ $greeting }}, {{ auth()->user()->name }}
                </div>

                {{-- Title --}}
                <h1 style="font-size:clamp(1.8rem,4vw,2.8rem);letter-spacing:-0.03em;line-height:1.1;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;margin-bottom:10px" class="anim-3">
                    Welcome to Your<br>
                    <span style="background:linear-gradient(135deg,#34d399,#a7f3d0);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Personal Dashboard</span>
                </h1>

                <p style="color:rgba(255,255,255,0.65);font-size:0.95rem;max-width:520px;line-height:1.65" class="anim-4">
                    Your spiritual journey companion — access saved calculations, bookmarked duas, and all Hajj & Umrah tools from one place.
                </p>
            </div>
        </div>

        {{-- Quick Stats Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-10 anim-5">
            @php
                $calcCount = $recentCalculations->count();
                $searchCount = $recentSearches->count();
                $bookmarkCount = auth()->user()->bookmarkedDuas()->count() ?? 0;
            @endphp

            <div class="stat-block">
                <div class="stat-icon-wrap" style="background:#f0fdf4;border:1px solid #bbf7d0">
                    <svg style="width:22px;height:22px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $calcCount }}</div>
                    <div class="stat-label">Calculations</div>
                </div>
            </div>

            <div class="stat-block">
                <div class="stat-icon-wrap" style="background:#f0fdf4;border:1px solid #bbf7d0">
                    <svg style="width:22px;height:22px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $searchCount }}</div>
                    <div class="stat-label">Meeqat Searches</div>
                </div>
            </div>

            <div class="stat-block">
                <div class="stat-icon-wrap" style="background:#f0fdf4;border:1px solid #bbf7d0">
                    <svg style="width:22px;height:22px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $bookmarkCount }}</div>
                    <div class="stat-label">Bookmarks</div>
                </div>
            </div>

            <div class="stat-block">
                <div class="stat-icon-wrap" style="background:#f0fdf4;border:1px solid #bbf7d0">
                    <svg style="width:22px;height:22px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <div class="stat-value">500+</div>
                    <div class="stat-label">Duas Available</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════
     QUICK ACCESS TOOLS
     ═══════════════════════════════════════════════════ --}}
<section style="background:#f8fafc;padding:48px 0">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="section-head anim-1">
        <div class="section-head-title">
            <span class="section-head-bar"></span>
            Quick Access Tools
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- Chaddar Calculator --}}
        <a href="{{ route('calculator.chaddar') }}" class="tool-card tool-green anim-1" style="animation-delay:0.05s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="tool-card-title">Chaddar Calculator</div>
            <div class="tool-card-desc">Calculate exact Ihram fabric size based on your height and preferred style</div>
            <div class="tool-card-arrow">
                Start calculating
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

        {{-- Meeqat Finder --}}
        <a href="{{ route('meeqat.finder') }}" class="tool-card tool-green anim-2" style="animation-delay:0.1s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            </div>
            <div class="tool-card-title">Meeqat Finder</div>
            <div class="tool-card-desc">Find the nearest Meeqat location and get distance from your current position</div>
            <div class="tool-card-arrow">
                Find Meeqat
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

        {{-- Duas & Niyat --}}
        <a href="{{ route('duas.index') }}" class="tool-card tool-green anim-3" style="animation-delay:0.15s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div class="tool-card-title">Duas & Niyat</div>
            <div class="tool-card-desc">Browse 500+ duas and niyat collection with Arabic, transliteration and meaning</div>
            <div class="tool-card-arrow">
                Browse duas
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

        {{-- Ihram Guide --}}
        <a href="{{ route('ihram.index') }}" class="tool-card tool-green anim-3" style="animation-delay:0.2s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="tool-card-title">Ihram Guide</div>
            <div class="tool-card-desc">Complete visual guide with rules for men, women, prohibited and recommended acts</div>
            <div class="tool-card-arrow">
                Read rules
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

        {{-- Virtual Try-On --}}
        <a href="{{ route('tryon.index') }}" class="tool-card tool-green anim-4" style="animation-delay:0.25s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="tool-card-title">Virtual Try-On</div>
            <div class="tool-card-desc">Try on prayer caps and Ihram garments virtually before purchasing</div>
            <div class="tool-card-arrow">
                Try now
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

        {{-- My Bookmarks --}}
        <a href="{{ route('user.bookmarks') }}" class="tool-card tool-green anim-5" style="animation-delay:0.3s">
            <div class="tool-icon">
                <svg style="width:26px;height:26px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            </div>
            <div class="tool-card-title">My Bookmarks</div>
            <div class="tool-card-desc">Access your saved duas and favorite prayers collection</div>
            <div class="tool-card-arrow">
                View bookmarks
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </div>
        </a>

    </div>
</div>
</section>

{{-- ═══════════════════════════════════════════════════
     RECENT ACTIVITY
     ═══════════════════════════════════════════════════ --}}
<section style="background:#f8fafc;padding:0 0 80px">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Calculations --}}
        <div class="activity-card anim-3" style="animation-delay:0.1s">
            <div class="activity-header">
                <div class="activity-header-title">
                    <div class="activity-header-icon" style="background:#f0fdf4;border:1px solid #bbf7d0">
                        <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    Recent Calculations
                </div>
                @if($recentCalculations->count() > 0)
                    <a href="{{ route('user.history') }}" class="view-all-link">View all</a>
                @endif
            </div>

            @forelse($recentCalculations as $calc)
                <a href="{{ route('calculator.chaddar.result', $calc->id) }}" class="activity-item">
                    <span class="activity-dot" style="background:#10b981"></span>
                    <div class="activity-info">
                        <div class="activity-title">{{ $calc->height_cm }}cm — {{ ucfirst($calc->style) }} style</div>
                        <div class="activity-time">{{ $calc->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="activity-badge" style="background:#f0fdf4;color:#059669;border:1px solid #bbf7d0">{{ $calc->calculated_meters }}m</span>
                </a>
            @empty
                <div class="activity-empty">
                    <div class="activity-empty-icon" style="background:#f0fdf4;border:1px solid #bbf7d0">
                        <svg style="width:24px;height:24px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="activity-empty-text">No calculations yet</div>
                    <a href="{{ route('calculator.chaddar') }}" class="view-all-link">Calculate Now</a>
                </div>
            @endforelse
        </div>

        {{-- Recent Meeqat Searches --}}
        <div class="activity-card anim-4" style="animation-delay:0.2s">
            <div class="activity-header">
                <div class="activity-header-title">
                    <div class="activity-header-icon" style="background:#f0fdf4;border:1px solid #bbf7d0">
                        <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    Meeqat Searches
                </div>
                @if($recentSearches->count() > 0)
                    <a href="{{ route('user.history') }}" class="view-all-link">View all</a>
                @endif
            </div>

            @forelse($recentSearches as $search)
                <a href="{{ route('meeqat.result', $search->id) }}" class="activity-item">
                    <span class="activity-dot" style="background:#10b981"></span>
                    <div class="activity-info">
                        <div class="activity-title">{{ $search->nearestMeeqat?->name_en ?? 'Unknown Location' }}</div>
                        <div class="activity-time">{{ $search->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="activity-badge" style="background:#f0fdf4;color:#059669;border:1px solid #bbf7d0">{{ number_format($search->nearest_distance_km, 1) }} km</span>
                </a>
            @empty
                <div class="activity-empty">
                    <div class="activity-empty-icon" style="background:#f0fdf4;border:1px solid #bbf7d0">
                        <svg style="width:24px;height:24px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="activity-empty-text">No Meeqat searches yet</div>
                    <a href="{{ route('meeqat.finder') }}" class="view-all-link">Find Meeqat</a>
                </div>
            @endforelse
        </div>

    </div>

    {{-- Bottom CTA --}}
    <div style="margin-top:48px;background:linear-gradient(135deg,#065f46 0%,#047857 40%,#059669 100%);border-radius:24px;padding:48px;position:relative;overflow:hidden" class="anim-5">
        <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at right,rgba(255,255,255,0.06) 0%,transparent 65%);pointer-events:none"></div>
        <div style="position:absolute;inset:0;opacity:0.04;background-image:linear-gradient(rgba(255,255,255,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,1) 1px,transparent 1px);background-size:32px 32px;pointer-events:none"></div>

        <div style="position:relative;z-index:1;display:flex;flex-direction:column;gap:24px" class="md:!flex-row md:!items-center md:!justify-between">
            <div style="display:flex;align-items:flex-start;gap:18px">
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:26px;height:26px;color:rgba(255,255,255,0.9)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 style="color:#fff;font-weight:800;font-size:1.4rem;letter-spacing:-0.02em;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif">Ready for Your Sacred Journey?</h3>
                    <p style="color:rgba(255,255,255,0.7);font-size:0.9rem;max-width:440px;line-height:1.65">Explore all tools, memorize your duas, and prepare thoroughly before entering the blessed state of Ihram.</p>
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0">
                <a href="{{ route('ihram.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:12px;font-size:0.88rem;font-weight:600;color:#065f46;background:#fff;text-decoration:none;box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:all 0.2s">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ihram Guide
                </a>
                <a href="{{ route('duas.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;border-radius:12px;font-size:0.88rem;font-weight:600;color:rgba(255,255,255,0.85);border:1.5px solid rgba(255,255,255,0.25);background:rgba(255,255,255,0.06);text-decoration:none;transition:all 0.2s">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Browse Duas
                </a>
            </div>
        </div>
    </div>

</div>
</section>

@endsection
