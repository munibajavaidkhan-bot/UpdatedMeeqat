<x-guest-layout title="Verify Email — Meeqat.io">

<div x-data="{ loading: false }">

    {{-- Icon --}}
    <div class="text-center mb-6">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-500/20 to-primary-600/10 border border-primary-500/30 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-heading">Verify Your Email</h1>
        <p class="text-muted text-sm mt-1">We've sent a verification link to <strong class="text-heading">{{ auth()->user()->email }}</strong></p>
    </div>

    {{-- Success Message --}}
    @if (session('status') == 'verification-link-sent')
        <div class="alert-success mb-6">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm">A new verification link has been sent to your email.</p>
        </div>
    @endif

    <p class="text-muted text-sm mb-6">
        Please check your inbox and click the link to activate your account.
    </p>

    {{-- Resend Form --}}
    <form method="POST" action="{{ route('verification.send') }}" @submit="loading = true">
        @csrf
        <button
            type="submit"
            :disabled="loading"
            class="btn btn-primary w-full btn-lg"
        >
            <template x-if="!loading">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Resend Verification Email
                </span>
            </template>
            <template x-if="loading">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Sending...
                </span>
            </template>
        </button>
    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-4 my-6">
        <div class="flex-1 h-px bg-border"></div>
        <span class="text-muted text-xs">OR</span>
        <div class="flex-1 h-px bg-border"></div>
    </div>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="text-muted hover:text-heading text-sm transition-colors">
            Logout
        </button>
    </form>

    {{-- Back to Home --}}
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-muted hover:text-heading text-sm transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Meeqat.io
        </a>
    </div>
</div>
</x-guest-layout>
