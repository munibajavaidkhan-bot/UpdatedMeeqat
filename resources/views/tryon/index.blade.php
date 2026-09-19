@extends('layouts.app')

@section('title', 'Virtual Try-On — Meeqat.io')
@section('meta_description', 'Preview Hajj & Umrah caps, turbans and accessories on yourself with AI before your journey. Meeqat.io members only.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-emerald-50/40 pb-16" x-data="tryOnWorkspace()" x-init="init()">

  {{-- ═══════════════════ HERO (matches Ihram Guide / Calculator style) ═══════════════════ --}}
  <section class="bg-mesh relative overflow-hidden" style="padding-top:128px;padding-bottom:64px">
    <div class="absolute top-1/4 -left-32 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="absolute bottom-0 right-1/3 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay:2s" aria-hidden="true"></div>

    <div class="container-app relative">
      <nav class="flex items-center gap-2 text-sm mb-8 animate-fade-in" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
        <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-primary-500 font-medium">Virtual Try-On</span>
      </nav>

      <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold bg-white/8 border border-white/12 text-primary-400 mb-4 backdrop-blur-sm animate-fade-in" style="background:rgba(255,255,255,0.08)">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        AI-Powered Virtual Try-On
      </span>

      <h1 class="font-heading font-black text-white leading-tight tracking-tight animate-fade-in" style="letter-spacing:-0.03em;font-size:clamp(2rem,4.5vw,3.2rem)">
        Virtual <span class="text-primary-400">Try-On</span>
      </h1>
      <p class="text-dark-300 mt-3 animate-fade-in" style="font-size:1rem;max-width:560px;line-height:1.65">
        Preview Hajj &amp; Umrah caps, turbans and accessories on yourself before your journey.
      </p>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary-500/40 to-transparent"></div>
  </section>


  {{-- ═══════════════════ MEMBERS-ONLY STATE (GUESTS) ═══════════════════ --}}
  @guest
  <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="bg-white/80 backdrop-blur rounded-2xl shadow-elevated border border-emerald-100 p-8 sm:p-10 text-center">
      <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg mb-5">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
      </div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-4">Members Only</span>
      <h2 class="text-2xl font-bold font-heading text-gray-900">Virtual Try-On is available for Meeqat.io members</h2>
      <p class="mt-3 text-sm sm:text-base text-gray-600 leading-relaxed max-w-lg mx-auto">
        Sign in to upload your photo and preview Hajj &amp; Umrah accessories virtually — caps, turbans and ihram styles, powered by AI.
      </p>
      <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('login') }}"
           class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-sm shadow-lg hover:shadow-emerald-500/30 hover:from-emerald-600 hover:to-teal-700 transition-all w-full sm:w-auto">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
          Login to Try On
        </a>
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center px-7 py-3 rounded-xl border-2 border-emerald-500/30 text-emerald-700 font-bold text-sm hover:bg-emerald-50 transition w-full sm:w-auto">
          Sign Up
        </a>
      </div>
      <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
        <div class="rounded-xl bg-slate-50 border border-gray-100 p-4">
          <p class="text-xs font-bold text-gray-900 mb-1">1 · Upload a photo</p>
          <p class="text-[11px] text-gray-500 leading-relaxed">A clear front-facing photo works best.</p>
        </div>
        <div class="rounded-xl bg-slate-50 border border-gray-100 p-4">
          <p class="text-xs font-bold text-gray-900 mb-1">2 · Pick an accessory</p>
          <p class="text-[11px] text-gray-500 leading-relaxed">Kufi caps, topis, turbans and more.</p>
        </div>
        <div class="rounded-xl bg-slate-50 border border-gray-100 p-4">
          <p class="text-xs font-bold text-gray-900 mb-1">3 · Get your preview</p>
          <p class="text-[11px] text-gray-500 leading-relaxed">AI creates a realistic try-on image.</p>
        </div>
      </div>
    </div>
  </section>
  @endguest


  @auth
  {{-- ═══════════════════ WORKSPACE (MEMBERS) ═══════════════════ --}}
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

      {{-- ───────── LEFT: CONFIGURATION PANEL ───────── --}}
      <div class="lg:col-span-5 space-y-6">

        {{-- STEP 1: Upload --}}
        <div class="bg-white rounded-2xl shadow-elevated border border-gray-100 p-6">
          <div class="flex items-start gap-3 mb-4">
            <span class="flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold text-sm shadow">1</span>
            <div>
              <h2 class="text-base font-bold text-gray-900 font-heading">Upload Your Photo</h2>
              <p class="text-xs text-gray-500 mt-0.5">Use a clear, front-facing photo for best results.</p>
            </div>
          </div>

          <div x-show="!photo">
            <label class="block border-2 border-dashed border-emerald-200 hover:border-emerald-400 hover:bg-emerald-50/50 rounded-xl p-8 text-center cursor-pointer transition-all bg-emerald-50/20"
                   @dragover.prevent="$el.classList.add('border-emerald-500','bg-emerald-50')"
                   @dragleave.prevent="$el.classList.remove('border-emerald-500','bg-emerald-50')"
                   @drop.prevent="handleDrop($event)">
              <input type="file" accept="image/jpeg,image/png,image/webp" class="hidden" @change="handleFile($event)">
              <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0-12l-4 4m4-4l4 4"/></svg>
              </div>
              <p class="text-sm font-semibold text-gray-800">Click to upload or drag &amp; drop</p>
              <p class="text-xs text-gray-500 mt-1">JPG, PNG or WebP · Max 5&nbsp;MB</p>
            </label>
          </div>

          <div x-show="photo" x-cloak class="flex items-center gap-4 bg-slate-50 border border-gray-100 rounded-xl p-3">
            <img :src="photo" alt="Your photo" class="w-14 h-14 rounded-lg object-cover border border-gray-200">
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-gray-900 flex items-center gap-1.5">
                Photo ready
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.7-9.3a1 1 0 00-1.4-1.4L9 10.6 7.7 9.3a1 1 0 00-1.4 1.4l2 2a1 1 0 001.4 0l4-4z" clip-rule="evenodd"/></svg>
              </p>
              <p class="text-xs text-gray-500 truncate">You can change your photo anytime.</p>
            </div>
            <button @click="clearPhoto()" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-50 transition">Change</button>
          </div>

          <p x-show="photoError" x-text="photoError" x-cloak class="mt-3 text-xs text-red-600 bg-red-50 border border-red-100 rounded-lg px-3 py-2"></p>
        </div>


        {{-- STEP 2: Category --}}
        <div class="bg-white rounded-2xl shadow-elevated border border-gray-100 p-6">
          <div class="flex items-start gap-3 mb-4">
            <span class="flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold text-sm shadow">2</span>
            <div>
              <h2 class="text-base font-bold text-gray-900 font-heading">Choose Category</h2>
              <p class="text-xs text-gray-500 mt-0.5">Select what you want to try on.</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <button @click="category = 'caps'"
                    :class="category === 'caps' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200 hover:border-emerald-300 bg-white'"
                    class="relative rounded-xl border-2 p-4 text-center transition-all">
              <span x-show="category === 'caps'" class="absolute top-2 right-2 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              </span>
              <svg class="w-8 h-8 mx-auto mb-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 14a8 8 0 0116 0v1H4v-1zm0 4h16M2 15a2 2 0 012-2m18 2a2 2 0 00-2-2"/></svg>
              <p class="text-sm font-bold text-gray-900">Ihram &amp; Caps</p>
              <p class="text-[11px] text-gray-500 mt-0.5">Caps, ihram styles, turbans</p>
            </button>
            <button @click="category = 'accessories'"
                    :class="category === 'accessories' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200 hover:border-emerald-300 bg-white'"
                    class="relative rounded-xl border-2 p-4 text-center transition-all">
              <span x-show="category === 'accessories'" x-cloak class="absolute top-2 right-2 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              </span>
              <svg class="w-8 h-8 mx-auto mb-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
              <p class="text-sm font-bold text-gray-900">Accessories</p>
              <p class="text-[11px] text-gray-500 mt-0.5">Bags, masks, essentials</p>
            </button>
          </div>
        </div>


        {{-- STEP 3: Item + Generate --}}
        <div class="bg-white rounded-2xl shadow-elevated border border-gray-100 p-6">
          <div class="flex items-start gap-3 mb-4">
            <span class="flex items-center justify-center w-8 h-8 shrink-0 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold text-sm shadow">3</span>
            <div>
              <h2 class="text-base font-bold text-gray-900 font-heading">Select Item</h2>
              <p class="text-xs text-gray-500 mt-0.5">Choose from the available options in this category.</p>
            </div>
          </div>

          <div x-show="category === 'caps'" class="grid grid-cols-3 gap-3">
            <template x-for="item in items" :key="item.id">
              <button @click="selectedItem = item"
                      :class="selectedItem?.id === item.id ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-gray-200 hover:border-emerald-300 bg-white'"
                      class="relative rounded-xl border-2 p-2 transition-all">
                <span x-show="selectedItem?.id === item.id" class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center z-10">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                <div class="h-16 flex items-center justify-center mb-1.5">
                  <img :src="item.image" :alt="item.name" class="max-h-16 object-contain" x-on:error="$el.style.display='none'">
                </div>
                <p class="text-[11px] font-semibold text-gray-800 leading-tight" x-text="item.name"></p>
              </button>
            </template>
          </div>

          <div x-show="category === 'accessories'" x-cloak class="rounded-xl bg-slate-50 border border-dashed border-gray-200 p-6 text-center">
            <p class="text-sm font-semibold text-gray-700">Accessories coming soon</p>
            <p class="text-xs text-gray-500 mt-1">New accessories will be added soon. Try the caps category for now.</p>
          </div>

          <button @click="generate()"
                  :disabled="!canGenerate || busy"
                  :class="canGenerate && !busy ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg hover:shadow-emerald-500/25' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                  class="mt-5 w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl text-white font-bold text-sm transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 7a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1V8a1 1 0 011-1z"/></svg>
            <span x-text="busy ? 'Please wait…' : 'Generate Try-On'"></span>
          </button>
          <p x-show="!canGenerate && !busy" class="mt-2 text-center text-[11px] text-gray-400">Upload a photo and select an item to continue.</p>
        </div>
      </div>


      {{-- ───────── RIGHT: PREVIEW PANEL ───────── --}}
      <div class="lg:col-span-7 space-y-6">

        {{-- Preview / generation state --}}
        <div class="bg-white rounded-2xl shadow-elevated border border-gray-100 overflow-hidden">
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900 font-heading flex items-center gap-2">
              <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
              Try-On Preview
            </h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
              Members Only
            </span>
          </div>

          <div class="p-6">
            <div class="relative rounded-xl overflow-hidden bg-slate-100 min-h-[380px] sm:min-h-[440px] flex items-center justify-center">


              {{-- Blurred photo backdrop during generation --}}
              <img x-show="busy && photo" :src="photo" alt="" aria-hidden="true"
                   class="absolute inset-0 w-full h-full object-cover blur-xl scale-110 opacity-40 select-none pointer-events-none">

              {{-- IDLE empty state --}}
              <div x-show="state === 'idle'" class="text-center px-6">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-white border border-gray-200 shadow-sm flex items-center justify-center mb-4">
                  <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A1.5 1.5 0 0021.75 19.5V4.5A1.5 1.5 0 0020.25 3H3.75A1.5 1.5 0 002.25 4.5v15A1.5 1.5 0 003.75 21z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-700">Your virtual try-on will appear here</p>
                <p class="text-xs text-gray-400 mt-1">Upload a photo, pick an item and press Generate.</p>
              </div>

              {{-- UPLOADING / PREPARING / GENERATING / FINALIZING --}}
              <div x-show="busy" x-cloak class="relative z-10 text-center px-6">
                <div class=" relative w-20 h-20 mx-auto mb-5">
                  <div class="absolute inset-0 rounded-full border-4 border-emerald-100"></div>
                  <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-emerald-500 animate-spin"></div>
                  <svg class="absolute inset-0 m-auto w-8 h-8 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 7a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1V8a1 1 0 011-1z"/></svg>
                </div>
                <p class="text-base font-bold text-gray-900" x-text="statusTitle"></p>
                <p class="text-xs text-gray-500 mt-1.5" x-text="statusHint"></p>

                <div class="w-64 sm:w-72 mx-auto mt-5">
                  <div class="h-1.5 rounded-full bg-emerald-100 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-700" :style="'width:' + progress + '%'"></div>
                  </div>
                  <div class="flex justify-between text-[10px] text-gray-400 mt-1.5">
                    <span x-text="stateLabel"></span>
                    <span>Est. 10–30 seconds</span>
                  </div>
                </div>

                <div class="mt-5 space-y-1.5 text-left inline-block">
                  <template x-for="step in steps" :key="step.label">
                    <div class="flex items-center gap-2 text-[11px]">
                      <span x-show="step.done" class="w-3.5 h-3.5 text-emerald-500 font-bold">✓</span>
                      <span x-show="step.active" class="w-3.5 h-3.5 rounded-full border-2 border-emerald-500 border-t-transparent animate-spin inline-block"></span>
                      <span x-show="!step.done && !step.active" class="w-3.5 h-3.5 rounded-full border border-gray-300 inline-block"></span>
                      <span class="text-gray-600" :class="step.active && 'font-semibold text-gray-900'" x-text="step.label"></span>
                    </div>
                  </template>
                </div>
              </div>


              {{-- ERROR --}}
              <div x-show="state === 'error'" x-cloak class="relative z-10 text-center px-6">
                <div class="w-16 h-16 mx-auto rounded-full bg-red-50 border border-red-100 flex items-center justify-center mb-4">
                  <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>
                </div>
                <p class="text-base font-bold text-gray-900">Something went wrong while creating your try-on.</p>
                <p class="text-xs text-gray-500 mt-1.5">Please try again.</p>
                <button @click="generate()" class="mt-5 inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-sm shadow hover:from-emerald-600 hover:to-teal-700 transition">
                  Try Again
                </button>
              </div>

              {{-- SUCCESS --}}
              <div x-show="state === 'success'" x-cloak class="relative z-10 w-full">
                <img :src="result" alt="Your virtual try-on result" class="w-full max-h-[480px] object-contain">
              </div>
            </div>

            {{-- Success action buttons --}}
            <div x-show="state === 'success'" x-cloak class="mt-5 flex flex-col sm:flex-row gap-3">
              <button @click="downloadResult()" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 border-emerald-500/30 text-emerald-700 font-bold text-sm hover:bg-emerald-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0 0l-4-4m4 4l4-4"/></svg>
                Download Result
              </button>
              <button @click="saveResult()" :disabled="saving" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 border-emerald-500/30 text-emerald-700 font-bold text-sm hover:bg-emerald-50 transition disabled:opacity-50">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                <span x-text="saving ? 'Saving…' : 'Save to History'"></span>
              </button>
              <button @click="reset()" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold text-sm shadow hover:from-emerald-600 hover:to-teal-700 transition">
                Try Another
              </button>
            </div>

            <p class="mt-4 text-center text-[11px] text-gray-400 flex items-center justify-center gap-1.5">
              <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.415L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
              AI generation powered by secure backend
            </p>
          </div>
        </div>


        {{-- GENERATION HISTORY (member) --}}
        <div class="bg-white rounded-2xl shadow-elevated border border-gray-100 overflow-hidden">
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900 font-heading flex items-center gap-2">
              <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              Your Generation History
            </h2>
            <button @click="loadHistory()" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">Refresh</button>
          </div>
          <div class="p-6">
            <p x-show="history.length === 0" class="text-center text-sm text-gray-500 py-6">
              No try-on results yet.<br class="sm:hidden">
              <span class="text-gray-400">Your generated previews will appear here.</span>
            </p>
            <div x-show="history.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
              <template x-for="h in history" :key="h.filename">
                <div class="group rounded-xl border border-gray-200 overflow-hidden hover:border-emerald-300 hover:shadow-md transition bg-white">
                  <div class="h-28 bg-slate-100 flex items-center justify-center overflow-hidden">
                    <img :src="h.url" :alt="'Try-on ' + h.date" class="w-full h-full object-cover">
                  </div>
                  <div class="p-3">
                    <p class="text-[11px] font-semibold text-gray-800">Try-On Result</p>
                    <p class="text-[10px] text-gray-400 mt-0.5" x-text="h.date"></p>
                    <div class="flex items-center gap-2 mt-2">
                      <button @click="downloadHistory(h)" class="flex-1 text-[10px] font-semibold text-emerald-600 border border-emerald-200 rounded-lg py-1.5 hover:bg-emerald-50 transition">Download</button>
                      <button @click="deleteHistory(h)" class="text-[10px] font-semibold text-red-500 border border-red-200 rounded-lg py-1.5 px-2.5 hover:bg-red-50 transition">Delete</button>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endauth


  {{-- ═══════════════════ TIPS SECTION ═══════════════════ --}}
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <h2 class="text-lg font-bold font-heading text-gray-900 mb-4">Tips for the best result</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-sm font-bold text-gray-900">Use a clear, front-facing photo</p>
        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Good lighting and a plain background help the AI place the cap naturally on your head.</p>
      </div>
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <p class="text-sm font-bold text-gray-900">Keep your face fully visible</p>
        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Avoid hats or heavy shadows. The clearer your head outline, the more realistic the try-on.</p>
      </div>
      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <p class="text-sm font-bold text-gray-900">Your photos stay private</p>
        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Photos are used only to create your try-on and are processed securely by our AI service.</p>
      </div>
    </div>
  </section>
</div>
@endsection


@push('scripts')
<script>
  function tryOnWorkspace() {
    return {
      // ── state ──────────────────────────────────────────────
      state: 'idle',            // idle | uploading | preparing | generating | finalizing | success | error
      photo: null,
      photoError: null,
      category: 'caps',
      selectedItem: null,
      result: null,
      busy: false,
      saving: false,
      progress: 0,
      statusTitle: '',
      statusHint: '',
      history: [],
      authBanner: false,
      _timer: null,
      _progressTimer: null,

      items: [
        { id: 1, name: 'Kufi Cap', image: '/images/caps/Kufi-removebg-preview.png' },
        { id: 2, name: 'Topi / Imam Cap', image: '/images/caps/taqiyah-removebg-preview.png' },
        { id: 3, name: 'Ahram Turban', image: '/images/caps/Amama-removebg-preview.png' },
      ],

      steps: [],

      get canGenerate() {
        return !!(this.photo && this.selectedItem);
      },
      get stateLabel() {
        return {
          idle: 'Ready', uploading: 'Uploading', preparing: 'Preparing', generating: 'Generating',
          finalizing: 'Finalizing', success: 'Done', error: 'Error',
        }[this.state] || '';
      },

      init() {
        this.loadHistory();
      },

      csrf() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      },

      setStep(index) {
        this.steps = [
          { label: 'Photo uploaded', done: index > 0, active: index === 0 },
          { label: 'Item selected', done: index > 1, active: index === 1 },
          { label: 'Creating virtual try-on', done: index > 2, active: index === 2 },
          { label: 'Finalizing result', done: index > 3, active: index === 3 },
        ];
      },

      setState(s, title, hint) {
        this.state = s;
        if (title !== undefined) this.statusTitle = title;
        if (hint !== undefined) this.statusHint = hint;
      },

      clearPhoto() {
        this.photo = null;
        this.photoError = null;
      },

      handleFile(event) {
        const file = event.target.files && event.target.files[0];
        this.readFile(file);
      },

      handleDrop(event) {
        event.preventDefault();
        const dt = event.dataTransfer;
        const file = dt && dt.files && dt.files[0];
        this.readFile(file);
      },

      readFile(file) {
        if (!file) return;
        const okTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!okTypes.includes(file.type)) {
          this.photoError = 'Please choose a JPG, PNG or WebP image.';
          return;
        }
        if (file.size > 5 * 1024 * 1024) {
          this.photoError = 'Image is too large. Maximum size is 5 MB.';
          return;
        }
        this.photoError = null;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.photo = e.target.result;
          this.setState('idle');
        };
        reader.readAsDataURL(file);
      },

      reset() {
        this.result = null;
        this.setState('idle');
      },


      // ── PUTER: session bootstrap (silent, no dev panel) ──────
      async ensurePuterSession() {
        if (this._puterReady) return true;
        if (!window.puter || !window.puter.auth) {
          // Script tag is printed below; wait briefly for it.
          for (let i = 0; i < 20 && !window.puter; i++) {
            await new Promise(r => setTimeout(r, 250));
          }
        }
        if (!window.puter) {
          this.busy = false;
          this.setState('error');
          return false;
        }
        try {
          // signIn() resolves immediately when the member is already
          // authorized, otherwise Puter shows its native consent popup.
          await window.puter.auth.signIn();
          this._puterReady = true;
          return true;
        } catch (e) {
          this.busy = false;
          this.setState('error');
          return false;
        }
      },

      // ── GENERATION FLOW ────────────────────────────────────
      async generate() {
        if (!this.canGenerate || this.busy) return;

        this.busy = true;
        this.result = null;
        this.progress = 5;
        this.setStep(2);
        this.setState('preparing', 'Preparing your photo…', 'Getting everything ready for AI generation.');

        this._progressTimer = setInterval(() => {
          if (this.progress < 90) this.progress = Math.min(90, this.progress + 1.5);
        }, 900);

        try {
          // 1) Silent Puter authorization (native popup only if required)
          const ok = await this.ensurePuterSession();
          if (!ok) throw new Error('puter');

          this.setState('generating', 'Creating your virtual try-on…', 'AI is crafting your preview. Please keep this page open.');
          this.setStep(2);
          this.progress = Math.max(this.progress, 35);

          // 2) Ask our backend to compose the instruction (never shown to the user)
          const promptRes = await fetch('{{ route("tryon.prompt") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf() },
            body: JSON.stringify({ model_image: this.photo, item_id: this.selectedItem.id, upload_mode: 'file' }),
          });
          if (promptRes.status === 401) return this.handleAuthLoss();
          const brain = await promptRes.json();
          if (!brain || !brain.prompt) throw new Error('prompt');

          this.setState('generating', 'Creating your virtual try-on…', 'This may take a few moments. Please keep this page open.');
          this.progress = Math.max(this.progress, 55);

          // 3) Generate via the AI service
          const image = await this.puterGenerate(brain.prompt);

          // 4) Finalize
          this.setState('finalizing', 'Almost ready…', 'Final touches are being applied to your preview.');
          this.setStep(3);
          this.progress = 92;
          this.result = await this.puterToDataUrl(image);
          this.progress = 100;
          this.setStep(4);
          this.busy = false;
          this.setState('success');
          clearInterval(this._progressTimer);
        } catch (err) {
          clearInterval(this._progressTimer);
          this.busy = false;
          this.setState('error');
        }
      },

      async puterGenerate(prompt) {
        const personData = await this.puterToDataUrl(this.photo, 'image/jpeg');
        const capData = await this.puterToDataUrl(this.selectedItem.image, 'image/png');

        const models = ['gemini-3.1-flash-image-preview', 'gemini-2.5-flash-image'];
        let image = null;
        let lastErr = null;
        for (const model of models) {
          try {
            image = await window.puter.ai.txt2img({
              prompt: prompt,
              model: model,
              input_images: [personData, capData],
            });
            if (image) break;
          } catch (e) {
            lastErr = e;
          }
        }
        if (!image) throw lastErr || new Error('generate');
        return image;
      },


      // ── helpers ────────────────────────────────────────────
      async puterToDataUrl(src, fallbackMime) {
        if (typeof src === 'string' && src.startsWith('data:')) return src;
        if (typeof src === 'string' && src.startsWith('blob:')) {
          const blob = await (await fetch(src)).blob();
          return await new Promise((resolve, reject) => {
            const fr = new FileReader();
            fr.onload = e => resolve(e.target.result);
            fr.onerror = reject;
            fr.readAsDataURL(blob);
          });
        }
        return new Promise((resolve, reject) => {
          const img = new Image();
          img.crossOrigin = 'anonymous';
          img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            try {
              resolve(canvas.toDataURL(fallbackMime || 'image/png'));
            } catch (e) {
              resolve(src);
            }
          };
          img.onerror = () => resolve(src);
          img.src = src;
        });
      },

      async puterImageToDataUrl(image) {
        if (typeof image === 'string') return image;
        if (image instanceof Blob) {
          return await this.puterToDataUrl(URL.createObjectURL(image));
        }
        // <img> element or similar
        const src = image && (image.src || (image.attributes && image.attributes.src && image.attributes.src.value));
        if (src) return await this.puterToDataUrl(src);
        return String(image);
      },

      handleAuthLoss() {
        window.location.href = '{{ route("login") }}';
      },

      // ── download / save / history ──────────────────────────
      downloadResult() {
        if (!this.result) return;
        this.triggerDownload(this.result, 'meeqat-virtual-tryon-' + Date.now() + '.jpg');
      },

      async saveResult() {
        if (!this.result || this.saving) return;
        this.saving = true;
        try {
          const res = await fetch('{{ route("tryon.save") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf() },
            body: JSON.stringify({ result_image: this.result }),
          });
          const data = await res.json().catch(() => ({}));
          if (res.status === 401) return this.handleAuthLoss();
          if (data.success) {
            this.loadHistory();
          } else {
            this.dispatchToast('Could not save the result. Please try again.', 'error');
          }
        } catch (e) {
          this.dispatchToast('Could not save the result. Please try again.', 'error');
        } finally {
          this.saving = false;
        }
      },


      async loadHistory() {
        try {
          const res = await fetch('{{ route("tryon.history") }}');
          if (res.status === 401) return;
          const data = await res.json();
          if (data.success) this.history = data.items || [];
        } catch (e) { /* history is non-critical */ }
      },

      downloadHistory(h) {
        this.triggerDownload(h.url, h.filename);
      },

      async deleteHistory(h) {
        try {
          const res = await fetch('{{ route("tryon.history.delete", ":filename") }}'.replace(':filename', encodeURIComponent(h.filename)), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': this.csrf() },
          });
          if (res.status === 401) return this.handleAuthLoss();
          const data = await res.json().catch(() => ({}));
          if (data.success) {
            this.history = this.history.filter(x => x.filename !== h.filename);
            this.dispatchToast('Try-on result deleted.', 'success');
          } else {
            this.dispatchToast('Could not delete this result.', 'error');
          }
        } catch (e) {
          this.dispatchToast('Could not delete this result.', 'error');
        }
      },

      triggerDownload(href, filename) {
        const link = document.createElement('a');
        link.href = href;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        link.remove();
      },

      dispatchToast(message, type) {
        window.dispatchEvent(new CustomEvent('toast', { detail: { message, type: type || 'info' } }));
      },
    };
  }
</script>
<script src="https://js.puter.com/v2/"></script>
@endpush
