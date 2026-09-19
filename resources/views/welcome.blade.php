{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Meeqat.io — Smart Hajj & Umrah Companion</title>
    <meta name="description" content="Your Hajj & Umrah companion for a spiritual, stress-free pilgrimage.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.svg') }}">
    <meta property="og:title" content="Meeqat.io — Smart Hajj & Umrah Companion">
    <meta property="og:image" content="{{ asset('images/og-image.svg') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
            *{box-sizing:border-box;margin:0;padding:0}
            body{font-family:'Inter',sans-serif;background:#0B0F14;color:#e2e8f0;min-height:100vh}
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',
                                400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',
                                800:'#065f46',900:'#064e3b'
                            }
                        },
                        fontFamily: { heading: ['Inter','sans-serif'] }
                    }
                }
            }
        </script>
    @endif

    <style>
        [x-cloak]{display:none!important}
        *{box-sizing:border-box}
        body{background:#0B0F14;font-family:'Inter',sans-serif;color:#fff;overflow-x:hidden;-webkit-font-smoothing:antialiased}

        @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
        .au{animation:fadeUp .7s ease forwards;opacity:0}
        .d1{animation-delay:.12s}.d2{animation-delay:.24s}.d3{animation-delay:.36s}.d4{animation-delay:.48s}.d5{animation-delay:.6s}

        /* ===== HERO ===== */
        .section-hero{position:relative;background:#0B0F14;overflow:hidden;padding-top:96px}
        .hero-photo{position:absolute;inset:0;background-image:url('{{ asset("images/BackgoundMain.png") }}');background-size:cover;background-position:center;filter:brightness(.75)}
        .hero-fade{position:absolute;inset:0;background:linear-gradient(90deg,#0B0F14 0%,#0B0F14 32%,rgba(11,15,20,.75) 55%,rgba(11,15,20,.25) 78%,transparent 100%)}
        .hero-fade-bottom{position:absolute;inset:0;background:linear-gradient(180deg,transparent 55%,#0B0F14 100%)}

        .badge-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:999px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:#34d399;font-size:.75rem;font-weight:600}

        .hero-heading{font-size:clamp(2.2rem,5vw,3.4rem);font-weight:800;line-height:1.15;letter-spacing:-.02em;color:#fff}
        .hero-sub{font-size:1rem;color:rgba(255,255,255,.55);line-height:1.7;max-width:460px}

        .btn-start{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:10px;font-weight:700;font-size:.9rem;color:#04241a;border:none;cursor:pointer;
            background:#10b981;transition:all .25s ease;box-shadow:0 4px 20px rgba(16,185,129,.3)}
        .btn-start:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(16,185,129,.45);background:#0ea973}
        .btn-outline{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:13px 26px;border-radius:10px;font-weight:600;font-size:.9rem;color:#fff;
            background:transparent;border:1px solid rgba(255,255,255,.2);transition:all .25s ease}
        .btn-outline:hover{border-color:rgba(255,255,255,.4);background:rgba(255,255,255,.05)}

        .stat-chip{background:rgba(255,255,255,.04);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:16px 14px}
        .stat-icon{width:34px;height:34px;border-radius:9px;background:rgba(16,185,129,.15);display:flex;align-items:center;justify-content:center;color:#34d399;flex-shrink:0}

        /* ===== FEATURES (white section) ===== */
        .section-feat{background:#FFFFFF;padding:90px 24px 100px;position:relative}
        @media(min-width:1024px){.section-feat{padding-left:48px;padding-right:48px}}
        @media(min-width:1400px){.section-feat{padding-left:64px;padding-right:64px}}
        .eyebrow{display:inline-flex;align-items:center;gap:6px;color:#059669;font-weight:700;font-size:.75rem;text-transform:uppercase;letter-spacing:.12em}
        .eyebrow-light{color:#059669}
        .feat-head{font-size:clamp(1.7rem,3.5vw,2.4rem);font-weight:800;color:#0B0F14;letter-spacing:-.01em}
        .feat-head span{color:#059669}

        .card{background:#FFFFFF;border:1px solid #EEF1F2;border-radius:16px;overflow:hidden;transition:all .3s ease;box-shadow:0 1px 3px rgba(16,24,32,.04)}
        .card:hover{transform:translateY(-4px);border-color:rgba(16,185,129,.35);box-shadow:0 14px 34px rgba(16,24,32,.1)}
        .card-img-wrap{position:relative;height:150px;overflow:hidden;background:#F3F5F6}
        .card-img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease}
        .card:hover .card-img{transform:scale(1.06)}
        .card-badge{position:absolute;top:10px;right:10px;background:#fff;font-size:.65rem;font-weight:700;padding:4px 10px;border-radius:999px;border:1px solid rgba(11,15,20,.08);box-shadow:0 2px 8px rgba(0,0,0,.08)}
        .card-badge.dark{background:#0B0F14;color:#fff;border-color:#0B0F14}
        .card-title{color:#0B0F14}
        .card-desc{color:#6B7280}
        .card-link{color:#059669;font-size:.85rem;font-weight:700;display:inline-flex;align-items:center;gap:4px;text-decoration:none;transition:gap .2s ease}
        .card-link:hover{gap:8px}

        /* ===== CTA PHONE ===== */
        .section-cta{background:linear-gradient(135deg,#062018 0%,#0B0F14 60%);border-radius:24px;padding:50px 32px;position:relative;overflow:hidden;border:1px solid rgba(16,185,129,.15)}
        .phone-mock{width:220px;height:440px;border-radius:34px;background:linear-gradient(160deg,#0d3527,#052015);border:6px solid #0a1a14;box-shadow:0 30px 70px rgba(0,0,0,.5);position:relative;overflow:hidden;margin:0 auto}
        .phone-mock::before{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:90px;height:20px;background:#0a1a14;border-radius:0 0 12px 12px}

        /* ===== READY BANNER ===== */
        .ready-banner{background:linear-gradient(135deg,#e6fbf3,#f0fdf9);border-radius:20px;padding:32px}

        footer a{text-decoration:none}
        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:#0B0F14}
        ::-webkit-scrollbar-thumb{background:#1e293b;border-radius:3px}

        @media(min-width:768px){
            .section-hero{min-height:88vh}
        }
    </style>
</head>
<body>

@php
    // Safe route helper so this template never breaks if a route hasn't been registered yet.
    $r = fn (string $name, string $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
@endphp

{{-- ═══════════════════════ NAV ═══════════════════════ --}}
<nav class="fixed top-0 left-0 right-0 z-[100]" style="background:rgba(11,15,20,.85);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,.06)" x-data="{ open: false, more: false }">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-5 py-3">
        <a href="{{ $r('home') }}" class="flex items-center gap-2.5 group" aria-label="Meeqat.io">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg">
                <span class="text-white font-black text-base font-heading">M</span>
            </div>
            <div class="leading-tight">
                <span class="block text-white font-bold text-base font-heading">Meeqat<span class="text-primary-400">.io</span></span>
                <span class="hidden sm:block text-[10px] text-white/40 tracking-wide">Hajj & Umrah Companion</span>
            </div>
        </a>

        <div class="hidden md:flex items-center gap-1">
            <a href="{{ $r('home') }}" class="px-4 py-2 text-sm font-medium text-white relative">
                Home
                <span class="absolute left-4 right-4 -bottom-3 h-0.5 bg-primary-500 rounded-full"></span>
            </a>
            <a href="{{ $r('calculator.chaddar') }}" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors">Calculator</a>
            <a href="{{ $r('meeqat.finder') }}" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors">Meeqat Finder</a>
            <a href="{{ $r('duas.index') }}" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors">Duas & Niyat</a>
            <a href="{{ $r('ihram.index') }}" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors">Ihram Guide</a>
            <div class="relative" @mouseleave="more=false">
                <button @click="more=!more" @mouseenter="more=true" class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors inline-flex items-center gap-1">
                    More
                    <svg class="w-3.5 h-3.5 transition-transform" :class="more && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="more" x-transition x-cloak class="absolute top-full right-0 mt-1 w-52 rounded-xl overflow-hidden" style="background:#12171f;border:1px solid rgba(255,255,255,.08)">
                    <a href="{{ $r('tryon.index') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Virtual Try-On</a>
                    <a href="{{ $r('tools.hajj-checklist') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Hajj Checklist</a>
                    <a href="{{ $r('tools.qibla') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Qibla Direction</a>
                    <a href="{{ $r('tools.prayer-times') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Prayer Times</a>
                    <a href="{{ $r('about') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5 border-t border-white/5">About</a>
                </div>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-3">
            @auth
                <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-semibold" style="color:#34d399">Dashboard</a>
            @else
                <a href="{{ $r('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-white border border-white/15 hover:border-white/30 transition-all">Login</a>
                <a href="{{ $r('register') }}" class="px-4 py-2 rounded-lg text-sm font-bold text-[#04241a] transition-all" style="background:#10b981">Sign Up</a>
            @endauth
        </div>

        <button @click="open = !open" class="md:hidden p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition-all" aria-label="Menu" :aria-expanded="open">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition x-cloak class="md:hidden border-t border-white/10" style="background:rgba(11,15,20,.97);backdrop-filter:blur(20px)" @click.outside="open=false">
        <div class="px-4 py-4 space-y-1 max-w-[1200px] mx-auto">
            <a href="{{ $r('home') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold text-white">Home</a>
            <a href="{{ $r('calculator.chaddar') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Calculator</a>
            <a href="{{ $r('meeqat.finder') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Meeqat Finder</a>
            <a href="{{ $r('duas.index') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Duas & Niyat</a>
            <a href="{{ $r('ihram.index') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Ihram Guide</a>
            <a href="{{ $r('tryon.index') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Virtual Try-On</a>
            <a href="{{ $r('tools.hajj-checklist') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Hajj Checklist</a>
            <a href="{{ $r('tools.qibla') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Qibla Direction</a>
            <a href="{{ $r('tools.prayer-times') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Prayer Times</a>
            <a href="{{ $r('about') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">About</a>
            <hr class="border-white/10 my-2">
            @auth
                <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2.5 rounded-lg text-sm font-semibold" style="color:#34d399">Dashboard</a>
            @else
                <a href="{{ $r('login') }}" class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Log in</a>
                <a href="{{ $r('register') }}" class="block px-4 py-2.5 rounded-lg text-sm font-bold text-center text-[#04241a]" style="background:#10b981">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══════════════════════ HERO ═══════════════════════ --}}
<section class="section-hero flex items-center">
    <div class="hero-photo"></div>
    <div class="hero-fade"></div>
    <div class="hero-fade-bottom"></div>

    <div class="relative max-w-[1200px] mx-auto w-full px-5 md:px-10 py-16 md:py-24">
        <div class="max-w-xl">
            <span class="badge-pill au d1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Smart Tools for Every Pilgrim
            </span>

            <h1 class="hero-heading au d2" style="margin-top:20px">
                Your Smart<br>
                <span style="color:#34d399">Hajj &amp; Umrah</span><br>
                Companion
            </h1>

            <p class="hero-sub au d3" style="margin-top:18px;margin-bottom:30px">
                Chaddar size calculator, Meeqat distance finder, Duas library, Ihram guide — all in one place for your spiritual journey.
            </p>

            <div class="flex flex-wrap gap-3 au d4">
                <a href="{{ $r('calculator.chaddar') }}" class="btn-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v18m6-18v18M3 9h18M3 15h18"/></svg>
                    Start Calculator
                </a>
                <a href="#features" class="btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    Browse Tools
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 au d5" style="margin-top:40px;max-width:560px">
                @php
                    $stats = [
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>', 'num' => '5+', 'label' => 'Smart Tools'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>', 'num' => '500+', 'label' => 'Duas & Niyat'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>', 'num' => '5', 'label' => 'Meeqat Locations'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5v4.5l3 3"/>', 'num' => 'Free', 'label' => 'Always Free'],
                    ];
                @endphp
                @foreach($stats as $s)
                    <div class="stat-chip flex items-center gap-2.5">
                        <div class="stat-icon">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">{!! $s['icon'] !!}</svg>
                        </div>
                        <div class="leading-tight">
                            <div class="text-white font-bold text-sm">{{ $s['num'] }}</div>
                            <div class="text-white/40 text-[11px]">{{ $s['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════ FEATURES ═══════════════════════ --}}
<section class="section-feat" id="features">
    <div class="max-w-[1440px] mx-auto">
        <div class="text-center mb-12">
            <span class="eyebrow au">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Our Features
            </span>
            <h2 class="feat-head au d1" style="margin-top:10px;margin-bottom:12px">
                Everything You Need For Your <span>Sacred Journey</span>
            </h2>
            <p class="text-[#6B7280] au d2" style="max-width:480px;margin:0 auto">
                All essential tools designed specifically for Hajj &amp; Umrah pilgrims
            </p>
        </div>

        @php
            $cards = [
                ['img' => 'images/Chaddar Size Calculator.png', 'badge' => null, 'badgeColor' => null, 'link' => 'calculator.chaddar', 'cta' => 'Calculate Now',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 3v18m6-18v18M3 9h18M3 15h18"/>',
                 'title' => 'Chaddar Size Calculator', 'desc' => 'Calculate exact fabric meters needed for Ihram Chaddar based on your height and preferred style.'],
                ['img' => 'images/Meeqat Location.png', 'badge' => 'GPS Powered', 'badgeColor' => '#2563EB', 'link' => 'meeqat.finder', 'cta' => 'Find Meeqat',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>',
                 'title' => 'Meeqat Distance Finder', 'desc' => 'Find the nearest Meeqat from your location with exact distance and directions using GPS.'],
                ['img' => 'images/Dua Library.png', 'badge' => '500+ Duas', 'badgeColor' => '#EA580C', 'link' => 'duas.index', 'cta' => 'Browse Duas',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
                 'title' => 'Duas & Niyat Library', 'desc' => 'Complete collection of Hajj & Umrah duas with Arabic text, transliteration, and audio recitation.'],
                ['img' => 'images/Ihram Guide.png', 'badge' => 'Detailed Guide', 'badgeColor' => '#7C3AED', 'link' => 'ihram.index', 'cta' => 'View Guide',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>',
                 'title' => 'Ihram Visual Guide', 'desc' => 'Comprehensive Ihram rules with visual cards — prohibited acts, men & women guidelines.'],
                ['img' => 'images/Virtual TryOn.png', 'badge' => 'AR Powered', 'badgeColor' => '#059669', 'link' => 'tryon.index', 'cta' => 'Try Now',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>',
                 'title' => 'Virtual Try-On', 'desc' => 'Try prayer caps and Ihram garments virtually using your camera or uploaded photo.'],
                ['img' => 'images/Pilgrim Journey.png', 'badge' => 'New Tool', 'badgeColor' => '#111827', 'link' => 'checklist.index', 'cta' => 'Open Checklist',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                 'title' => 'Hajj Checklist', 'desc' => 'Interactive checklist for all your Hajj and Umrah preparations with progress tracking and reminders.'],
                ['img' => 'images/Features Illustration.png', 'badge' => 'Qibla Powered', 'badgeColor' => '#374151', 'link' => 'qibla.index', 'cta' => 'Find Direction',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 12l4.5-2.25L12 12l-1.5 4.5L12 12z"/>',
                 'title' => 'Qibla Direction', 'desc' => 'Find the exact Qibla direction from your location using the interactive compass. Works with your device sensors.'],
                ['img' => 'images/Product Showcase.png', 'badge' => 'Auto Detect', 'badgeColor' => '#2563EB', 'link' => 'prayer.index', 'cta' => 'View Times',
                 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                 'title' => 'Prayer Times', 'desc' => 'Automatic prayer times calculator based on your location. Uses ISNA calculation method with next prayer countdown.'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($cards as $i => $c)
                <div class="card au" style="animation-delay:{{ .05 + $i * .08 }}s">
                    <div class="card-img-wrap">
                        <img src="{{ asset($c['img']) }}" alt="{{ $c['title'] }}" class="card-img" loading="lazy"
                             onerror="this.style.display='none'">
                        @if($c['badge'])
                            <span class="card-badge{{ !empty($c['dark']) ? ' dark' : '' }}" style="{{ empty($c['dark']) ? 'color:'.$c['badgeColor'] : '' }}">{{ $c['badge'] }}</span>
                        @endif
                    </div>
                    <div style="padding:20px 22px 22px">
                        <div class="w-10 h-10 rounded-[10px] mb-3 flex items-center justify-center" style="background:rgba(5,150,105,.08);border:1px solid rgba(5,150,105,.18)">
                            <svg class="w-5 h-5" fill="none" stroke="#059669" viewBox="0 0 24 24" stroke-width="1.6">
                                {!! $c['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="card-title font-bold text-[1.02rem] mb-1.5">{{ $c['title'] }}</h3>
                        <p class="card-desc text-sm leading-relaxed mb-4">{{ $c['desc'] }}</p>
                        <a href="{{ $r($c['link']) }}" class="card-link">
                            {{ $c['cta'] }}
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══ ALL-IN-ONE CTA WITH PHONE ═══ --}}
        <div class="section-cta au" style="margin-top:60px">
            <div class="relative grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="eyebrow"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 21.04a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg> New Feature</span>
                    <h3 class="text-white font-extrabold text-2xl md:text-[2rem] leading-tight" style="margin-top:14px;margin-bottom:12px">
                        All-in-One <span style="color:#34d399">Pilgrim Companion</span>
                    </h3>
                    <p class="text-white/55 text-[.95rem] leading-relaxed mb-6" style="max-width:420px">
                        From calculating your Chaddar size to finding the nearest Meeqat — everything you need for a smooth spiritual journey.
                    </p>
                    <div class="flex flex-wrap gap-3 mb-8">
                        <a href="{{ $r('register') }}" class="btn-start">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 21.04a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            Get Started
                        </a>
                        <a href="#features" class="btn-outline">Learn More →</a>
                    </div>
                    <div class="flex gap-8">
                        <div><div class="text-white font-bold text-lg">8+</div><div class="text-white/40 text-xs">Smart Tools</div></div>
                        <div><div class="text-white font-bold text-lg">500+</div><div class="text-white/40 text-xs">Duas & Niyat</div></div>
                        <div><div class="text-white font-bold text-lg">Free</div><div class="text-white/40 text-xs">Always Free</div></div>
                    </div>
                </div>

                <div class="phone-mock flex flex-col items-center justify-center text-center px-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center mb-4">
                        <span class="text-white font-black text-2xl">M</span>
                    </div>
                    <span class="text-white font-bold text-lg">Meeqat.io</span>
                    <span class="text-white/40 text-[11px] mt-1">All-in-One Pilgrim Companion</span>
                    <div class="mt-8 opacity-20 flex justify-center">
                        <svg style="width:5rem;height:5rem;color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="0.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-6a2 2 0 012-2h2a2 2 0 012 2v6m-8 0H4a1 1 0 01-1-1V7.2a1 1 0 01.5-.87l7-3.9a1 1 0 011 0l7 3.9a1 1 0 01.5.87V20a1 1 0 01-1 1h-6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 17v-3"/></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ READY BANNER ═══ --}}
        <div class="ready-banner au mt-8 flex flex-col md:flex-row items-center gap-5 justify-between">
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background:#10b981">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 12.75l1.5 1.5 3-3.5"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-[#0B0F14] text-lg">Ready for Your Sacred Journey?</h4>
                    <p class="text-[#0B0F14]/60 text-sm mt-0.5">Create a free account to save your calculations, bookmark duas, and access all premium features.</p>
                </div>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <a href="{{ $r('register') }}" class="btn-start" style="box-shadow:none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v6m3-3h-6m1.5 8.25H6.75A2.25 2.25 0 014.5 16.5V6.75A2.25 2.25 0 016.75 4.5H12"/></svg>
                    Create Free Account
                </a>
                <a href="{{ $r('login') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-[10px] font-semibold text-sm text-[#0B0F14]" style="background:#fff;border:1px solid rgba(11,15,20,.1)">Sign In</a>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('layouts.partials.footer')

@unless (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endunless
</body>
</html>