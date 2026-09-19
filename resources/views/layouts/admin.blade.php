{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — Meeqat.io</title>

    {{-- Preconnect --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-track { background: transparent; }
        aside::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 9999px; }
        aside::-webkit-scrollbar-thumb:hover { background: #334155; }
        aside { scrollbar-width: thin; scrollbar-color: #1e293b transparent; }
    </style>

    @stack('head')
</head>
<body class="min-h-screen font-sans antialiased bg-background text-body">

    {{-- ── Toast Container ──────────────────────────────── --}}
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
                <button class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity ml-auto"
                        aria-label="Dismiss notification">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    {{-- ── Session Flash ────────────────────────────────── --}}
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

    {{-- ── Layout Shell ─────────────────────────────────── --}}
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">

        {{-- ══════════ SIDEBAR ══════════ --}}
        <aside
            class="flex-shrink-0 flex flex-col h-screen border-r border-dark-800/70 bg-sidebar overflow-hidden
                   transition-all duration-300 ease-out"
            :class="sidebarOpen ? 'w-64' : 'w-16'"
            aria-label="Admin navigation"
        >
            {{-- ── Logo ──────────────────────────────────── --}}
            <div class="flex items-center gap-3 px-4 py-5 border-b border-dark-800/50">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700
                            flex items-center justify-center flex-shrink-0
                            shadow-btn">
                    <span class="text-white font-bold font-heading text-sm" aria-hidden="true">M</span>
                </div>
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="overflow-hidden">
                    <p class="text-white font-bold font-heading leading-none">
                        Meeqat<span class="text-primary-400">.io</span>
                    </p>
                    <p class="text-dark-500 text-caption mt-0.5">Admin Panel</p>
                </div>
            </div>

            {{-- ── Collapse Toggle ────────────────────────── --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="flex items-center justify-center py-3 border-b border-dark-800/50
                       text-dark-500 hover:text-dark-200
                       transition-colors duration-200
                       focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-inset"
                :aria-label="sidebarOpen ? 'Collapse sidebar' : 'Expand sidebar'"
            >
                <svg class="w-5 h-5 transition-transform duration-300"
                     :class="sidebarOpen ? 'rotate-0' : 'rotate-180'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>

            {{-- ── Navigation Items ───────────────────────── --}}
            <nav class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden py-4 px-2 space-y-0.5" aria-label="Main navigation">
                @php
                    $navItems = [
                        [
                            'route'  => 'admin.dashboard',
                            'label'  => 'Dashboard',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                        ],
                        [
                            'route'  => 'admin.users.index',
                            'label'  => 'Users',
                            'roles'  => [1],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
                        ],
                        [
                            'route'  => 'admin.duas.index',
                            'label'  => 'Duas',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                        ],
                        [
                            'route'  => 'admin.niyat.index',
                            'label'  => 'Niyat',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                        ],
                        [
                            'route'  => 'admin.categories.index',
                            'label'  => 'Categories',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>',
                        ],
                        [
                            'route'  => 'admin.ihram-guides.index',
                            'label'  => 'Ihram Guides',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                        ],
                        [
                            'route'  => 'admin.meeqat-locations.index',
                            'label'  => 'Meeqat Locations',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        ],
                        [
                            'route'  => 'admin.messages.index',
                            'label'  => 'Messages',
                            'roles'  => [1, 2],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                        ],
                        [
                            'route'  => 'admin.analytics',
                            'label'  => 'Analytics',
                            'roles'  => [1],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                        ],
                        [
                            'route'  => 'admin.logs',
                            'label'  => 'Activity Logs',
                            'roles'  => [1],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>',
                        ],
                        [
                            'route'  => 'admin.settings',
                            'label'  => 'Settings',
                            'roles'  => [1],
                            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        ],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @if(in_array(auth()->user()->role_id, $item['roles']))
                        @php $isActive = request()->routeIs($item['route']); @endphp
                        <a
                            href="{{ route($item['route']) }}"
                            title="{{ $item['label'] }}"
                            class="sidebar-link {{ $isActive ? 'sidebar-link-active' : '' }}"
                            :class="!sidebarOpen && 'justify-center px-0'"
                            aria-current="{{ $isActive ? 'page' : 'false' }}"
                        >
                            <svg class="w-5 h-5 flex-shrink-0"
                                 fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 aria-hidden="true">
                                {!! $item['icon'] !!}
                            </svg>
                            <span x-show="sidebarOpen"
                                  x-transition:enter="transition ease-out duration-200"
                                  x-transition:enter-start="opacity-0"
                                  x-transition:enter-end="opacity-100"
                                  class="truncate">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>

            {{-- ── User Info ──────────────────────────────── --}}
            <div class="border-t border-dark-800/50 p-3">
                <div class="flex items-center gap-3" :class="!sidebarOpen && 'justify-center'">
                    {{-- Avatar --}}
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700
                                flex items-center justify-center text-white text-caption font-bold
                                flex-shrink-0"
                         aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    {{-- Name & Role --}}
                    <div x-show="sidebarOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="flex-1 min-w-0">
                        <p class="text-white text-body-sm font-semibold truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-dark-500 text-caption truncate">
                            {{ auth()->user()->role?->label }}
                        </p>
                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen">
                        @csrf
                        <button
                            type="submit"
                            class="p-1.5 rounded-btn text-dark-500 hover:text-red-400
                                   hover:bg-red-500/10 transition-colors duration-200
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400"
                            title="Logout"
                            aria-label="Logout"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ══════════ MAIN CONTENT ══════════ --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- ── Top Bar ────────────────────────────────── --}}
            <header class="bg-sidebar border-b border-dark-800/50 px-6 py-4
                           flex items-center justify-between flex-shrink-0">
                <div>
                    <h1 class="text-white font-bold font-heading text-lg tracking-tight leading-none">
                        @yield('page_title', 'Dashboard')
                    </h1>
                    @hasSection('page_subtitle')
                        <p class="text-dark-400 text-caption mt-1">@yield('page_subtitle')</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    {{-- View Site --}}
                    <a href="{{ route('home') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center gap-2 px-3 py-2 rounded-btn
                              bg-dark-800 border border-dark-700
                              text-dark-300 hover:text-white text-caption
                              transition-all duration-200 hover:bg-dark-700
                              hover:border-dark-600
                              focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>View Site</span>
                    </a>

                    {{-- Role Badge --}}
                    <span class="badge-green">
                        {{ auth()->user()->role?->label }}
                    </span>
                </div>
            </header>

            {{-- ── Page Content ────────────────────────────── --}}
            <main class="flex-1 overflow-y-auto p-6 bg-background">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>