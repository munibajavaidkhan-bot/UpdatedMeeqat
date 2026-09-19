@{-- resources/views/about.blade.php --}}
@extends('layouts.app')
@section('title', 'About Us - Meeqat.io')

@section('content')

{{-- ══════════════════════════════════════════════════════════
    HERO SECTION - Modern Professional Design
    ══════════════════════════════════════════════════════════ --}}
<div class="relative pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 bg-mesh"></div>

    {{-- Animated Background Elements --}}
    <div class="absolute inset-0" aria-hidden="true">
        <div class="absolute top-1/4 -left-40 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 -right-40 w-96 h-96 bg-secondary-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                     bg-primary-500/15 border border-primary-500/30
                     text-primary-400 text-body-sm font-semibold mb-8
                     animate-fade-in backdrop-blur-sm">
            <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse" aria-hidden="true"></span>
            Our Mission & Vision
        </div>

        {{-- Heading --}}
        <h1 class="font-heading font-black text-white mb-6 leading-tight"
            style="font-size: clamp(2rem, 5vw, 3rem);">
            About <span class="text-gradient-primary">Meeqat.io</span>
        </h1>

        {{-- Description --}}
        <p class="text-body-lg text-dark-300 leading-relaxed max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.1s;">
            Meeqat.io is a smart digital platform built for Hajj and Umrah pilgrims.
            Our mission is to make every pilgrim's spiritual journey easier and more organized.
        </p>
    </div>
</div>

{{-- VALUE CARDS SECTION --}}
<div class="container-app pb-16">
    <div class="max-w-4xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center mb-12">
            <h2 class="section-title">
                Our Core Values
            </h2>
            <p class="section-subtitle mx-auto">
                The principles that guide every feature and decision we make
            </p>
        </div>

        {{-- Value Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $values = [
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>',
                        'title' => 'Our Mission',
                        'desc'  => 'Providing smart digital tools to Hajj & Umrah pilgrims worldwide',
                        'color' => 'primary',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                        'title' => 'Our Values',
                        'desc'  => 'Accuracy, simplicity, and Islamic values are our foundation',
                        'color' => 'primary',
                    ],
                    [
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>',
                        'title' => 'Our Reach',
                        'desc'  => 'Serving Muslims around the world with accessible digital tools',
                        'color' => 'primary',
                    ],
                ];
            @endphp

            @foreach($values as $index => $item)
                <div class="card-premium p-8 text-center animate-slide-up"
                     style="animation-delay: {{ $index * 0.1 }}s">
                    @php
                        $iconBg = 'rgba(5, 150, 105, 0.15)';
                        $iconBorder = 'rgba(5, 150, 105, 0.25)';
                        $iconColor = '#34d399';
                    @endphp
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg"
                         style="background: {{ $iconBg }}; border: 1px solid {{ $iconBorder }};">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" style="color: {{ $iconColor }};"
                             fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="1.5"
                             aria-hidden="true">
                            {!! $item['icon'] !!}
                        </svg>
                    </div>
                    <h3 style="color:#0f172a;font-weight:700;font-size:1.25rem;margin-bottom:12px">
                        {{ $item['title'] }}
                    </h3>
                    <p style="color:#64748b;font-size:0.875rem;line-height:1.6">
                        {{ $item['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- PRIVACY POLICY SECTION --}}
<div id="privacy-policy" class="container-app pb-16 scroll-mt-24">
    <div class="max-w-4xl mx-auto">            <div class="card-premium p-8 md:p-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                         style="background: rgba(5, 150, 105, 0.15); border: 1px solid rgba(5, 150, 105, 0.25);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color: #34d399;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                </div>
                <div>
                    <h2 style="color:#0f172a;font-weight:700;font-size:1.5rem">Privacy Policy</h2>
                    <p style="color:#94a3b8;font-size:0.875rem">Last updated: June 2026</p>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:16px;color:#475569;font-size:0.875rem;line-height:1.7">
                <p><strong style="color:#1e293b">Information We Collect:</strong> We collect your name, email, and optional phone/country when you register. We also store calculation data (Chaddar sizes, Meeqat searches) to provide you with a personalized experience.</p>
                <p><strong style="color:#1e293b">How We Use Your Data:</strong> Your data is used solely to improve your experience on Meeqat.io — saving your calculations, bookmarks, and search history. We do not sell or share your personal data with third parties.</p>
                <p><strong style="color:#1e293b">Data Security:</strong> We implement industry-standard encryption and security measures to protect your personal information. Your password is hashed and never stored in plain text.</p>
                <p><strong style="color:#1e293b">Your Rights:</strong> You can request deletion of your account and associated data at any time by contacting us. You can also access, update, or correct your personal information through your profile settings.</p>
                <p><strong style="color:#1e293b">Cookies:</strong> We use essential cookies for authentication and functionality. No tracking cookies are used without your consent.</p>
            </div>
        </div>
    </div>
</div>

{{-- TERMS OF USE SECTION --}}
<div id="terms-of-use" class="container-app pb-24 scroll-mt-24">
    <div class="max-w-4xl mx-auto">
        <div class="card-premium p-8 md:p-10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(5, 150, 105, 0.15); border: 1px solid rgba(5, 150, 105, 0.25);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" style="color: #34d399;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                </div>
                <div>
                    <h2 style="color:#0f172a;font-weight:700;font-size:1.5rem">Terms of Use</h2>
                    <p style="color:#94a3b8;font-size:0.875rem">Last updated: June 2026</p>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:16px;color:#475569;font-size:0.875rem;line-height:1.7">
                <p><strong style="color:#1e293b">Acceptance of Terms:</strong> By using Meeqat.io, you agree to these terms. If you do not agree, please do not use our services.</p>
                <p><strong style="color:#1e293b">Accuracy of Information:</strong> While we strive for accuracy, the information on Meeqat.io is provided as a reference. Pilgrims should verify important religious rulings with qualified scholars.</p>
                <p><strong style="color:#1e293b">User Accounts:</strong> You are responsible for maintaining the confidentiality of your account credentials. You must provide accurate and complete information when creating an account.</p>
                <p><strong style="color:#1e293b">Acceptable Use:</strong> You agree not to misuse the services, attempt unauthorized access, or use the platform for any unlawful purpose.</p>
                <p><strong style="color:#1e293b">Service Availability:</strong> We strive for 99.9% uptime but do not guarantee uninterrupted service. Meeqat.io is provided "as is" without warranties of any kind.</p>
                <p><strong style="color:#1e293b">Changes to Terms:</strong> We reserve the right to update these terms. Users will be notified of material changes via email or site notice.</p>
            </div>
        </div>
    </div>
</div>

@endsection