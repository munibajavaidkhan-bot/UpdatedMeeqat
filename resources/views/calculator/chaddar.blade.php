@{-- resources/views/calculator/chaddar.blade.php --}}
@extends('layouts.app')

@section('title', 'Irani Chaddar Size Calculator')
@section('meta_description', 'Calculate exact fabric meters needed for your Irani Chaddar based on height and style.')

@section('content')

{{-- ══════════════════════════════════════════
    PAGE HEADER — uses bg-mesh like dashboard
══════════════════════════════════════════ --}}
<div class="relative pt-32 pb-14 overflow-hidden">
    <div class="absolute inset-0 bg-mesh" aria-hidden="true"></div>
    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;" aria-hidden="true"></div>

    <div class="container-app relative">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('calculator.chaddar') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Calculator</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-primary-500 font-medium">Chaddar Calculator</span>
        </nav>

        {{-- Title Row --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center flex-shrink-0 shadow-glow-green">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-heading font-black text-white leading-tight" style="font-size: clamp(1.75rem, 3.5vw, 2.5rem);">
                        Irani Chaddar
                        <span class="text-primary-400">Size Calculator</span>
                    </h1>
                    <p class="text-dark-300 mt-1 text-body">Calculate exact fabric meters based on your height & style</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-500/15 border border-primary-500/30 flex-shrink-0 self-start">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
                <span class="text-primary-400 font-bold text-body-sm">Free Tool — Always</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
    MAIN CONTENT
══════════════════════════════════════════ --}}
<div class="bg-background py-10 pb-20">
<div class="container-app">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ════════════════════════════════════
            LEFT: Calculator (2 cols)
        ════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-6"
             x-data="{
                unit: 'cm',
                style: '',
                heightCm: '',
                heightFeet: '',
                heightInch: '0',
                loading: false,

                get heightInCm() {
                    if (this.unit === 'cm') return parseFloat(this.heightCm) || 0;
                    const feet = parseInt(this.heightFeet) || 0;
                    const inch = parseInt(this.heightInch) || 0;
                    return Math.round(((feet * 12) + inch) * 2.54 * 100) / 100;
                },
                get isValid() {
                    return this.heightInCm >= 100 && this.heightInCm <= 250 && this.style !== '';
                },
                get heightDisplay() {
                    return this.heightInCm > 0 ? this.heightInCm.toFixed(1) + ' cm' : '';
                }
             }"
             x-init="$watch('unit', () => { heightCm = ''; heightFeet = ''; heightInch = '0'; })"
        >

            {{-- ── MAIN CALCULATOR CARD ── --}}
            <div class="card animate-slide-up">
                {{-- Card Header --}}
                <div class="card-header flex items-center justify-between">
                    <div>
                        <h2 class="text-heading font-heading font-bold text-h4">Fabric Calculator</h2>
                        <p class="text-muted text-body-sm mt-0.5">Complete all 3 steps to get your result</p>
                    </div>
                    <span class="badge-green">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
                        Free Tool
                    </span>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <form action="{{ route('calculator.chaddar.calculate') }}" method="POST"
                          @submit="loading = true" novalidate>
                        @csrf

                        {{-- ══ STEP 1: Unit ══ --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="stat-icon bg-primary-50 border border-primary-200 w-8 h-8 text-caption font-extrabold text-primary-600">1</div>
                                <div>
                                    <h3 class="text-heading font-heading font-bold text-body">Select Height Unit</h3>
                                    <p class="text-muted text-caption">Choose how you measure your height</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- CM --}}
                                <label class="cursor-pointer block">
                                    <input type="radio" name="unit" value="cm" x-model="unit" class="sr-only">
                                    <div class="border-2 rounded-[14px] p-5 text-center select-none transition-all duration-200"
                                         :class="unit === 'cm'
                                             ? 'border-primary-500 bg-primary-50 shadow-[0_0_0_3px_rgba(16,185,129,0.1)]'
                                             : 'border-border bg-surface hover:border-primary-300 hover:bg-primary-50/50 hover:-translate-y-0.5'">
                                        <div class="w-12 h-12 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center mx-auto mb-2.5">
                                            <svg class="w-5.5 h-5.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                            </svg>
                                        </div>
                                        <div class="font-bold text-body-sm text-heading">Centimeter</div>
                                        <div class="text-caption text-muted mt-0.5">e.g., 170 cm</div>
                                        <div class="flex justify-center mt-2.5">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                 :class="unit === 'cm' ? 'border-primary-500 bg-primary-500' : 'border-dark-300'">
                                                <svg x-show="unit === 'cm'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                {{-- Feet --}}
                                <label class="cursor-pointer block">
                                    <input type="radio" name="unit" value="feet" x-model="unit" class="sr-only">
                                    <div class="border-2 rounded-[14px] p-5 text-center select-none transition-all duration-200"
                                         :class="unit === 'feet'
                                             ? 'border-primary-500 bg-primary-50 shadow-[0_0_0_3px_rgba(16,185,129,0.1)]'
                                             : 'border-border bg-surface hover:border-primary-300 hover:bg-primary-50/50 hover:-translate-y-0.5'">
                                        <div class="w-12 h-12 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center mx-auto mb-2.5">
                                            <svg class="w-5.5 h-5.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                            </svg>
                                        </div>
                                        <div class="font-bold text-body-sm text-heading">Feet & Inches</div>
                                        <div class="text-caption text-muted mt-0.5">e.g., 5'7"</div>
                                        <div class="flex justify-center mt-2.5">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                 :class="unit === 'feet' ? 'border-primary-500 bg-primary-500' : 'border-dark-300'">
                                                <svg x-show="unit === 'feet'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- ══ STEP 2: Height Input ══ --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="stat-icon bg-primary-50 border border-primary-200 w-8 h-8 text-caption font-extrabold text-primary-600">2</div>
                                <div>
                                    <h3 class="text-heading font-heading font-bold text-body">Enter Your Height</h3>
                                    <p class="text-muted text-caption">Accurate height gives precise fabric measurement</p>
                                </div>
                            </div>

                            {{-- CM Input --}}
                            <div x-show="unit === 'cm'"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100">
                                <div class="relative">
                                    <input type="number" name="height_cm" id="height_cm" x-model="heightCm"
                                           placeholder="170" min="100" max="250" step="0.5"
                                           class="form-input text-lg pr-16"
                                           :class="heightCm && (heightCm < 100 || heightCm > 250) ? 'border-red-400 focus:border-red-400 focus:ring-red-400/20' : ''"
                                           aria-describedby="cm-hint">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-muted text-sm pointer-events-none font-medium">cm</span>
                                </div>
                                <p id="cm-hint" class="flex items-center gap-1 text-caption text-muted mt-1.5">
                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Valid range: 100 – 250 cm
                                </p>
                                @error('height_cm')
                                    <p class="form-error mt-2" role="alert">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Feet Input --}}
                            <div x-show="unit === 'feet'"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="height_feet" class="form-label">Feet</label>
                                        <div class="relative">
                                            <input type="number" name="height_feet" id="height_feet"
                                                   x-model="heightFeet" placeholder="5" min="4" max="8"
                                                   class="form-input pr-14">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-muted text-sm pointer-events-none font-medium">ft</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="height_inch" class="form-label">Inches</label>
                                        <select name="height_inch" id="height_inch" x-model="heightInch" class="form-select">
                                            @for($i = 0; $i <= 11; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Height Preview --}}
                            <div x-show="heightInCm > 0"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 class="flex items-center gap-2 p-3 bg-primary-50 border border-primary-200 rounded-xl mt-3 text-body-sm text-primary-600 font-medium"
                                 aria-live="polite">
                                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Your height: <strong x-text="heightDisplay" class="text-primary-700"></strong>
                            </div>
                        </div>

                        {{-- ══ STEP 3: Style ══ --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="stat-icon bg-primary-50 border border-primary-200 w-8 h-8 text-caption font-extrabold text-primary-600">3</div>
                                <div>
                                    <h3 class="text-heading font-heading font-bold text-body">Select Chaddar Style</h3>
                                    <p class="text-muted text-caption">Each style has different fabric requirements</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Full Body --}}
                                <label class="cursor-pointer block">
                                    <input type="radio" name="style" value="full" x-model="style" class="sr-only" aria-label="Full body style">
                                    <div class="border-2 rounded-2xl p-5 select-none h-full transition-all duration-250"
                                         :class="style === 'full'
                                             ? 'border-primary-500 bg-primary-50 shadow-[0_0_0_4px_rgba(16,185,129,0.08)]'
                                             : 'border-border bg-surface hover:border-primary-300 hover:bg-primary-50/50 hover:-translate-y-0.5 hover:shadow-card'">
                                        <div class="flex items-start justify-between mb-3.5">
                                            <div class="w-11 h-11 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                                                <svg class="w-5.5 h-5.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V5a2 2 0 012-2h14a2 2 0 012 2v16M9 21V12h6v9"/>
                                                </svg>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                 :class="style === 'full' ? 'border-primary-500 bg-primary-500' : 'border-dark-300'">
                                                <svg x-show="style === 'full'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-heading font-bold text-body-sm mb-1.5">Full Body Style</h4>
                                        <p class="text-muted text-caption leading-relaxed mb-3">Reaches the feet. Maximum coverage. Traditional & Sunnah style.</p>
                                        <span class="badge-green">Recommended</span>
                                    </div>
                                </label>

                                {{-- Shoulder --}}
                                <label class="cursor-pointer block">
                                    <input type="radio" name="style" value="shoulder" x-model="style" class="sr-only" aria-label="Shoulder style">
                                    <div class="border-2 rounded-2xl p-5 select-none h-full transition-all duration-250"
                                         :class="style === 'shoulder'
                                             ? 'border-primary-500 bg-primary-50 shadow-[0_0_0_4px_rgba(16,185,129,0.08)]'
                                             : 'border-border bg-surface hover:border-primary-300 hover:bg-primary-50/50 hover:-translate-y-0.5 hover:shadow-card'">
                                        <div class="flex items-start justify-between mb-3.5">
                                            <div class="w-11 h-11 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                                                <svg class="w-5.5 h-5.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all duration-200"
                                                 :class="style === 'shoulder' ? 'border-primary-500 bg-primary-500' : 'border-dark-300'">
                                                <svg x-show="style === 'shoulder'" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 class="text-heading font-bold text-body-sm mb-1.5">Shoulder Style</h4>
                                        <p class="text-muted text-caption leading-relaxed mb-3">From shoulder down. Lightweight & comfortable in warm weather.</p>
                                        <span class="badge-green">Lightweight</span>
                                    </div>
                                </label>
                            </div>

                            @error('style')
                                <p class="form-error mt-2.5" role="alert">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ══ Submit Button ══ --}}
                        <button type="submit" :disabled="!isValid || loading"
                                class="btn btn-primary w-full btn-lg shadow-glow-green"
                                :class="!isValid || loading ? 'opacity-50 cursor-not-allowed shadow-none' : ''">
                            <template x-if="!loading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Calculate Fabric Size
                                </span>
                            </template>
                            <template x-if="loading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Calculating...
                                </span>
                            </template>
                        </button>

                        @guest
                            <div class="flex items-center justify-center gap-1.5 mt-3.5">
                                <svg class="w-3.5 h-3.5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <p class="text-caption text-muted">
                                    <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-semibold transition-colors">Login</a>
                                    to save your results automatically
                                </p>
                            </div>
                        @endguest
                    </form>
                </div>
            </div>

            {{-- ── SIZE REFERENCE TABLE ── --}}
            <div class="card overflow-hidden animate-slide-up" style="animation-delay: 0.1s;" x-data="{ activeStyle: 'full' }">
                {{-- Header --}}
                <div class="px-6 py-5 border-b border-border">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-500/15 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-heading font-heading font-bold text-body">Size Reference Table</h3>
                                <p class="text-muted text-caption mt-0.5">Standard sizes for all heights</p>
                            </div>
                        </div>
                        <div class="flex rounded-btn overflow-hidden border border-border bg-dark-50 flex-shrink-0">
                            <button @click="activeStyle = 'full'"
                                    class="px-4 py-2 text-caption font-semibold transition-all duration-200"
                                    :class="activeStyle === 'full' ? 'bg-primary-500 text-white shadow-sm' : 'bg-transparent text-muted hover:text-heading'">
                                Full Body
                            </button>
                            <button @click="activeStyle = 'shoulder'"
                                    class="px-4 py-2 text-caption font-semibold transition-all duration-200"
                                    :class="activeStyle === 'shoulder' ? 'bg-primary-500 text-white shadow-sm' : 'bg-transparent text-muted hover:text-heading'">
                                Shoulder
                            </button>
                        </div>
                    </div>
                </div>

                @php $svc = app(\App\Services\ChadarSizeService::class); @endphp

                {{-- Full Table --}}
                <div x-show="activeStyle === 'full'" x-transition>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border">
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50 w-20">Size</th>
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50">Height Range</th>
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50">In Feet</th>
                                    <th class="px-6 py-3 text-right text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50 w-24">Fabric</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fullRules as $rule)
                                    <tr class="border-b border-border/60 last:border-0 hover:bg-primary-50/30 transition-colors duration-150">
                                        <td class="px-6 py-3"><span class="badge-gray">{{ $rule->size_label }}</span></td>
                                        <td class="px-6 py-3 font-mono text-caption text-dark-500">{{ $rule->height_range }}</td>
                                        <td class="px-6 py-3 text-caption text-dark-400">{{ $svc->cmToFeet($rule->height_min_cm) }} – {{ $svc->cmToFeet($rule->height_max_cm) }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <span class="text-primary-600 font-bold text-body-sm">{{ $rule->fabric_meters }}m</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Shoulder Table --}}
                <div x-show="activeStyle === 'shoulder'" x-transition>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border">
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50 w-20">Size</th>
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50">Height Range</th>
                                    <th class="px-6 py-3 text-left text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50">In Feet</th>
                                    <th class="px-6 py-3 text-right text-caption font-semibold text-muted uppercase tracking-wider bg-dark-50/50 w-24">Fabric</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shoulderRules as $rule)
                                    <tr class="border-b border-border/60 last:border-0 hover:bg-primary-50/30 transition-colors duration-150">
                                        <td class="px-6 py-3"><span class="badge-gray">{{ $rule->size_label }}</span></td>
                                        <td class="px-6 py-3 font-mono text-caption text-dark-500">{{ $rule->height_range }}</td>
                                        <td class="px-6 py-3 text-caption text-dark-400">{{ $svc->cmToFeet($rule->height_min_cm) }} – {{ $svc->cmToFeet($rule->height_max_cm) }}</td>
                                        <td class="px-6 py-3 text-right">
                                            <span class="text-primary-600 font-bold text-body-sm">{{ $rule->fabric_meters }}m</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════
            RIGHT: Sidebar (1 col)
        ════════════════════════════════════ --}}
        <div class="space-y-5 animate-slide-up" style="animation-delay: 0.15s;">

            {{-- Recent Calculations --}}
            @auth
                @if($recentCalculations && $recentCalculations->count() > 0)
                    <div class="card card-body">
                        <h3 class="text-heading font-heading font-bold text-body-sm flex items-center gap-2 mb-3.5">
                            <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Recent Calculations
                        </h3>
                        @foreach($recentCalculations as $calc)
                            <a href="{{ route('calculator.chaddar.result', $calc->id) }}"
                               class="flex items-center justify-between p-3 rounded-xl bg-dark-50 border border-border text-decoration-none mb-1.5 last:mb-0 hover:border-primary-300 hover:bg-primary-50/50 transition-all duration-200">
                                <div>
                                    <p class="text-heading text-body-sm font-semibold">{{ $calc->height_cm }}cm · {{ ucfirst($calc->style) }}</p>
                                    <p class="text-muted text-caption mt-0.5">{{ $calc->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-primary-600 font-extrabold text-body">{{ $calc->calculated_meters }}m</span>
                                    <p class="text-muted text-caption mt-0.5">{{ $calc->size_label }}</p>
                                </div>
                            </a>
                        @endforeach
                        <a href="{{ route('user.history') }}"
                           class="flex items-center justify-center gap-1.5 text-caption font-medium text-primary-500 hover:text-primary-700 transition-colors mt-3 pt-3 border-t border-border">
                            View all history
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @endif
            @endauth

            {{-- How It Works --}}
            <div class="card card-body">
                <h3 class="text-heading font-heading font-bold text-body-sm flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    How It Works
                </h3>
                <ol class="space-y-2.5">
                    @foreach([
                        'Enter your height in CM or Feet & Inches',
                        'Choose Full Body or Shoulder style',
                        'Click Calculate — instant accurate result',
                        'Share or purchase the exact fabric amount',
                    ] as $i => $step)
                        <li class="flex items-start gap-2.5">
                            <div class="stat-icon bg-primary-50 border border-primary-200 w-6 h-6 text-caption font-extrabold text-primary-600 flex-shrink-0 mt-0.5">{{ $i + 1 }}</div>
                            <p class="text-muted text-body-sm leading-relaxed pt-0.5">{{ $step }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Buying Tips --}}
            <div class="card card-body">
                <h3 class="text-heading font-heading font-bold text-body-sm flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Fabric Buying Tips
                </h3>
                <ul class="space-y-2">
                    @foreach([
                        'Always prefer pure cotton fabric',
                        'Egyptian cotton is the best quality',
                        'Keep extra 0.5 meter for tailoring',
                        'Pre-washed fabric prevents shrinkage',
                        'White or off-white is traditional',
                        'Fabric should be seamless for Ihram',
                    ] as $tip)
                        <li class="flex items-start gap-2">
                            <svg class="w-3.5 h-3.5 text-primary-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-body-sm text-muted leading-relaxed">{{ $tip }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Other Tools --}}
            <div class="card card-body">
                <p class="text-caption font-bold text-muted uppercase tracking-wider mb-2.5">Other Tools</p>
                <nav class="flex flex-col gap-0.5">
                    @php
                        $tools = [
                            ['label' => 'Meeqat Finder',  'route' => 'meeqat.finder', 'colorClass' => 'primary',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                            ['label' => 'Duas & Niyat',   'route' => 'duas.index',    'colorClass' => 'primary',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                            ['label' => 'Ihram Guide',    'route' => 'ihram.index',   'colorClass' => 'primary',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                            ['label' => 'Virtual Try-On', 'route' => 'tryon.index',   'colorClass' => 'primary',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
                        ];
                    @endphp
                    @foreach($tools as $tool)
                        <a href="{{ route($tool['route']) }}"
                           class="flex items-center gap-2.5 px-2.5 py-2 rounded-xl hover:bg-primary-50 transition-colors duration-150 group">
                            <div class="w-8 h-8 rounded-lg bg-{{ $tool['colorClass'] }}-50 border border-{{ $tool['colorClass'] }}-200 flex items-center justify-center flex-shrink-0 group-hover:bg-{{ $tool['colorClass'] }}-100 transition-colors">
                                <svg class="w-4 h-4 text-{{ $tool['colorClass'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" aria-hidden="true">
                                    {!! $tool['icon'] !!}
                                </svg>
                            </div>
                            <span class="text-body-sm font-medium text-muted group-hover:text-heading transition-colors">{{ $tool['label'] }}</span>
                            <svg class="w-3.5 h-3.5 text-dark-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Ihram Note --}}
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <svg class="w-8 h-8 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                    </svg>
                    <div>
                        <h4 class="text-primary-800 font-heading font-bold text-body-sm mb-1.5">Ihram Chaddar Note</h4>
                        <p class="text-primary-700 text-caption leading-relaxed mb-2.5">
                            For Hajj & Umrah, you need <strong>2 pieces</strong> of white unsewn cloth —
                            <em>Izar</em> (waist wrap) and <em>Rida</em> (shoulder drape).
                        </p>
                        <a href="{{ route('ihram.index') }}"
                           class="inline-flex items-center gap-1 text-caption font-semibold text-primary-600 hover:text-primary-800 transition-colors">
                            Learn about Ihram rules
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /sidebar --}}
    </div>
</div>
</div>

@endsection
