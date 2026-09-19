<x-guest-layout title="Confirm Password — Meeqat.io">

<div x-data="{ loading: false }">

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500/20 to-primary-600/10 border border-primary-500/30 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-heading">Confirm Password</h1>
        <p class="text-muted text-sm mt-1">This is a secure area. Please confirm your password before continuing.</p>
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
    <form method="POST" action="{{ route('password.confirm') }}" @submit="loading = true">
        @csrf

        {{-- Password --}}
        <div class="mb-6">
            <label class="form-label">
                Password <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                    class="form-input pl-12 @error('password') border-red-500 @enderror"
                >
            </div>
            @error('password')
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Confirm Password
                </span>
            </template>
            <template x-if="loading">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Verifying...
                </span>
            </template>
        </button>
    </form>
</div>
</x-guest-layout>
