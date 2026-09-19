@extends('layouts.app')
@section('title', 'Duas Library — Hajj & Umrah Supplications')

@push('head')
<style>
    .duas-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    .arabic-deco {
        font-family: 'Amiri', 'Scheherazade New', serif;
        direction: rtl;
        line-height: 1.8;
    }

    .search-wrap {
        position: relative;
        flex: 1;
    }
    .search-input {
        width: 100%;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        padding: 13px 16px 13px 44px;
        font-size: 0.9rem;
        color: #1e293b;
        outline: none;
        transition: all 0.25s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .search-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16,185,129,0.1), 0 1px 3px rgba(0,0,0,0.06);
    }
    .search-input::placeholder { color: #94a3b8; }
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        width: 18px; height: 18px;
    }

    .btn-search {
        padding: 13px 24px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(5,150,105,0.25);
    }
    .btn-search:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(5,150,105,0.35);
    }

    .btn-clear {
        padding: 13px 20px;
        background: #fff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-clear:hover {
        border-color: #94a3b8;
        color: #1e293b;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 999px;
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        font-weight: 500;
        backdrop-filter: blur(8px);
    }
    .stat-pill:hover {
        border-color: rgba(52,211,153,0.4);
        background: rgba(52,211,153,0.12);
        color: #34d399;
    }
    .stat-pill strong { color: #34d399; }

    .sidebar-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        position: sticky;
        top: 90px;
    }
    .sidebar-title {
        color: #0f172a;
        font-weight: 800;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .cat-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 12px;
        font-size: 0.83rem;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: all 0.18s;
        margin-bottom: 3px;
    }
    .cat-link:hover {
        background: #f0fdf4;
        color: #059669;
    }
    .cat-link:hover .cat-count {
        background: #dcfce7;
        color: #059669;
    }
    .cat-link.active {
        background: #f0fdf4;
        color: #059669;
        font-weight: 600;
        border: 1px solid #bbf7d0;
    }
    .cat-link.active .cat-count {
        background: #dcfce7;
        color: #059669;
    }
    .cat-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        transition: background 0.2s;
    }
    .cat-link.active .cat-icon,
    .cat-link:hover .cat-icon {
        background: #dcfce7;
    }
    .cat-count {
        margin-left: auto;
        font-size: 0.72rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #94a3b8;
        padding: 2px 8px;
        border-radius: 999px;
        transition: all 0.18s;
    }

    .dua-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
        text-decoration: none;
        display: block;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .dua-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 3px;
        height: 0;
        background: linear-gradient(180deg, #10b981, #059669);
        border-radius: 0 0 3px 3px;
        transition: height 0.3s ease;
    }
    .dua-card:hover {
        border-color: #bbf7d0;
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.09);
    }
    .dua-card:hover::before {
        height: 100%;
        border-radius: 0;
    }

    .dua-card-badges {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }
    .badge-cat {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        background: #f0fdf4;
        color: #059669;
        border: 1px solid #bbf7d0;
    }
    .badge-featured {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    .dua-arabic {
        font-family: 'Amiri', 'Scheherazade New', serif;
        direction: rtl;
        text-align: right;
        font-size: 1.15rem;
        color: #1e4d3a;
        line-height: 1.9;
        margin-bottom: 10px;
        padding: 10px 12px;
        background: #f0fdf4;
        border-radius: 10px;
        border-right: 3px solid #10b981;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dua-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 0.88rem;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s;
    }
    .dua-card:hover .dua-title { color: #059669; }

    .dua-translation {
        color: #64748b;
        font-size: 0.78rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dua-urdu {
        color: #94a3b8;
        font-size: 0.78rem;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        direction: rtl;
        text-align: right;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dua-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .read-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #94a3b8;
        transition: color 0.2s;
    }
    .dua-card:hover .read-link { color: #059669; }

    .empty-state {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 64px 32px;
        text-align: center;
    }
    .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #bbf7d0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-1 { animation: fadeSlideUp 0.4s ease forwards; }
    .anim-2 { animation: fadeSlideUp 0.4s ease 0.08s forwards; opacity: 0; }
    .anim-3 { animation: fadeSlideUp 0.4s ease 0.16s forwards; opacity: 0; }

    .dua-card { opacity: 0; animation: fadeSlideUp 0.4s ease forwards; }
    .dua-card:nth-child(1)  { animation-delay: 0.05s; }
    .dua-card:nth-child(2)  { animation-delay: 0.10s; }
    .dua-card:nth-child(3)  { animation-delay: 0.15s; }
    .dua-card:nth-child(4)  { animation-delay: 0.20s; }
    .dua-card:nth-child(5)  { animation-delay: 0.25s; }
    .dua-card:nth-child(6)  { animation-delay: 0.30s; }
    .dua-card:nth-child(7)  { animation-delay: 0.35s; }
    .dua-card:nth-child(8)  { animation-delay: 0.40s; }
    .dua-card:nth-child(9)  { animation-delay: 0.45s; }

    .pagination { display: flex; gap: 6px; flex-wrap: wrap; }
    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: 10px;
        font-size: 0.83rem;
        font-weight: 500;
        text-decoration: none;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.2s;
    }
    .pagination .page-item .page-link:hover {
        border-color: #10b981;
        color: #059669;
        background: #f0fdf4;
    }
    .pagination .page-item.active .page-link {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .search-result-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 500;
        color: #3b82f6;
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital@0;1&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="duas-page">

{{-- HERO HEADER (dark bg-mesh) --}}
<div class="relative pt-32 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>

    <div class="container-app relative">

        <nav class="flex items-center gap-2 text-sm mb-8 animate-fade-in" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">Duas Library</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10 mb-10">

            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:999px;font-size:0.78rem;font-weight:600;color:#34d399;margin-bottom:16px;backdrop-filter:blur(8px)">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Duas & Supplications
                </div>

                <h1 class="font-heading font-black text-white leading-tight" style="letter-spacing:-0.03em;font-size:clamp(2rem,4vw,3rem);margin-bottom:12px">
                    Hajj & Umrah<br>
                    <span class="text-primary-400">Duas Library</span>
                </h1>
                <p class="text-dark-300" style="font-size:0.95rem;max-width:440px;line-height:1.7">
                    Authentic supplications with Arabic text, English translation,
                    and Urdu translation for your sacred journey.
                </p>

                <div class="flex flex-wrap gap-2 mt-8">
                    <span class="stat-pill">
                        <svg style="width:14px;height:14px;color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <strong>{{ $duas->total() }}</strong> Duas
                    </span>
                    <span class="stat-pill">
                        <svg style="width:14px;height:14px;color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <strong>{{ $categories->count() }}</strong> Categories
                    </span>
                    <span class="stat-pill">
                        <svg style="width:14px;height:14px;color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        Arabic + Urdu + English
                    </span>
                </div>
            </div>

            <div style="flex-shrink:0">
                <div style="background:rgba(255,255,255,0.07);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:24px 28px;max-width:280px;position:relative">
                    <div style="position:absolute;top:0;right:0;width:60px;height:60px;background:linear-gradient(135deg,#10b981,#059669);border-radius:0 20px 0 60px;opacity:0.15"></div>

                    <p style="font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px">
                        Featured Supplication
                    </p>
                    <p class="arabic-deco" style="font-size:1.4rem;color:#fff;margin-bottom:12px;text-align:right">
                        &#x0631;&#x064E;&#x0628;&#x0650;&#x0646;&#x064E;&#x0627; &#x0622;&#x062A;&#x0650;&#x0646;&#x064E;&#x0627; &#x0641;&#x0650;&#x064A; &#x0627;&#x0644;&#x062F;&#x0651;&#x0646;&#x064A;&#x0627; &#x062D;&#x064E;&#x0633;&#x064E;&#x0646;&#x064E;&#x0629;&#x064B
                    </p>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.6);font-style:italic;margin-bottom:8px;line-height:1.5">
                        "Our Lord, give us good in this world and good in the Hereafter..."
                    </p>
                    <p style="font-size:0.72rem;color:rgba(255,255,255,0.4)">— Surah Al-Baqarah 2:201</p>
                </div>
            </div>
        </div>

        <div class="animate-slide-up" style="max-width:680px;animation-delay:0.1s">
            <form action="{{ route('duas.index') }}" method="GET" style="display:flex;flex-direction:column;gap:10px">

                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <div class="search-wrap">
                        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" placeholder="Search duas in English or Urdu..." class="search-input" value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn-search">
                        <svg style="width:16px;height:16px;display:inline;margin-right:6px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('duas.index', request('category') ? ['category' => request('category')] : []) }}" class="btn-clear">
                            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>

                @if(request('search'))
                    <div style="display:flex;align-items:center;gap:8px">
                        <span style="font-size:0.78rem;color:rgba(255,255,255,0.6)">Results for:</span>
                        <span class="search-result-chip">
                            <svg style="width:12px;height:12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            "{{ request('search') }}"
                        </span>
                        <span style="font-size:0.78rem;color:rgba(255,255,255,0.4)">{{ $duas->total() }} found</span>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-background py-10 pb-20">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- SIDEBAR --}}
        <div style="width:272px;flex-shrink:0" class="hidden lg:block">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <span style="width:4px;height:18px;background:linear-gradient(180deg,#10b981,#059669);border-radius:999px;display:inline-block"></span>
                    Browse by Category
                </div>

                <a href="{{ route('duas.index') }}" class="cat-link {{ !request('category') ? 'active' : '' }}">
                    <div class="cat-icon">
                        <svg style="width:16px;height:16px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span>All Duas</span>
                    <span class="cat-count">{{ $duas->total() }}</span>
                </a>

                @php
                $catIcons = [
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 3h4.5v13.5M12.75 3v3M3.75 21h4.5M3.75 21V3.545M3.75 21h4.5"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
                ];
                @endphp
                @foreach($categories as $cat)
                    <a href="{{ route('duas.index', ['category' => $cat->id]) }}" class="cat-link {{ request('category') == $cat->id ? 'active' : '' }}">
                        <div class="cat-icon">
                            <svg style="width:16px;height:16px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                {!! $catIcons[$loop->index % count($catIcons)] !!}
                            </svg>
                        </div>
                        <span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $cat->name_en }}</span>
                        <span class="cat-count">{{ $cat->duas_count }}</span>
                    </a>
                @endforeach

                <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f1f5f9">
                    <p style="font-size:0.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:10px">Quick Tips</p>
                    <div style="display:flex;flex-direction:column;gap:6px">
                        @foreach(['Recite with full attention','Understand the meaning first','Make dua with sincerity'] as $tip)
                            <div style="display:flex;align-items:flex-start;gap:7px">
                                <svg style="width:13px;height:13px;color:#10b981;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span style="font-size:0.75rem;color:#64748b;line-height:1.4">{{ $tip }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- DUA CARDS --}}
        <div class="flex-1 min-w-0">
            @if($duas->count() > 0)
                <div class="flex items-center justify-between mb-6">
                    <p style="font-size:0.85rem;color:#64748b">
                        Showing <strong style="color:#1e293b">{{ $duas->firstItem() }}</strong>–<strong style="color:#1e293b">{{ $duas->lastItem() }}</strong> of <strong style="color:#1e293b">{{ $duas->total() }}</strong> duas
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($duas as $dua)
                        <a href="{{ route('duas.show', $dua->id) }}" class="dua-card">
                            <div class="dua-card-badges">
                                <span class="badge-cat">{{ $dua->category->name_en ?? 'General' }}</span>
                                @if($dua->is_featured)
                                    <span class="badge-featured">
                                        <svg style="width:10px;height:10px" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        Featured
                                    </span>
                                @endif
                            </div>

                            @if($dua->arabic_text)
                                <div class="dua-arabic">{{ $dua->arabic_text }}</div>
                            @endif

                            <h3 class="dua-title" style="margin-bottom:2px">{{ $dua->title_en }}</h3>
                            @if($dua->title_ur)
                                <p class="urdu text-sm" style="font-weight:700;color:#1e293b;direction:rtl;text-align:right;margin-top:0;margin-bottom:2px">{{ $dua->title_ur }}</p>
                            @endif
                            <p class="dua-translation">{{ $dua->translation_en }}</p>

                            @if($dua->translation_ur)
                                <p class="dua-urdu">{{ $dua->translation_ur }}</p>
                            @endif

                            <div class="dua-card-footer">
                                <span class="read-link">
                                    <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Read dua
                                </span>
                                <svg style="width:14px;height:14px;color:#cbd5e1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $duas->withQueryString()->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg style="width:32px;height:32px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;color:#0f172a;margin-bottom:6px">No duas found</h3>
                    <p style="font-size:0.88rem;color:#64748b;margin-bottom:16px">Try adjusting your search or browse a different category.</p>
                    <a href="{{ route('duas.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border-radius:12px;font-size:0.88rem;font-weight:600;text-decoration:none;box-shadow:0 4px 14px rgba(5,150,105,0.28)">
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                        View All Duas
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
</div>

</div>
@endsection