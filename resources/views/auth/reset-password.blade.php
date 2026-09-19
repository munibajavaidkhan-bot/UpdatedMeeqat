<x-guest-layout title="Reset Password — Meeqat.io">

<div x-data="{
    showPass: false,
    showConfirm: false,
    loading: false,
    password: '',
    strength: 0,
    getStrength() {
        let s = 0;
        if (this.password.length >= 8) s++;
        if (/[A-Z]/.test(this.password)) s++;
        if (/[0-9]/.test(this.password)) s++;
        if (/[^A-Za-z0-9]/.test(this.password)) s++;
        this.strength = s;
    }
}">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500/20 to-primary-600/10 border border-primary-500/30 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H8v2H7v-4.258a6 6 0 01-.257-1.257L4.257 15A6 6 0 0110 9.257V7m4 4v.01M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-heading">Set New Password</h1>
        <p class="text-muted text-sm mt-1">Enter your new secure password</p>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert-error mb-6">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('password.store') }}" @submit="loading = true">
        @csrf

        {{-- Hidden Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="mb-5">
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
                    value="{{ old('email', $request->email) }}"
                    placeholder="your@email.com"
                    required
                    autocomplete="email"
                    class="form-input pl-12 @error('email') border-red-500 @enderror"
                >
            </div>
            @error('email')
                <p class="form-error mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="mb-5">
            <label class="form-label">
                New Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    :type="showPass ? 'text' : 'password'"
                    name="password"
                    x-model="password"
                    @input="getStrength()"
                    placeholder="Min 8 characters"
                    required
                    autocomplete="new-password"
                    class="form-input pl-12 pr-12 @error('password') border-red-500 @enderror"
                >
                <button
                    type="button"
                    @click="showPass = !showPass"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-heading transition-colors"
                >
                    <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>

            {{-- Strength Bar --}}
            <div x-show="password.length > 0" x-transition class="mt-2">
                <div class="flex gap-1 mb-1.5">
                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                         :class="strength >= 1 ? (strength <= 1 ? 'bg-red-500' : strength <= 2 ? 'bg-secondary-500' : strength <= 3 ? 'bg-blue-500' : 'bg-primary-500') : 'bg-dark-200'">
                    </div>
                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                         :class="strength >= 2 ? (strength <= 2 ? 'bg-secondary-500' : strength <= 3 ? 'bg-blue-500' : 'bg-primary-500') : 'bg-dark-200'">
                    </div>
                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                         :class="strength >= 3 ? (strength <= 3 ? 'bg-blue-500' : 'bg-primary-500') : 'bg-dark-200'">
                    </div>
                    <div class="h-1 flex-1 rounded-full transition-all duration-300"
                         :class="strength >= 4 ? 'bg-primary-500' : 'bg-dark-200'">
                    </div>
                </div>
                <p class="text-xs font-medium"
                   :class="strength <= 1 ? 'text-red-500' : strength <= 2 ? 'text-secondary-500' : strength <= 3 ? 'text-blue-500' : 'text-primary-500'">
                    <span x-text="strength <= 1 ? 'Weak - create a strong password' : strength <= 2 ? 'Fair - make it stronger' : strength <= 3 ? 'Good - quite good' : 'Strong - excellent password!'"></span>
                </p>
            </div>

            @error('password')
                <p class="form-error mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-6">
            <label class="form-label">
                Confirm Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input
                    :type="showConfirm ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="Re-enter your password"
                    required
                    autocomplete="new-password"
                    class="form-input pl-12 pr-12"
                >
                <button
                    type="button"
                    @click="showConfirm = !showConfirm"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-heading transition-colors"
                >
                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Reset Password
                </span>
            </template>
            <template x-if="loading">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Resetting...
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
    <a href="{{ route('login') }}"
       class="btn btn-secondary w-full justify-center">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Login
    </a>

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
