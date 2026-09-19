<x-guest-layout title="Forgot Password — Meeqat.io">

<div x-data="{ loading: false }">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500/20 to-primary-600/10 border border-primary-500/30 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H8v2H7v-4.258a6 6 0 01-.257-1.257L4.257 15A6 6 0 0110 9.257V7m4 4v.01M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-heading">Forgot Password?</h1>
        <p class="text-muted text-sm mt-1">We'll email you a password reset link</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="alert-success mb-6">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm">{{ session('status') }}</p>
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert-error mb-6">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                @foreach($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('password.email') }}" @submit="loading = true">
        @csrf

        {{-- Email --}}
        <div class="mb-6">
            <label class="form-label">
                Email Address <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="yourname@email.com"
                    required
                    autofocus
                    autocomplete="email"
                    class="form-input pl-12 @error('email') border-red-500 @enderror"
                >
            </div>
            @error('email')
                <p class="form-error mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            :disabled="loading"
            class="btn btn-primary w-full btn-lg"
        >
            <template x-if="!loading">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Send Reset Link
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

    {{-- Back to Login --}}
    <div class="text-center">
        <a href="{{ route('login') }}" class="text-muted hover:text-heading text-sm transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Login
        </a>
    </div>

    {{-- Back to Home --}}
    <div class="text-center mt-5">
        <a href="{{ route('home') }}" class="text-muted hover:text-heading text-sm transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Meeqat.io
        </a>
    </div>
</div>
</x-guest-layout>
