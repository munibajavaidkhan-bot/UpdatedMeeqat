{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }"
     class="bg-surface border-b border-border sticky top-0 z-50"
     aria-label="Dashboard navigation">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- ── Logo + Links ─────────────────────────── --}}
            <div class="flex items-center gap-8">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2.5 group"
                   aria-label="Meeqat.io dashboard">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700
                                flex items-center justify-center
                                shadow-btn group-hover:shadow-glow-green
                                group-hover:scale-105 transition-all duration-200">
                        <span class="text-white font-bold text-sm font-heading" aria-hidden="true">M</span>
                    </div>
                    <span class="text-heading font-bold font-heading text-lg leading-none">
                        Meeqat<span class="text-primary-500">.io</span>
                    </span>
                </a>

                {{-- Desktop Links --}}
                <div class="hidden sm:flex items-center gap-1" role="navigation" aria-label="Main links">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- ── User Dropdown (Desktop) ───────────────── --}}
            <div class="hidden sm:flex sm:items-center gap-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-2.5 px-3 py-2 rounded-btn
                                   bg-surface border border-border
                                   hover:border-dark-300 hover:bg-dark-50
                                   transition-all duration-200
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500"
                            aria-haspopup="true"
                        >
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700
                                        flex items-center justify-center text-white text-caption font-bold"
                                 aria-hidden="true">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-heading text-body-sm font-medium">
                                {{ Str::limit(Auth::user()->name, 14) }}
                            </span>
                            <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- ── Hamburger (Mobile) ───────────────────── --}}
            <div class="flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="w-10 h-10 rounded-btn flex items-center justify-center
                           text-muted hover:text-heading hover:bg-dark-100
                           transition-colors duration-200
                           focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-500"
                    :aria-expanded="open"
                    aria-label="Toggle navigation menu"
                >
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Mobile Menu ───────────────────────────────── --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-border">
        <div class="py-3 px-4 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-border py-3 px-4">
            <div class="mb-3">
                <p class="text-body-sm font-semibold text-heading">{{ Auth::user()->name }}</p>
                <p class="text-caption text-muted">{{ Auth::user()->email }}</p>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>