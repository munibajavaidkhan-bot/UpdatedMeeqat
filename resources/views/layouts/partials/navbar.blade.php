{{-- resources/views/layouts/partials/navbar.blade.php --}}
{{-- Welcome-page style navigation --}}
<nav class="fixed top-0 left-0 right-0 z-[100]"
     style="background:rgba(11,15,20,.85);backdrop-filter:blur(14px);border-bottom:1px solid rgba(255,255,255,.06)"
     x-data="{ open: false, more: false }"
     aria-label="Main navigation">
    <div class="max-w-[1200px] mx-auto flex items-center justify-between px-5 py-3">

        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="Meeqat.io">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-lg">
                <span class="text-white font-black text-base font-heading">M</span>
            </div>
            <div class="leading-tight">
                <span class="block text-white font-bold text-base font-heading">Meeqat<span class="text-primary-400">.io</span></span>
                <span class="hidden sm:block text-[10px] text-white/40 tracking-wide">Hajj & Umrah Companion</span>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('home') }}"
               class="px-4 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-white' : 'text-white/60 hover:text-white' }} transition-colors relative">
                Home
                @if(request()->routeIs('home'))
                    <span class="absolute left-4 right-4 -bottom-3 h-0.5 bg-primary-500 rounded-full"></span>
                @endif
            </a>
            <a href="{{ route('calculator.chaddar') }}"
               class="px-4 py-2 text-sm font-medium {{ request()->routeIs('calculator.*') ? 'text-white' : 'text-white/60 hover:text-white' }} transition-colors">Calculator</a>
            <a href="{{ route('meeqat.finder') }}"
               class="px-4 py-2 text-sm font-medium {{ request()->routeIs('meeqat.*') ? 'text-white' : 'text-white/60 hover:text-white' }} transition-colors">Meeqat Finder</a>
            <a href="{{ route('duas.index') }}"
               class="px-4 py-2 text-sm font-medium {{ request()->routeIs('duas.*') ? 'text-white' : 'text-white/60 hover:text-white' }} transition-colors">Duas & Niyat</a>
            <a href="{{ route('ihram.index') }}"
               class="px-4 py-2 text-sm font-medium {{ request()->routeIs('ihram.*') ? 'text-white' : 'text-white/60 hover:text-white' }} transition-colors">Ihram Guide</a>

            {{-- More Dropdown --}}
            <div class="relative" @mouseleave="more=false">
                <button @click="more=!more" @mouseenter="more=true"
                        class="px-4 py-2 text-sm font-medium text-white/60 hover:text-white transition-colors inline-flex items-center gap-1">
                    More
                    <svg class="w-3.5 h-3.5 transition-transform" :class="more && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="more" x-transition x-cloak class="absolute top-full right-0 mt-1 w-52 rounded-xl overflow-hidden"
                     style="background:#12171f;border:1px solid rgba(255,255,255,.08)" @mouseenter="more=true" @mouseleave="more=false">
                    <a href="{{ route('tryon.index') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Virtual Try-On</a>
                    <a href="{{ route('tools.hajj-checklist') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Hajj Checklist</a>
                    <a href="{{ route('tools.qibla') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Qibla Direction</a>
                    <a href="{{ route('tools.prayer-times') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5">Prayer Times</a>
                    <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:text-white hover:bg-white/5 border-t border-white/5">About</a>
                </div>
            </div>
        </div>

        {{-- Right Side Auth --}}
        <div class="hidden md:flex items-center gap-3">
            @auth
                @if(auth()->user()->isAdminOrEditor())
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-amber-400 border border-amber-500/30 hover:bg-amber-500/10 transition-all">Admin Panel</a>
                @endif
                <a href="{{ auth()->user()->isAdminOrEditor() ? route('admin.dashboard') : route('dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-semibold" style="color:#34d399">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-medium text-white/50 hover:text-white/80 border border-white/10 hover:border-white/30 transition-all">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-white border border-white/15 hover:border-white/30 transition-all">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-bold text-[#04241a] transition-all" style="background:#10b981">Sign Up</a>
            @endauth
        </div>

        {{-- Mobile Menu Button --}}
        <button @click="open = !open" class="md:hidden p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition-all" aria-label="Toggle navigation" :aria-expanded="open">
            <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition x-cloak class="md:hidden border-t border-white/10" style="background:rgba(11,15,20,.97);backdrop-filter:blur(20px)" @click.outside="open=false">
        <div class="px-4 py-4 space-y-1 max-w-[1200px] mx-auto">
            <a href="{{ route('home') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">Home</a>
            <a href="{{ route('calculator.chaddar') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('calculator.*') ? 'text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">Calculator</a>
            <a href="{{ route('meeqat.finder') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('meeqat.*') ? 'text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">Meeqat Finder</a>
            <a href="{{ route('duas.index') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('duas.*') ? 'text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">Duas & Niyat</a>
            <a href="{{ route('ihram.index') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('ihram.*') ? 'text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">Ihram Guide</a>
            <a href="{{ route('tryon.index') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Virtual Try-On</a>
            <a href="{{ route('tools.hajj-checklist') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Hajj Checklist</a>
            <a href="{{ route('tools.qibla') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Qibla Direction</a>
            <a href="{{ route('tools.prayer-times') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Prayer Times</a>
            <a href="{{ route('about') }}" @click="open=false"
               class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">About</a>

            <hr class="border-white/10 my-2">
            @auth
                @if(auth()->user()->isAdminOrEditor())
                    <a href="{{ route('admin.dashboard') }}" @click="open=false"
                       class="block px-4 py-2.5 rounded-lg text-sm font-medium text-amber-400 hover:bg-white/5">Admin Panel</a>
                @endif
                <a href="{{ auth()->user()->isAdminOrEditor() ? route('admin.dashboard') : route('dashboard') }}" @click="open=false"
                   class="block px-4 py-2.5 rounded-lg text-sm font-semibold" style="color:#34d399">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2.5 rounded-lg text-sm text-white/50 hover:text-white/80 hover:bg-white/5">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" @click="open=false"
                   class="block px-4 py-2.5 rounded-lg text-sm text-white/70 hover:text-white hover:bg-white/10">Log in</a>
                <a href="{{ route('register') }}" @click="open=false"
                   class="block px-4 py-2.5 rounded-lg text-sm font-bold text-center text-[#04241a]" style="background:#10b981">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>