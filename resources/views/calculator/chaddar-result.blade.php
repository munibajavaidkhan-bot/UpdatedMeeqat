{{-- resources/views/calculator/chaddar-result.blade.php --}}
@extends('layouts.app')

@section('title', 'Irani Chaddar Size Calculator')
@section('meta_description', 'Calculate exact fabric meters needed for your Irani Chaddar based on height and style.')

@push('head')
<style>
    .page-header-gradient {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
        border-bottom: 1px solid #e2e8f0;
    }

    .calc-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s;
    }

    .calc-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .calc-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
    }

    .calc-card-body {
        padding: 24px;
    }

    .step-badge {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: #059669;
        flex-shrink: 0;
    }

    .unit-card {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f8fafc;
        user-select: none;
    }
    .unit-card:hover {
        border-color: #86efac;
        background: #f0fdf4;
    }
    .unit-card.active {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .style-card {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
        user-select: none;
        height: 100%;
    }
    .style-card:hover {
        border-color: #86efac;
        background: #f9fffe;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,185,129,0.1);
    }
    .style-card.active {
        border-color: #10b981;
        background: #f0fdf4;
        box-shadow: 0 0 0 4px rgba(16,185,129,0.08);
    }

    .form-input-modern {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 60px 12px 16px;
        font-size: 1.05rem;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
        -webkit-appearance: none;
        appearance: none;
    }
    .form-input-modern:focus {
        border-color: #10b981;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    .form-input-modern.error {
        border-color: #f87171;
    }
    .form-input-modern::placeholder {
        color: #cbd5e1;
    }

    .form-select-modern {
        width: 100%;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.9rem;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
        -webkit-appearance: none;
        appearance: none;
    }
    .form-select-modern:focus {
        border-color: #10b981;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }

    .form-label-modern {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    /* Table styles */
    .ref-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
    }
    .ref-table thead tr {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .ref-table thead th {
        padding: 10px 16px;
        text-align: left;
        font-weight: 600;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .ref-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .ref-table tbody tr:hover {
        background: #f8fafc;
    }
    .ref-table tbody tr:last-child {
        border-bottom: none;
    }
    .ref-table tbody td {
        padding: 10px 16px;
        color: #475569;
    }

    /* Sidebar cards */
    .sidebar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .sidebar-card-title {
        color: #1e293b;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
    }

    /* Calc history item */
    .history-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s;
    }
    .history-item:hover {
        border-color: #bbf7d0;
        background: #f0fdf4;
    }

    /* Badge */
    .badge-primary {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        background: #dcfce7;
        color: #059669;
    }
    .badge-amber {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        background: #dcfce7;
        color: #059669;
    }
    .badge-gray {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        font-family: monospace;
    }

    /* Tool link */
    .tool-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        transition: all 0.15s;
        text-decoration: none;
    }
    .tool-link:hover {
        background: #f0fdf4;
    }
    .tool-link:hover .tool-link-label {
        color: #1e293b;
    }
    .tool-link-label {
        font-size: 0.82rem;
        font-weight: 500;
        color: #64748b;
        transition: color 0.15s;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up {
        animation: fadeSlideUp 0.4s ease forwards;
    }
</style>
@endpush

@section('content')

{{-- ── Page Header ─────────────────────────────────────────── --}}
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

        {{-- Title row --}}
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
                    <p class="text-dark-300 mt-1 text-body">Calculate fabric meters according to your height and style</p>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-500/15 border border-primary-500/30 flex-shrink-0 self-start">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
                <span class="text-primary-400 font-bold text-body-sm">Free Tool — No Login Required</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Main Content ─────────────────────────────────────────── --}}
<div style="background:#f8fafc;padding-bottom:80px;padding-top:40px">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ═══════════════════════════════════════════════
            LEFT: Calculator (2/3 width)
            ══════════════════════════════════════════════ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- ── RESULT DISPLAY ── --}}
            @if(isset($calculation) && isset($result))
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:20px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.06)" class="fade-up">
                <div style="padding:24px 28px">
                    <div style="text-align:center;margin-bottom:24px">
                        <div style="width:80px;height:80px;border-radius:50%;background:#f0fdf4;border:2px solid #bbf7d0;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                            <svg style="width:40px;height:40px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 style="color:#1e293b;font-weight:800;font-size:1.5rem;margin-bottom:8px">Calculation Result</h2>
                        <p style="color:#94a3b8;font-size:0.85rem">Your fabric measurement is ready</p>
                    </div>

                    <div style="background:#f8fafc;border-radius:16px;padding:20px;margin-bottom:24px">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <span style="color:#64748b;font-size:0.9rem">Height</span>
                            <span style="color:#1e293b;font-weight:700;font-size:1rem">{{ $calculation->height_cm }} cm</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <span style="color:#64748b;font-size:0.9rem">Style</span>
                            <span style="color:#1e293b;font-weight:700;font-size:1rem">{{ ucfirst($calculation->style) }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <span style="color:#64748b;font-size:0.9rem">Size</span>
                            <span style="color:#1e293b;font-weight:700;font-size:1rem">{{ $result['size_label'] ?? '' }}</span>
                        </div>
                    </div>

                    <div style="text-align:center;margin-bottom:24px">
                        <div style="font-size:0.85rem;color:#94a3b8;margin-bottom:4px">Fabric Required</div>
                        <div style="color:#059669;font-weight:900;font-size:3rem;line-height:1">{{ $result['fabric_meters'] ?? 0 }}m</div>
                    </div>

                    <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center">
                        <a href="{{ route('calculator.chaddar') }}" class="btn btn-secondary">Calculate Again</a>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $result['fabric_meters'] ?? 0 }}m')" class="btn btn-primary">Copy Result</button>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── MAIN CALCULATOR CARD ── --}}
            <div class="calc-card fade-up" style="animation-delay:0.1s">
                <div class="calc-card-header">
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <div>
                            <h2 style="color:#1e293b;font-weight:700;font-size:1.1rem">
                                Fabric Calculator
                            </h2>
                            <p style="color:#94a3b8;font-size:0.8rem;margin-top:2px">
                                Complete all 3 steps to get your result
                            </p>
                        </div>
                        <span class="badge-primary">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;display:inline-block"></span>
                            Free Tool
                        </span>
                    </div>
                </div>

                <div class="calc-card-body">
                    <form action="{{ route('calculator.chaddar.calculate') }}" method="POST"
                          @submit="loading = true" novalidate>
                        @csrf

                        {{-- ── STEP 1: Height Unit ── --}}
                        <div style="margin-bottom:32px">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                                <div class="step-badge">1</div>
                                <div>
                                    <h3 style="color:#1e293b;font-weight:600;font-size:0.9rem">
                                        Select Height Unit
                                    </h3>
                                    <p style="color:#94a3b8;font-size:0.75rem;margin-top:1px">
                                        Choose how you measure your height
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- CM --}}
                                <label style="cursor:pointer">
                                    <input type="radio" name="unit" value="cm"
                                           x-model="unit" class="sr-only" aria-label="Centimeter">
                                    <div class="unit-card" :class="unit === 'cm' ? 'active' : ''">
                                        <div style="display:flex;justify-content:center;margin-bottom:10px">
                                            <div style="width:44px;height:44px;border-radius:12px;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center">
                                                <svg style="width:22px;height:22px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div style="font-weight:600;font-size:0.85rem;color:#1e293b">
                                            Centimeter
                                        </div>
                                        <div style="font-size:0.75rem;color:#94a3b8;margin-top:2px">
                                            e.g., 170 cm
                                        </div>
                                        {{-- Active indicator --}}
                                        <div style="margin-top:10px;display:flex;justify-content:center">
                                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e2e8f0;transition:all .2s;display:flex;align-items:center;justify-content:center"
                                                 :style="unit === 'cm' ? 'border-color:#10b981;background:#10b981' : ''">
                                                <svg x-show="unit === 'cm'" style="width:11px;height:11px;color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                {{-- Feet --}}
                                <label style="cursor:pointer">
                                    <input type="radio" name="unit" value="feet"
                                           x-model="unit" class="sr-only" aria-label="Feet and inches">
                                    <div class="unit-card" :class="unit === 'feet' ? 'active' : ''">
                                        <div style="display:flex;justify-content:center;margin-bottom:10px">
                                            <div style="width:44px;height:44px;border-radius:12px;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center">
                                                <svg style="width:22px;height:22px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div style="font-weight:600;font-size:0.85rem;color:#1e293b">
                                            Feet & Inches
                                        </div>
                                        <div style="font-size:0.75rem;color:#94a3b8;margin-top:2px">
                                            e.g., 5'7"
                                        </div>
                                        <div style="margin-top:10px;display:flex;justify-content:center">
                                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e2e8f0;transition:all .2s;display:flex;align-items:center;justify-content:center"
                                                 :style="unit === 'feet' ? 'border-color:#10b981;background:#10b981' : ''">
                                                <svg x-show="unit === 'feet'" style="width:11px;height:11px;color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- ── STEP 2: Height Input ── --}}
                        <div style="margin-bottom:32px">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                                <div class="step-badge">2</div>
                                <div>
                                    <h3 style="color:#1e293b;font-weight:600;font-size:0.9rem">
                                        Enter Your Height
                                    </h3>
                                    <p style="color:#94a3b8;font-size:0.75rem;margin-top:1px">
                                        We'll automatically calculate the exact fabric needed
                                    </p>
                                </div>
                            </div>

                            {{-- CM Input --}}
                            <div x-show="unit === 'cm'"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0">
                                <div style="position:relative">
                                    <input
                                        type="number"
                                        name="height_cm"
                                        id="height_cm"
                                        x-model="heightCm"
                                        placeholder="170"
                                        min="100" max="250" step="0.5"
                                        class="form-input-modern"
                                        :class="heightCm && (heightCm < 100 || heightCm > 250) ? 'error' : ''"
                                        aria-describedby="cm-hint"
                                    >
                                    <span style="position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.85rem;pointer-events:none;font-weight:500">cm</span>
                                </div>
                                <p id="cm-hint" style="color:#94a3b8;font-size:0.75rem;margin-top:6px;display:flex;align-items:center;gap:4px">
                                    <svg style="width:12px;height:12px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Valid range: 100 – 250 cm
                                </p>
                            </div>

                            {{-- Feet Input --}}
                            <div x-show="unit === 'feet'"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="height_feet" class="form-label-modern">Feet</label>
                                        <div style="position:relative">
                                            <input type="number" name="height_feet" id="height_feet"
                                                   x-model="heightFeet" placeholder="5"
                                                   min="4" max="8" class="form-input-modern">
                                            <span style="position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.82rem;pointer-events:none;font-weight:500">ft</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="height_inch" class="form-label-modern">Inches</label>
                                        <select name="height_inch" id="height_inch"
                                                x-model="heightInch" class="form-select-modern">
                                            @for($i = 0; $i <= 11; $i++)
                                                <option value="{{ $i }}">{{ $i }}"</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Live height preview --}}
                            <div x-show="heightInCm > 0"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 style="margin-top:12px;display:flex;align-items:center;gap:8px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px"
                                 aria-live="polite">
                                <svg style="width:16px;height:16px;color:#10b981;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span style="font-size:0.82rem;color:#059669">
                                    Your height: <strong x-text="heightDisplay"></strong>
                                </span>
                            </div>
                        </div>

                        {{-- ── STEP 3: Chaddar Style ── --}}
                        <div style="margin-bottom:32px">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                                <div class="step-badge">3</div>
                                <div>
                                    <h3 style="color:#1e293b;font-weight:600;font-size:0.9rem">
                                        Select Chaddar Style
                                    </h3>
                                    <p style="color:#94a3b8;font-size:0.75rem;margin-top:1px">
                                        Choose the style that suits your preference
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                {{-- Full Body --}}
                                <label style="cursor:pointer;display:block">
                                    <input type="radio" name="style" value="full"
                                           x-model="style" class="sr-only" aria-label="Full body style">
                                    <div class="style-card" :class="style === 'full' ? 'active' : ''">
                                        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                                            <div style="width:42px;height:42px;border-radius:12px;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center">
                                                <svg style="width:20px;height:20px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V5a2 2 0 012-2h14a2 2 0 012 2v16M9 21V12h6v9"/>
                                                </svg>
                                            </div>
                                            {{-- Radio dot --}}
                                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e2e8f0;transition:all .2s;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px"
                                                 :style="style === 'full' ? 'border-color:#10b981;background:#10b981' : ''">
                                                <svg x-show="style === 'full'" style="width:11px;height:11px;color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 style="color:#1e293b;font-weight:700;font-size:0.9rem;margin-bottom:6px">
                                            Full Body Style
                                        </h4>
                                        <p style="color:#64748b;font-size:0.78rem;line-height:1.6;margin-bottom:12px">
                                            Reaches the feet. Maximum coverage, traditional & Sunnah style.
                                        </p>
                                        <span class="badge-primary">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            Recommended
                                        </span>
                                    </div>
                                </label>

                                {{-- Shoulder --}}
                                <label style="cursor:pointer;display:block">
                                    <input type="radio" name="style" value="shoulder"
                                           x-model="style" class="sr-only" aria-label="Shoulder style">
                                    <div class="style-card" :class="style === 'shoulder' ? 'active' : ''">
                                        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                                            <div style="width:42px;height:42px;border-radius:12px;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center">
                                                <svg style="width:20px;height:20px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div style="width:20px;height:20px;border-radius:50%;border:2px solid #e2e8f0;transition:all .2s;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px"
                                                 :style="style === 'shoulder' ? 'border-color:#10b981;background:#10b981' : ''">
                                                <svg x-show="style === 'shoulder'" style="width:11px;height:11px;color:#fff" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <h4 style="color:#1e293b;font-weight:700;font-size:0.9rem;margin-bottom:6px">
                                            Shoulder Style
                                        </h4>
                                        <p style="color:#64748b;font-size:0.78rem;line-height:1.6;margin-bottom:12px">
                                            From shoulder down. Less material, lightweight in warm weather.
                                        </p>
                                        <span class="badge-primary">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                            Lightweight
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- ── Submit Button ── --}}
                        <button
                            type="submit"
                            :disabled="!isValid || loading"
                            style="width:100%;padding:16px;border-radius:14px;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;gap:10px;border:none;transition:all .3s"
                            :style="isValid && !loading
                                ? 'background:linear-gradient(135deg,#10b981,#059669);color:#fff;box-shadow:0 4px 20px rgba(5,150,105,0.3);cursor:pointer'
                                : 'background:#e2e8f0;color:#94a3b8;cursor:not-allowed'"
                        >
                            <template x-if="!loading">
                                <span style="display:flex;align-items:center;gap:10px">
                                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Calculate Fabric Size
                                </span>
                            </template>
                            <template x-if="loading">
                                <span style="display:flex;align-items:center;gap:10px">
                                    <svg style="width:20px;height:20px" class="animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Calculating...
                                </span>
                            </template>
                        </button>

                        @guest
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:14px">
                                <svg style="width:13px;height:13px;color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <p style="font-size:0.78rem;color:#94a3b8">
                                    <a href="{{ route('login') }}" style="color:#10b981;text-decoration:none;font-weight:500">Login</a>
                                    to save your results automatically
                                </p>
                            </div>
                        @endguest
                    </form>
                </div>
            </div>

            {{-- ── SIZE REFERENCE TABLE ── --}}
            <div class="calc-card" x-data="{ activeStyle: 'full' }">
                <div class="calc-card-header">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                        <div>
                            <h3 style="color:#1e293b;font-weight:700;font-size:0.95rem;display:flex;align-items:center;gap:8px">
                                <svg style="width:18px;height:18px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Size Reference Table
                            </h3>
                            <p style="color:#94a3b8;font-size:0.75rem;margin-top:2px">
                                All standard sizes by chaddar style
                            </p>
                        </div>
                        {{-- Style Toggle --}}
                        <div style="display:flex;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0;background:#f8fafc">
                            <button @click="activeStyle = 'full'"
                                    style="padding:7px 16px;font-size:0.8rem;font-weight:600;border:none;cursor:pointer;transition:all .2s"
                                    :style="activeStyle === 'full' ? 'background:#10b981;color:#fff' : 'background:transparent;color:#64748b'">
                                Full Body
                            </button>
                            <button @click="activeStyle = 'shoulder'"
                                    style="padding:7px 16px;font-size:0.8rem;font-weight:600;border:none;cursor:pointer;transition:all .2s"
                                    :style="activeStyle === 'shoulder' ? 'background:#10b981;color:#fff' : 'background:transparent;color:#64748b'">
                                Shoulder
                            </button>
                        </div>
                    </div>
                </div>

                @php $svc = app(\App\Services\ChadarSizeService::class); @endphp

                {{-- Full Body Table --}}
                <div x-show="activeStyle === 'full'" x-transition>
                    <div style="overflow-x:auto">
                        <table class="ref-table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Height Range</th>
                                    <th>In Feet</th>
                                    <th>Fabric</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fullRules as $rule)
                                    <tr>
                                        <td><span class="badge-gray">{{ $rule->size_label }}</span></td>
                                        <td style="font-family:monospace;font-size:0.78rem;color:#64748b">{{ $rule->height_range }}</td>
                                        <td style="color:#94a3b8;font-size:0.78rem">{{ $svc->cmToFeet($rule->height_min_cm) }} – {{ $svc->cmToFeet($rule->height_max_cm) }}</td>
                                        <td>
                                            <span style="color:#059669;font-weight:700;font-size:0.9rem">
                                                {{ $rule->fabric_meters }}m
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Shoulder Table --}}
                <div x-show="activeStyle === 'shoulder'" x-transition style="display:none">
                    <div style="overflow-x:auto">
                        <table class="ref-table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Height Range</th>
                                    <th>In Feet</th>
                                    <th>Fabric</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shoulderRules as $rule)
                                    <tr>
                                        <td><span class="badge-gray">{{ $rule->size_label }}</span></td>
                                        <td style="font-family:monospace;font-size:0.78rem;color:#64748b">{{ $rule->height_range }}</td>
                                        <td style="color:#94a3b8;font-size:0.78rem">{{ $svc->cmToFeet($rule->height_min_cm) }} – {{ $svc->cmToFeet($rule->height_max_cm) }}</td>
                                        <td>
                                            <span style="color:#059669;font-weight:700;font-size:0.9rem">
                                                {{ $rule->fabric_meters }}m
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════
            RIGHT: Sidebar (1/3 width)
            ══════════════════════════════════════════════ --}}
        <div class="space-y-5">

            {{-- Recent Calculations (Auth) --}}
            @auth
                @if($recentCalculations && $recentCalculations->count() > 0)
                    <div class="sidebar-card">
                        <div class="sidebar-card-title">
                            <svg style="width:16px;height:16px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Recent Calculations
                        </div>
                        <div style="display:flex;flex-direction:column;gap:8px">
                            @foreach($recentCalculations as $calc)
                                <a href="{{ route('calculator.chaddar.result', $calc->id) }}" class="history-item">
                                    <div>
                                        <p style="color:#1e293b;font-size:0.8rem;font-weight:600">
                                            {{ $calc->height_cm }}cm · {{ ucfirst($calc->style) }}
                                        </p>
                                        <p style="color:#94a3b8;font-size:0.72rem;margin-top:2px">
                                            {{ $calc->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div style="text-align:right">
                                        <span style="color:#059669;font-weight:700;font-size:0.95rem">
                                            {{ $calc->calculated_meters }}m
                                        </span>
                                        <p style="color:#94a3b8;font-size:0.72rem;margin-top:1px">
                                            {{ $calc->size_label }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('user.history') }}"
                           class="flex items-center justify-center gap-1.5 text-primary-500 hover:text-primary-700 text-caption font-medium transition-colors mt-3 pt-3 border-t border-border">
                            View all history
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @endif
            @endauth

            {{-- How It Works --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">
                    <svg style="width:16px;height:16px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    How It Works
                </div>
                <ol style="display:flex;flex-direction:column;gap:10px;list-style:none;padding:0;margin:0">
                    @php
                        $steps = [
                            'Enter your height in CM or Feet & Inches',
                            'Choose Full Body or Shoulder style',
                            'Click Calculate — instant accurate result',
                            'Share or purchase the exact fabric amount',
                        ];
                    @endphp
                    @foreach($steps as $i => $step)
                        <li style="display:flex;align-items:flex-start;gap:10px">
                            <div style="width:22px;height:22px;border-radius:6px;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;color:#059669;flex-shrink:0;margin-top:1px">
                                {{ $i + 1 }}
                            </div>
                            <p style="color:#64748b;font-size:0.8rem;line-height:1.5;padding-top:2px">
                                {{ $step }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Buying Tips --}}
            <div class="sidebar-card">
                <div class="sidebar-card-title">
                    <svg style="width:16px;height:16px;color:#10b981" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Fabric Buying Tips
                </div>
                <ul style="display:flex;flex-direction:column;gap:8px;list-style:none;padding:0;margin:0">
                    @foreach([
                        'Always prefer pure cotton fabric',
                        'Egyptian cotton is the best quality',
                        'Keep extra 0.5 meter for tailoring',
                        'Pre-washed fabric prevents shrinkage',
                        'White or off-white is traditional',
                        'Fabric should be seamless for Ihram',
                    ] as $tip)
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:0.8rem;color:#64748b">
                            <svg style="width:14px;height:14px;color:#10b981;flex-shrink:0;margin-top:2px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $tip }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Other Tools --}}
            <div class="sidebar-card">
                <p style="font-size:0.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px">
                    Other Tools
                </p>
                <nav aria-label="Other tools" style="display:flex;flex-direction:column;gap:2px">
                    @php
                        $tools = [
                            ['label' => 'Meeqat Finder', 'route' => 'meeqat.finder', 'color' => '#059669', 'bg' => '#f0fdf4',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>'],
                            ['label' => 'Duas & Niyat', 'route' => 'duas.index', 'color' => '#059669', 'bg' => '#f0fdf4',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                            ['label' => 'Ihram Guide', 'route' => 'ihram.index', 'color' => '#059669', 'bg' => '#f0fdf4',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                            ['label' => 'Virtual Try-On', 'route' => 'tryon.index', 'color' => '#059669', 'bg' => '#f0fdf4',
                             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
                        ];
                    @endphp

                    @foreach($tools as $tool)
                        <a href="{{ route($tool['route']) }}" class="tool-link">
                            <div style="width:32px;height:32px;border-radius:8px;background:{{ $tool['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <svg style="width:16px;height:16px;color:{{ $tool['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    {!! $tool['icon'] !!}
                                </svg>
                            </div>
                            <span class="tool-link-label">{{ $tool['label'] }}</span>
                            <svg style="width:13px;height:13px;color:#cbd5e1;margin-left:auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Quick Info Card --}}
            <div style="background:linear-gradient(135deg,#f0fdf4,#ecfdf5);border:1px solid #bbf7d0;border-radius:16px;padding:20px">
                <div style="display:flex;align-items:flex-start;gap:12px">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#dcfce7;border:1px solid #bbf7d0">
                        <svg class="w-5 h-5" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-6a2 2 0 012-2h2a2 2 0 012 2v6m-8 0H4a1 1 0 01-1-1V7.2a1 1 0 01.5-.87l7-3.9a1 1 0 011 0l7 3.9a1 1 0 01.5.87V20a1 1 0 01-1 1h-6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 17v-3"/></svg>
                    </div>
                    <div>
                        <h4 style="color:#065f46;font-weight:700;font-size:0.85rem;margin-bottom:6px">
                            Ihram Chaddar Note
                        </h4>
                        <p style="color:#047857;font-size:0.78rem;line-height:1.6">
                            For Hajj & Umrah, you need <strong>2 pieces</strong> of white unsewn cloth —
                            one to wrap around the waist (Izar) and one to drape over the shoulder (Rida).
                        </p>
                        <a href="{{ route('ihram.index') }}"
                           class="inline-flex items-center gap-1 text-caption font-semibold text-primary-500 hover:text-primary-700 transition-colors mt-2.5">
                            Learn about Ihram rules
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection