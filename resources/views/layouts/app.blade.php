{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@yield('title', 'Meeqat.io') — Smart Hajj & Umrah Companion</title>
    <meta name="description" content="@yield('meta_description', 'Smart tools for Hajj & Umrah pilgrims. Chaddar size calculator, Meeqat distance finder, Duas & Niyat library.')">
    <meta name="keywords" content="@yield('meta_keywords', 'hajj, umrah, meeqat, duas, ihram, chaddar')">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'Meeqat.io') — Smart Hajj & Umrah Companion">
    <meta property="og:description" content="@yield('meta_description', 'Smart Hajj & Umrah Companion')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.svg') }}">

    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Vite Assets (includes fonts via CSS @import) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-specific head content --}}
    @stack('head')
</head>
<body class="min-h-screen font-sans antialiased bg-islamic text-body">

    {{-- ── Skip to Content (Accessibility) ───────────────── --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[200]
              focus:px-4 focus:py-2 focus:bg-primary-500 focus:text-white focus:rounded-btn
              focus:text-body-sm focus:font-semibold focus:shadow-elevated">
        Skip to main content
    </a>

    {{-- ── Toast Notification Container ──────────────────── --}}
    <div
        x-data="toast()"
        @toast.window="add($event.detail.message, $event.detail.type)"
        class="fixed top-4 right-4 z-[200] flex flex-col gap-2 w-80 pointer-events-none"
        role="region"
        aria-live="polite"
        aria-label="Notifications"
    >
        <template x-for="n in notifications" :key="n.id">
            <div
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-8"
                class="toast pointer-events-auto"
                :class="{
                    'toast-success': n.type === 'success',
                    'toast-error':   n.type === 'error',
                    'toast-warning': n.type === 'warning',
                    'toast-info':    n.type === 'info',
                }"
                @click="remove(n.id)"
                role="alert"
            >
                {{-- Icon --}}
                <span class="flex-shrink-0 mt-0.5" aria-hidden="true">
                    <template x-if="n.type === 'success'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                    <template x-if="n.type === 'error'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                    <template x-if="n.type === 'warning'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </template>
                    <template x-if="n.type === 'info'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </template>
                </span>
                <p x-text="n.message" class="text-body-sm font-medium leading-snug flex-1"></p>
                {{-- Dismiss --}}
                <button class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity ml-auto"
                        aria-label="Dismiss notification">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    {{-- ── Session Flash Messages ───────────────────────── --}}
    @if(session('success'))
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: @js(session('success')), type: 'success' }
                })), 300);
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: @js(session('error')), type: 'error' }
                })), 300);
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: @js(session('warning')), type: 'warning' }
                })), 300);
            });
        </script>
    @endif

    {{-- ── Navbar ───────────────────────────────────────── --}}
    @include('layouts.partials.navbar')

    {{-- ── Main Content ─────────────────────────────────── --}}
    <main id="main-content" class="relative z-10">
        @yield('content')
    </main>

    {{-- ── Footer ──────────────────────────────────────── --}}
    @include('layouts.partials.footer')

    {{-- ── Page-specific Scripts ───────────────────────── --}}
    @stack('scripts')

</body>
</html>