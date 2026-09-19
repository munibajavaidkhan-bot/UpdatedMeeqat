@extends('layouts.app')
@section('title', 'Hajj & Umrah Checklist')
@section('meta_description', 'Interactive checklist for Hajj and Umrah pilgrims with all essential items and preparations.')

@section('content')
<div x-data="checklist()">
<div class="bg-mesh" style="position:relative;padding-top:128px;padding-bottom:80px">
    <div class="absolute top-20 left-1/4 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>

    <div class="container-app relative">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-primary-500 font-medium">Checklist</span>
        </nav>

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-glow-green">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="font-heading font-black text-white leading-tight" style="font-size:clamp(1.75rem,3.5vw,2.5rem)">Hajj & Umrah <span class="text-primary-400">Checklist</span></h1>
            </div>
            <p class="text-dark-300 max-w-xl mx-auto text-sm">
                Track your preparations step by step. Your progress is saved automatically in your browser.
            </p>
            {{-- Progress --}}
            <div class="max-w-md mx-auto mt-6">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-muted font-medium">Progress</span>
                    <span class="text-primary-600 font-bold" x-text="progress + '%'"></span>
                </div>
                <div class="h-2 bg-dark-200 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-primary-500 to-primary-400 transition-all duration-700 ease-out"
                         :style="'width: ' + progress + '%'"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background:#f8fafc;padding:40px 0 80px">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Checklist Sections --}}
        @php
        $sectionIcons = [
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25-2.25M12 13.875V3M8.25 7.5a6.75 6.75 0 007.5 0"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM3 8.25h18M3 15.75h18M3 12h18m-15 3.75h12M3 8.25h18"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            '<svg class="w-5 h-5 text-primary-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        ];
        $sections = [
            [
                'title' => 'Documents & Paperwork',
                'items' => [
                    'Valid Passport (min 6 months validity)',
                    'Visa (Hajj/Umrah)',
                    'Vaccination Certificate (Meningitis, COVID-19)',
                    'Flight Tickets & Itinerary',
                    'Hotel Booking Confirmation',
                    'Emergency Contact Numbers',
                    'Travel Insurance Documents',
                    'Passport-size Photos (6+)',
                    'Copy of Passport & Visa (keep separate)',
                ]
            ],
            [
                'title' => 'Ihram & Clothing',
                'items' => [
                    'Ihram Cloth (2 pieces for men)',
                    'Safety Pins for Ihram',
                    'Sandals (Hawai Chappal - open ankle)',
                    'Comfortable Abaya / Hijab (for women)',
                    'Extra Ihram Cloth (backup)',
                    'Flip-flops for bathroom',
                    'Modest Clothing for after Ihram',
                    'Light Jacket / Shawl (for cold A/C)',
                    'Underwear & Socks (for after Tahallul)',
                ]
            ],
            [
                'title' => 'Luggage & Bags',
                'items' => [
                    'Main Suitcase (lock & tag)',
                    'Small Backpack / Shoulder Bag',
                    'Waist Pouch for Money & Passport',
                    'Reusable Water Bottle (Zamzam)',
                    'Umbrella for Sun Protection',
                    'Plastic Bags (for dirty laundry)',
                    'Pillow & Small Blanket (for bus/airport)',
                ]
            ],
            [
                'title' => 'Health & Medication',
                'items' => [
                    'First Aid Kit',
                    'Pain Relievers (Panadol, Ibuprofen)',
                    'Antihistamines (for allergies)',
                    'Motion Sickness Tablets',
                    'Antacids / Digestive Enzymes',
                    'Oral Rehydration Salts (ORS)',
                    'Vitamins (Vitamin C, Multivitamin)',
                    'Prescribed Medications (with prescription)',
                    'Face Masks (N95/KN95)',
                    'Hand Sanitizer',
                    'Tissues & Wet Wipes',
                ]
            ],
            [
                'title' => 'Toiletries',
                'items' => [
                    'Unscented Soap (Ihram-compatible)',
                    'Unscented Shampoo',
                    'Unscented Deodorant (no fragrance)',
                    'Toothbrush & Toothpaste',
                    'Miswak (Sunnah, good alternative)',
                    'Nail Clippers (for after Ihram)',
                    'Towel (small, quick-dry)',
                    'Comb / Brush',
                    'Lip Balm (unscented)',
                    'Sunscreen (unscented, high SPF)',
                ]
            ],
            [
                'title' => 'Electronics & Gadgets',
                'items' => [
                    'Smartphone (with Quran & Dua apps)',
                    'Power Bank (20000mAh+)',
                    'USB Cables & Chargers',
                    'Universal Travel Adapter',
                    'Earphones / Headphones',
                    'Flashlight / Headlamp',
                    'Camera (optional)',
                    'Smartwatch (for step tracking)',
                ]
            ],
            [
                'title' => 'Money & Essentials',
                'items' => [
                    'Saudi Riyals (cash in small denominations)',
                    'Credit/Debit Card (international)',
                    'Money Belt / Hidden Pouch',
                    'Quran (book or digital)',
                    'Dua Book / Supplication Guide',
                    'Pen & Small Notebook',
                    'Hajj/Umrah Guide Book',
                    'Zamzam Bottle (empty, for return)',
                    'Souvenirs Budget',
                    'Sadaqah / Charity Money',
                ]
            ],
            [
                'title' => 'Spiritual Preparation',
                'items' => [
                    'Learn Steps of Hajj/Umrah',
                    'Memorize Important Duas',
                    'Learn Talbiyah (Labbayk Allahumma)',
                    'Studied Ihram Rules & Prohibitions',
                    'Made Intentions (Niyat) Sincere',
                    'Settled All Debts (if any)',
                    'Asked Forgiveness from Family',
                    'Made Will (Islamic)',
                    'Read Hajj/Umrah Guide Book',
                    'Practice Patience & Good Manners',
                ]
            ],
        ];
        @endphp

        <div class="space-y-6">
            @foreach($sections as $sIndex => $section)
                <div class="card overflow-hidden animate-slide-up" style="animation-delay: {{ $sIndex * 0.08 }}s">
                    <div class="card-header py-4 flex items-center justify-between cursor-pointer"
                         @click="toggleSection({{ $sIndex }})">
                        <h3 class="text-heading font-bold flex items-center gap-2.5">
                            {!! $sectionIcons[$sIndex] !!}
                            {{ $section['title'] }}
                        </h3>
                        <svg class="w-5 h-5 text-muted transition-transform duration-200"
                             :class="openSections.includes({{ $sIndex }}) ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div x-show="openSections.includes({{ $sIndex }})" x-collapse>
                        <div class="card-body pt-0 pb-4">
                            <div class="space-y-2">
                                @foreach($section['items'] as $iIndex => $item)
                                    <label class="flex items-start gap-3 p-2.5 rounded-xl cursor-pointer transition-all duration-200 hover:bg-primary-50 group"
                                           :class="checked[{{ $sIndex }}][{{ $iIndex }}] ? 'bg-primary-50/50' : ''">
                                        <input type="checkbox"
                                               x-model="checked[{{ $sIndex }}][{{ $iIndex }}]"
                                               @change="updateProgress()"
                                               class="w-5 h-5 mt-0.5 rounded border-dark-300 text-primary-600 focus:ring-primary-500/30 cursor-pointer flex-shrink-0">
                                        <span class="text-sm text-heading select-none"
                                              :class="checked[{{ $sIndex }}][{{ $iIndex }}] ? 'line-through text-muted' : ''">
                                            {{ $item }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Reset Button --}}
        <div class="text-center mt-10">
            <button @click="resetAll()" class="btn-ghost text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>
                </svg>
                Reset All Progress
            </button>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('checklist', () => ({
        openSections: JSON.parse(localStorage.getItem('checklistOpen') || '[]'),
        checked: JSON.parse(localStorage.getItem('checklistChecked') || (() => {
            const arr = [];
            @foreach($sections as $section)
                arr.push(Array({{ count($section['items']) }}).fill(false));
            @endforeach
            return JSON.stringify(arr);
        })()),
        get progress() {
            let total = 0, done = 0;
            this.checked.forEach(s => { s.forEach(c => { total++; if(c) done++; }); });
            return total === 0 ? 0 : Math.round((done / total) * 100);
        },
        toggleSection(idx) {
            const i = this.openSections.indexOf(idx);
            if (i > -1) this.openSections.splice(i, 1);
            else this.openSections.push(idx);
            this.saveOpen();
        },
        updateProgress() {
            localStorage.setItem('checklistChecked', JSON.stringify(this.checked));
        },
        saveOpen() {
            localStorage.setItem('checklistOpen', JSON.stringify(this.openSections));
        },
        resetAll() {
            if (!confirm('Reset all checklist progress?')) return;
            this.checked.forEach(s => s.fill(false));
            this.openSections = [];
            localStorage.setItem('checklistChecked', JSON.stringify(this.checked));
            localStorage.setItem('checklistOpen', '[]');
        }
    }));
});
</script>

</div>
</div>
@endsection
