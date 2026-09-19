<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Meeqat.io — Smart Hajj & Umrah Companion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen">
<div class="flex min-h-screen">

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{--  LEFT: BRAND PANEL  --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-primary-900 via-dark-900 to-dark-950 items-center justify-center">
        <div class="absolute inset-0 opacity-[0.07] pointer-events-none"
             style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);">
        </div>
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-primary-400/15 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute -bottom-40 -right-20 w-[400px] h-[400px] bg-primary-400/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
        <div class="absolute top-0 right-0 w-px h-full bg-gradient-to-b from-transparent via-white/15 to-transparent"></div>

        <div class="relative z-10 max-w-lg mx-auto px-14 py-20">
            {{-- Logo --}}
            <div class="mb-14">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20 group-hover:border-white/40 transition-all duration-300 shadow-lg">
                        <span class="text-white font-black text-2xl font-heading">M</span>
                    </div>
                    <div>
                        <span class="text-white font-black text-3xl font-heading leading-none block tracking-tight">Meeqat<span class="text-primary-300">.io</span></span>
                        <span class="text-white/80 text-sm leading-none block mt-1 font-medium">Hajj & Umrah Companion</span>
                    </div>
                </a>
            </div>

            {{-- Hero --}}
            <h1 class="text-white font-heading font-black text-5xl leading-[1.1] mb-5 tracking-tight">Welcome Back to<br><span class="text-primary-300">Your Spiritual<br>Journey</span></h1>
            <p class="text-white/90 text-xl leading-relaxed mb-12 font-medium">Continue your pilgrimage preparations with Meeqat.io — your comprehensive companion for Hajj and Umrah.</p>

            {{-- Features --}}
            <div class="space-y-4 mb-12">
                <div class="flex items-start gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/30 flex items-center justify-center flex-shrink-0 shadow-inner">
                        <svg class="w-5 h-5 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base">Meeqat Distance Calculator</p>
                        <p class="text-white/80 text-sm">Find your nearest Meeqat and calculate distances</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/30 flex items-center justify-center flex-shrink-0 shadow-inner">
                        <svg class="w-5 h-5 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base">Duas & Niyat Library</p>
                        <p class="text-white/80 text-sm">Access authentic supplications and intentions</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/30 flex items-center justify-center flex-shrink-0 shadow-inner">
                        <svg class="w-5 h-5 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base">Ihram Guide & Chadar Calculator</p>
                        <p class="text-white/80 text-sm">Step-by-step guidance for your pilgrimage</p>
                    </div>
                </div>
            </div>

            {{-- Quran Quote --}}
            <blockquote class="rounded-xl p-5 border-l-4 border-primary-400 bg-white/5">
                <p class="text-white/90 text-base italic leading-relaxed font-medium">"The best provision is piety. And fear Me, O you of understanding."</p>
                <cite class="text-primary-300/90 text-sm mt-2 block not-italic font-semibold">— Quran, Surah Al-Baqarah 2:197</cite>
            </blockquote>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════ --}}
    {{--  RIGHT: LIGHT FORM PANEL  --}}
    {{-- ════════════════════════════════════════════════════════════ --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-dark-50 via-surface to-dark-100 p-6 lg:p-12">
        <div class="w-full max-w-md">
            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">M</span>
                    </div>
                    <div>
                        <span class="text-heading font-bold text-xl font-heading leading-none block">Meeqat<span class="text-primary-600">.io</span></span>
                    </div>
                </a>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-card border border-border shadow-elevated p-8 lg:p-10">
                <div x-data="{ showPass: false, loading: false }">
                    {{-- Header --}}
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-black text-heading">Welcome Back!</h1>
                        <p class="text-muted text-body mt-1">Login to your account</p>
                    </div>

                    {{-- Session Error --}}
                    @if($errors->any())
                        <div class="alert-error mb-6">
                            <svg class="w-5 h-5 flex-shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-700">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login') }}" @submit="loading = true">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       placeholder="yourname@email.com" required autofocus autocomplete="email"
                                       class="form-input pl-12 @error('email') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror">
                            </div>
                            @error('email') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-5">
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="form-label mb-0">Password <span class="text-red-500">*</span></label>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-primary-600 text-caption hover:text-primary-700 transition-colors hover:underline font-medium">Forgot password?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input :type="showPass ? 'text' : 'password'" name="password" id="password"
                                       placeholder="********" required autocomplete="current-password"
                                       class="form-input pl-12 pr-14 @error('password') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror">
                                <button type="button" @click="showPass = !showPass"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-heading transition-colors">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="remember" id="remember"
                                       class="w-4 h-4 rounded border-dark-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer">
                                <span class="text-muted text-body-sm group-hover:text-heading transition-colors">Remember me</span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" :disabled="loading"
                                class="btn btn-primary w-full btn-lg"
                                :class="loading ? 'opacity-50 cursor-not-allowed' : ''">
                            <template x-if="!loading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Login to Meeqat.io
                                </span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Logging in...
                                </span>
                            </template>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-4 my-6">
                        <div class="flex-1 h-px bg-border"></div>
                        <span class="text-muted text-caption font-medium">Don't have an account?</span>
                        <div class="flex-1 h-px bg-border"></div>
                    </div>

                    {{-- Register Link --}}
                    <a href="{{ route('register') }}"
                       class="btn btn-secondary w-full btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Create Free Account
                    </a>

                    {{-- Back to Home --}}
                    <div class="text-center mt-6">
                        <a href="{{ route('home') }}" class="text-muted hover:text-heading text-body-sm transition-colors flex items-center justify-center gap-2 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to Meeqat.io
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
