{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Meeqat.io') }} — Smart Hajj & Umrah Companion</title>

    {{-- Preconnect --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-islamic text-body">

    {{-- ── Skip to Content ─────────────────────────────── --}}
    <a href="#auth-form"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50
              focus:px-4 focus:py-2 focus:bg-primary-500 focus:text-white focus:rounded-btn
              focus:text-body-sm focus:font-semibold">
        Skip to form
    </a>

    <div class="relative min-h-screen flex flex-col items-center justify-center py-12 px-4">

        {{-- Background decoration --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500/5 rounded-full blur-3xl"></div>
        </div>

        {{-- Logo --}}
        <div class="mb-8 relative z-10">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 group"
               aria-label="Meeqat.io — Home">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700
                            flex items-center justify-center
                            shadow-btn group-hover:shadow-glow-green
                            group-hover:scale-105 transition-all duration-200">
                    <span class="text-white font-bold text-lg" aria-hidden="true">M</span>
                </div>
                <div>
                    <span class="text-heading font-bold text-xl font-heading leading-none block">
                        Meeqat<span class="text-primary-500">.io</span>
                    </span>
                    <span class="text-muted text-caption leading-none block mt-0.5">
                        Hajj & Umrah Companion
                    </span>
                </div>
            </a>
        </div>

        {{-- Auth Card --}}
        <div id="auth-form" class="w-full max-w-md relative z-10">
            <div class="bg-white rounded-card border border-border shadow-elevated p-8">
                {{ $slot }}
            </div>
        </div>

        {{-- Footer Note --}}
        <p class="mt-8 text-caption text-muted text-center relative z-10">
            © {{ date('Y') }} Meeqat.io — All rights reserved.
        </p>
    </div>

    {{-- ── Footer ──────────────────────────────────────── --}}
    @include('layouts.partials.footer')
</body>
</html>