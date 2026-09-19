@extends('layouts.app')
@section('title', 'Prayer Times Calculator')
@section('meta_description', 'Calculate prayer times for any city using the Islamic Society of North America (ISNA) method.')

@section('content')
<div class="bg-mesh" style="position:relative;padding-top:128px;padding-bottom:64px">
    <div class="absolute top-20 left-1/4 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl animate-pulse-slow" aria-hidden="true"></div>
    <div class="container-app relative">
        <nav class="flex items-center gap-2 text-sm mb-8 animate-fade-in" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-dark-400 hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-3 h-3 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-primary-500 font-medium">Prayer Times</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 animate-slide-up">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center flex-shrink-0 shadow-glow-green">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h1 class="font-heading font-black text-white leading-tight" style="letter-spacing:-0.025em;font-size:clamp(1.75rem,3.5vw,2.5rem)">Prayer <span class="text-primary-400">Times</span></h1>
                    <p class="text-dark-300 mt-1 text-body">Accurate prayer times by location or country & city</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary-500/15 border border-primary-500/30 flex-shrink-0 self-start">
                <svg style="width:14px;height:14px;color:#34d399" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-primary-400 font-bold text-body-sm">ISNA Method</span>
            </div>
        </div>
    </div>
</div>
<div style="background:#f8fafc;padding:40px 0 80px" x-data="prayerTimes()" x-init="initPrayerTimes()">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex gap-2 mb-8">
        <button @click="mode = 'location'" :class="mode === 'location' ? 'bg-primary-500 text-white shadow-btn' : 'bg-white text-dark-500 border border-dark-200 hover:bg-dark-50'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            By Location
        </button>
        <button @click="mode = 'country'" :class="mode === 'country' ? 'bg-primary-500 text-white shadow-btn' : 'bg-white text-dark-500 border border-dark-200 hover:bg-dark-50'" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
            By Country & City
        </button>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-5">
            <div x-show="mode === 'location'" x-transition class="bg-white rounded-2xl p-5 border border-dark-200 shadow-card">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                        <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    </div>
                    <span class="text-heading font-bold text-sm">Auto Detect</span>
                </div>
                <p class="text-muted text-xs mb-4">We will use your GPS to find prayer times automatically.</p>
                <template x-if="locLoading">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-dark-50">
                        <div class="w-5 h-5 border-2 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
                        <span class="text-xs text-muted">Detecting location...</span>
                    </div>
                </template>
                <template x-if="!locLoading && locationName !== 'Detecting...'">
                    <div class="p-3 rounded-xl bg-primary-50 border border-primary-200">
                        <p class="text-xs font-semibold text-primary-700" x-text="locationName"></p>
                        <p class="text-xs text-primary-500 mt-0.5" x-text="latitude?.toFixed(4) + ', ' + longitude?.toFixed(4)"></p>
                    </div>
                </template>
                <template x-if="!locLoading && locationName === 'Detecting...'">
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200">
                        <p class="text-xs text-amber-700">Please enable location access.</p>
                    </div>
                </template>
                <button @click="detectLocation()" class="w-full mt-3 btn btn-secondary text-xs">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                    Refresh Location
                </button>
            </div>
            <div x-show="mode === 'country'" x-transition class="bg-white rounded-2xl p-5 border border-dark-200 shadow-card">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                        <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
                    </div>
                    <span class="text-heading font-bold text-sm">Select Location</span>
                </div>
                <label class="form-label">Country</label>
                <select x-model="selectedCountry" @change="selectedCity = ''; updateCities()" class="form-select mb-3">
                    <option value="">Select country...</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="UAE">UAE</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Egypt">Egypt</option>
                    <option value="India">India</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Oman">Oman</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Kenya">Kenya</option>
                    <option value="USA">USA</option>
                    <option value="UK">UK</option>
                    <option value="Germany">Germany</option>
                    <option value="France">France</option>
                    <option value="Canada">Canada</option>
                    <option value="Australia">Australia</option>
                </select>
                <label class="form-label">City</label>
                <select x-model="selectedCity" @change="applyCountryCity()" class="form-select">
                    <option value="">Select city...</option>
                    <template x-for="city in cities" :key="city.name">
                        <option :value="city.name" x-text="city.name"></option>
                    </template>
                </select>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-dark-200 shadow-card">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 border border-primary-200 flex items-center justify-center">
                        <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                    </div>
                    <span class="text-heading font-bold text-sm">Info</span>
                </div>
                <div class="space-y-2 text-xs text-muted">
                    <div class="flex justify-between"><span>Method</span><span class="font-semibold text-heading">ISNA</span></div>
                    <div class="flex justify-between"><span>Juristic</span><span class="font-semibold text-heading">Hanafi</span></div>
                    <div class="flex justify-between"><span>Fajr Angle</span><span class="font-semibold text-heading">15&deg;</span></div>
                    <div class="flex justify-between"><span>Isha Angle</span><span class="font-semibold text-heading">15&deg;</span></div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl p-5 border border-dark-200 shadow-card">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <p class="text-muted text-xs" x-text="today"></p>
                        <h2 class="text-heading font-black text-lg mt-0.5" x-text="locationName"></h2>
                    </div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary-50 border border-primary-200">
                        <svg style="width:14px;height:14px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span class="text-xs font-semibold text-primary-700" x-text="hijriDate"></span>
                    </div>
                </div>
            </div>
            <div style="border-radius:16px;padding:24px;background:linear-gradient(135deg,#047857,#059669);color:#fff;position:relative;overflow:hidden">
                <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:rgba(255,255,255,0.08);border-radius:50%"></div>
                <div class="relative">
                    <div class="flex items-center gap-2 mb-2">
                        <svg style="width:18px;height:18px;color:rgba(255,255,255,0.9)" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;font-weight:700;color:rgba(255,255,255,0.85)">Next Prayer</span>
                    </div>
                    <div class="flex items-end justify-between flex-wrap gap-4">
                        <div>
                            <p style="font-size:2.2rem;font-weight:900;color:#fff;line-height:1.1" x-text="nextPrayerName"></p>
                            <p style="font-size:1rem;font-weight:700;color:#fff;margin-top:6px" x-text="nextPrayerTime"></p>
                        </div>
                        <div class="text-right">
                            <p style="font-size:1.8rem;font-weight:900;color:#fff;line-height:1.1" x-text="countdown"></p>
                            <p style="font-size:0.78rem;color:rgba(255,255,255,0.9);margin-top:4px;font-weight:500">remaining</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <template x-for="(prayer, name) in times" :key="name">
                    <div class="bg-white rounded-2xl p-4 border transition-all duration-200 cursor-default" :class="nextPrayer === name ? 'border-primary-400 shadow-glow-green ring-2 ring-primary-100' : 'border-dark-200 hover:border-primary-200'">
                        <div class="flex items-center gap-2.5 mb-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200" :class="nextPrayer === name ? 'bg-primary-500 text-white' : 'bg-dark-100 text-dark-500'">
                                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <template x-if="name==='Fajr'"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></template>
                                    <template x-if="name==='Sunrise'"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></template>
                                    <template x-if="name==='Dhuhr'"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></template>
                                    <template x-if="name==='Asr'"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></template>
                                    <template x-if="name==='Maghrib'"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></template>
                                    <template x-if="name==='Isha'"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></template>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold" :class="nextPrayer === name ? 'text-primary-600' : 'text-muted'" x-text="getLabel(name)"></span>
                        </div>
                        <p class="text-xl font-black text-heading" x-text="prayer"></p>
                    </div>
                </template>
            </div>
            <div class="bg-white rounded-2xl border border-dark-200 shadow-card overflow-hidden">
                <div class="px-5 py-4 border-b border-dark-100 flex items-center gap-2.5">
                    <svg style="width:18px;height:18px;color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    <span class="text-heading font-bold text-sm">This Week</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead><tr class="bg-dark-50"><th class="px-4 py-2.5 text-left font-semibold text-muted">Day</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Fajr</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Sunrise</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Dhuhr</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Asr</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Maghrib</th><th class="px-3 py-2.5 text-center font-semibold text-muted">Isha</th></tr></thead>
                        <tbody>
                            <template x-for="(day, idx) in weekSchedule" :key="idx">
                                <tr class="border-t border-dark-100" :class="day.isToday ? 'bg-primary-50' : ''">
                                    <td class="px-4 py-2.5 font-semibold" :class="day.isToday ? 'text-primary-600' : 'text-heading'" x-text="day.name"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Fajr"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Sunrise"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Dhuhr"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Asr"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Maghrib"></td>
                                    <td class="px-3 py-2.5 text-center text-muted" x-text="day.Isha"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('prayerTimes', () => ({
        mode: 'location',
        times: {},
        locationName: 'Detecting...',
        today: new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }),
        hijriDate: '',
        latitude: null,
        longitude: null,
        timezoneOffset: 0,
        locationTimeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        requestId: 0,
        nextPrayer: null,
        locLoading: true,
        selectedCountry: '',
        selectedCity: '',
        cities: [],
        weekSchedule: [],
        // Each city carries its standard-time UTC offset (tz, in hours) so prayer
        // times are converted from the solar/UTC calculation to the correct LOCAL
        // clock time for that specific country/city (this was previously missing,
        // which made every location's times off by several hours).
        // Note: offsets are STANDARD time (no daylight-saving adjustment).
        allCities: {
            'Pakistan': [{name:'Karachi',lat:24.8607,lng:67.0011,tz:5},{name:'Lahore',lat:31.5204,lng:74.3587,tz:5},{name:'Islamabad',lat:33.6844,lng:73.0479,tz:5},{name:'Faisalabad',lat:31.4504,lng:73.1350,tz:5},{name:'Rawalpindi',lat:33.5651,lng:73.0169,tz:5},{name:'Peshawar',lat:34.0151,lng:71.5249,tz:5},{name:'Quetta',lat:30.1798,lng:66.9750,tz:5},{name:'Multan',lat:30.1575,lng:71.5249,tz:5},{name:'Sialkot',lat:32.4945,lng:74.5536,tz:5},{name:'Hyderabad',lat:25.3960,lng:68.3578,tz:5},{name:'Mardan',lat:34.1946,lng:72.0356,tz:5},{name:'Gilgit',lat:35.9208,lng:74.3085,tz:5},{name:'Skardu',lat:35.3269,lng:75.5306,tz:5},{name:'Muzaffarabad',lat:34.3700,lng:73.4710,tz:5},{name:'Gwadar',lat:25.1221,lng:62.3279,tz:5}],
            'Saudi Arabia': [{name:'Makkah',lat:21.4225,lng:39.8262,tz:3},{name:'Madinah',lat:24.4539,lng:39.6142,tz:3},{name:'Riyadh',lat:24.7136,lng:46.6753,tz:3},{name:'Jeddah',lat:21.5433,lng:39.1728,tz:3},{name:'Dammam',lat:26.3927,lng:49.9777,tz:3},{name:'Taif',lat:21.2703,lng:40.4159,tz:3},{name:'Abha',lat:18.2164,lng:42.5053,tz:3},{name:'Tabuk',lat:28.3838,lng:36.5550,tz:3},{name:'Buraidah',lat:26.3260,lng:43.9750,tz:3},{name:'Hail',lat:27.5114,lng:41.6907,tz:3}],
            'UAE': [{name:'Dubai',lat:25.2048,lng:55.2708,tz:4},{name:'Abu Dhabi',lat:24.4539,lng:54.3773,tz:4},{name:'Sharjah',lat:25.3573,lng:55.3908,tz:4},{name:'Ajman',lat:25.4052,lng:55.5136,tz:4},{name:'Ras Al Khaimah',lat:25.7895,lng:55.9432,tz:4},{name:'Fujairah',lat:25.1288,lng:56.3264,tz:4},{name:'Al Ain',lat:24.1932,lng:55.8023,tz:4}],
            'Turkey': [{name:'Istanbul',lat:41.0082,lng:28.9784,tz:3},{name:'Ankara',lat:39.9334,lng:32.8597,tz:3},{name:'Izmir',lat:38.4192,lng:27.1287,tz:3},{name:'Bursa',lat:40.1885,lng:29.0610,tz:3},{name:'Antalya',lat:36.8969,lng:30.7133,tz:3},{name:'Konya',lat:37.8746,lng:32.4932,tz:3}],
            'Egypt': [{name:'Cairo',lat:30.0444,lng:31.2357,tz:2},{name:'Alexandria',lat:31.2001,lng:29.9187,tz:2},{name:'Giza',lat:30.0131,lng:31.2089,tz:2},{name:'Luxor',lat:25.6872,lng:32.6396,tz:2},{name:'Aswan',lat:24.0889,lng:32.8998,tz:2},{name:'Sharm El Sheikh',lat:27.9158,lng:34.3300,tz:2}],
            'India': [{name:'Delhi',lat:28.7041,lng:77.1025,tz:5.5},{name:'Mumbai',lat:19.0760,lng:72.8777,tz:5.5},{name:'Hyderabad',lat:17.3850,lng:78.4867,tz:5.5},{name:'Chennai',lat:13.0827,lng:80.2707,tz:5.5},{name:'Kolkata',lat:22.5726,lng:88.3639,tz:5.5},{name:'Bangalore',lat:12.9716,lng:77.5946,tz:5.5},{name:'Ahmedabad',lat:23.0225,lng:72.5714,tz:5.5},{name:'Srinagar',lat:34.0837,lng:74.7973,tz:5.5}],
            'Bangladesh': [{name:'Dhaka',lat:23.8103,lng:90.4125,tz:6},{name:'Chittagong',lat:22.3569,lng:91.7832,tz:6},{name:'Sylhet',lat:24.8949,lng:91.8687,tz:6},{name:'Rajshahi',lat:24.3636,lng:88.6241,tz:6}],
            'Indonesia': [{name:'Jakarta',lat:-6.2088,lng:106.8456,tz:7},{name:'Surabaya',lat:-7.2575,lng:112.7521,tz:7},{name:'Bandung',lat:-6.9175,lng:107.6191,tz:7},{name:'Medan',lat:3.5952,lng:98.6722,tz:7},{name:'Yogyakarta',lat:-7.7956,lng:110.3695,tz:7},{name:'Banda Aceh',lat:5.5483,lng:95.3238,tz:7}],
            'Malaysia': [{name:'Kuala Lumpur',lat:3.1390,lng:101.6869,tz:8},{name:'George Town',lat:5.4164,lng:100.3327,tz:8},{name:'Johor Bahru',lat:1.4927,lng:103.7414,tz:8},{name:'Kota Kinabalu',lat:5.9804,lng:116.0735,tz:8},{name:'Kuching',lat:1.5535,lng:110.3593,tz:8}],
            'Morocco': [{name:'Casablanca',lat:33.5731,lng:-7.5898,tz:1},{name:'Rabat',lat:34.0209,lng:-6.8416,tz:1},{name:'Marrakech',lat:31.6295,lng:-7.9811,tz:1},{name:'Fez',lat:34.0181,lng:-5.0078,tz:1},{name:'Tangier',lat:35.7595,lng:-5.8340,tz:1}],
            'Jordan': [{name:'Amman',lat:31.9454,lng:35.9284,tz:3},{name:'Irbid',lat:32.5556,lng:35.8500,tz:3},{name:'Aqaba',lat:29.5321,lng:35.0079,tz:3}],
            'Iraq': [{name:'Baghdad',lat:33.3152,lng:44.3661,tz:3},{name:'Basra',lat:30.5085,lng:47.7804,tz:3},{name:'Erbil',lat:36.1912,lng:44.0119,tz:3},{name:'Najaf',lat:32.0003,lng:44.3356,tz:3},{name:'Karbala',lat:32.6160,lng:44.0249,tz:3}],
            'Kuwait': [{name:'Kuwait City',lat:29.3759,lng:47.9774,tz:3},{name:'Hawalli',lat:29.3382,lng:48.0283,tz:3},{name:'Salmiya',lat:29.3340,lng:48.0757,tz:3}],
            'Qatar': [{name:'Doha',lat:25.2854,lng:51.5310,tz:3},{name:'Al Wakrah',lat:25.1720,lng:51.6003,tz:3},{name:'Al Khor',lat:25.6839,lng:51.4964,tz:3}],
            'Bahrain': [{name:'Manama',lat:26.2285,lng:50.5860,tz:3},{name:'Riffa',lat:26.1296,lng:50.5553,tz:3},{name:'Muharraq',lat:26.2576,lng:50.6116,tz:3}],
            'Oman': [{name:'Muscat',lat:23.5880,lng:58.3829,tz:4},{name:'Salalah',lat:17.0151,lng:54.0924,tz:4},{name:'Sohar',lat:24.3645,lng:56.7465,tz:4}],
            'Nigeria': [{name:'Lagos',lat:6.5244,lng:3.3792,tz:1},{name:'Abuja',lat:9.0579,lng:7.4951,tz:1},{name:'Kano',lat:12.0022,lng:8.5920,tz:1},{name:'Ibadan',lat:7.3775,lng:3.9470,tz:1}],
            'South Africa': [{name:'Johannesburg',lat:-26.2041,lng:28.0473,tz:2},{name:'Cape Town',lat:-33.9249,lng:18.4241,tz:2},{name:'Durban',lat:-29.8587,lng:31.0218,tz:2}],
            'Kenya': [{name:'Nairobi',lat:-1.2921,lng:36.8219,tz:3},{name:'Mombasa',lat:-4.0435,lng:39.6682,tz:3},{name:'Kisumu',lat:-0.1022,lng:34.7617,tz:3}],
            'USA': [{name:'New York',lat:40.7128,lng:-74.0060,tz:-5},{name:'Los Angeles',lat:34.0522,lng:-118.2437,tz:-8},{name:'Chicago',lat:41.8781,lng:-87.6298,tz:-6},{name:'Houston',lat:29.7604,lng:-95.3698,tz:-6},{name:'Dearborn',lat:42.3223,lng:-83.1792,tz:-5},{name:'Bay Area',lat:37.7749,lng:-122.4194,tz:-8}],
            'UK': [{name:'London',lat:51.5074,lng:-0.1278,tz:0},{name:'Birmingham',lat:52.4862,lng:-1.8904,tz:0},{name:'Manchester',lat:53.4808,lng:-2.2426,tz:0},{name:'Bradford',lat:53.7960,lng:-1.7594,tz:0},{name:'Edinburgh',lat:55.9533,lng:-3.1883,tz:0}],
            'Germany': [{name:'Berlin',lat:52.5200,lng:13.4050,tz:1},{name:'Hamburg',lat:53.5511,lng:9.9937,tz:1},{name:'Munich',lat:48.1351,lng:11.5820,tz:1},{name:'Cologne',lat:50.9375,lng:6.9603,tz:1},{name:'Frankfurt',lat:50.1109,lng:8.6821,tz:1}],
            'France': [{name:'Paris',lat:48.8566,lng:2.3522,tz:1},{name:'Marseille',lat:43.2965,lng:5.3698,tz:1},{name:'Lyon',lat:45.7640,lng:4.8357,tz:1},{name:'Toulouse',lat:43.6047,lng:1.4442,tz:1},{name:'Nice',lat:43.7102,lng:7.2620,tz:1}],
            'Canada': [{name:'Toronto',lat:43.6532,lng:-79.3832,tz:-5},{name:'Montreal',lat:45.5017,lng:-73.5673,tz:-5},{name:'Vancouver',lat:49.2827,lng:-123.1207,tz:-8},{name:'Calgary',lat:51.0447,lng:-114.0719,tz:-7},{name:'Ottawa',lat:45.4215,lng:-75.6972,tz:-5}],
            'Australia': [{name:'Sydney',lat:-33.8688,lng:151.2093,tz:10},{name:'Melbourne',lat:-37.8136,lng:144.9631,tz:10},{name:'Brisbane',lat:-27.4698,lng:153.0251,tz:10},{name:'Perth',lat:-31.9505,lng:115.8605,tz:8},{name:'Canberra',lat:-35.2809,lng:149.1300,tz:10}],
        },
        async initPrayerTimes() {
            this.detectLocation();
            setInterval(() => this.updateNextPrayer(), 1000);
        },
        detectLocation() {
            this.locLoading = true;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => { this.setLocation(pos.coords.latitude, pos.coords.longitude); this.getLocationName(); },
                    () => this.setLocation(21.4225, 39.8262, 'Makkah, Saudi Arabia')
                );
            } else {
                this.setLocation(21.4225, 39.8262, 'Makkah, Saudi Arabia');
            }
        },
        getLocationName() {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.latitude}&lon=${this.longitude}&zoom=10`)
                .then(r => r.json()).then(data => { const d = data.address; this.locationName = [d.city, d.state, d.country].filter(Boolean).slice(0, 2).join(', ') || 'Unknown'; })
                .catch(() => { this.locationName = `${this.latitude.toFixed(2)}°, ${this.longitude.toFixed(2)}°`; });
        },
        updateCities() { this.cities = this.allCities[this.selectedCountry] || []; },
        applyCountryCity() {
            const city = this.cities.find(c => c.name === this.selectedCity);
            if (city) this.setLocation(city.lat, city.lng, `${city.name}, ${this.selectedCountry}`);
        },
        async setLocation(latitude, longitude, name = null) {
            this.latitude = Number(latitude);
            this.longitude = Number(longitude);
            if (name) this.locationName = name;
            this.locLoading = true;
            await this.loadPrayerTimes();
            this.locLoading = false;
        },
        async loadPrayerTimes() {
            const requestId = ++this.requestId;
            const timestamp = Math.floor(Date.now() / 1000);
            const url = `https://api.aladhan.com/v1/timings/${timestamp}?latitude=${encodeURIComponent(this.latitude)}&longitude=${encodeURIComponent(this.longitude)}&method=2&school=1`;
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Prayer time service unavailable');
                const payload = await response.json();
                if (requestId !== this.requestId || payload.code !== 200) return;
                this.locationTimeZone = payload.data.meta.timezone || this.locationTimeZone;
                this.times = this.normaliseTimings(payload.data.timings);
                this.hijriDate = `${payload.data.date.hijri.day} ${payload.data.date.hijri.month.en} ${payload.data.date.hijri.year}`;
                this.today = this.formatLocationDate();
                this.updateNextPrayer();
                this.generateWeek();
            } catch (error) {
                // Keep the tool usable if the provider is temporarily unavailable.
                this.times = this.calculateTimes(new Date());
                this.hijriDate = '';
                this.today = this.formatLocationDate();
                this.updateNextPrayer();
                this.generateWeek();
            }
        },
        normaliseTimings(timings) {
            const toDisplay = value => {
                const match = String(value).match(/(\d{1,2}):(\d{2})/);
                if (!match) return '--:--';
                const hours = Number(match[1]);
                return `${hours % 12 || 12}:${match[2]} ${hours >= 12 ? 'PM' : 'AM'}`;
            };
            return { Fajr: toDisplay(timings.Fajr), Sunrise: toDisplay(timings.Sunrise), Dhuhr: toDisplay(timings.Dhuhr), Asr: toDisplay(timings.Asr), Maghrib: toDisplay(timings.Maghrib), Isha: toDisplay(timings.Isha) };
        },
        async generateWeek() {
            const requestId = this.requestId;
            const dates = Array.from({ length: 7 }, (_, i) => new Date(Date.now() + i * 86400000));
            const schedule = await Promise.all(dates.map(async (date, index) => {
                try {
                    const response = await fetch(`https://api.aladhan.com/v1/timings/${Math.floor(date.getTime() / 1000)}?latitude=${encodeURIComponent(this.latitude)}&longitude=${encodeURIComponent(this.longitude)}&method=2&school=1`);
                    const payload = await response.json();
                    return { name: index === 0 ? 'Today' : new Intl.DateTimeFormat('en-US', { weekday: 'short', timeZone: this.locationTimeZone }).format(date), isToday: index === 0, ...this.normaliseTimings(payload.data.timings) };
                } catch (error) {
                    return { name: index === 0 ? 'Today' : new Intl.DateTimeFormat('en-US', { weekday: 'short', timeZone: this.locationTimeZone }).format(date), isToday: index === 0, ...this.calculateTimes(date) };
                }
            }));
            if (requestId === this.requestId) this.weekSchedule = schedule;
        },
        updateNextPrayer() {
            const totalMin = this.locationMinutes();
            const parseTime = (t) => { const [h, m] = t.replace(/\s?(AM|PM)/, '').split(':').map(Number); const isPM = t.includes('PM'); return (isPM ? (h % 12) + 12 : h % 12) * 60 + m; };
            const names = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
            for (const name of names) { const t = this.times[name]; if (!t) continue; if (parseTime(t) > totalMin) { this.nextPrayer = name; return; } }
            this.nextPrayer = 'Fajr';
        },
        get nextPrayerName() { return this.nextPrayer || '...'; },
        get nextPrayerTime() { return this.times[this.nextPrayer] || '...'; },
        get countdown() {
            try {
                if (!this.nextPrayer || !this.times[this.nextPrayer]) return "";
                var timeStr = this.times[this.nextPrayer];
                var cleaned = timeStr.replace(/\s?(AM|PM)/gi, "");
                var parts = cleaned.split(":");
                if (parts.length !== 2) return "calculating...";
                var h = parseInt(parts[0]);
                var m = parseInt(parts[1]);
                if (isNaN(h) || isNaN(m)) return "calculating...";
                var isPM = timeStr.toUpperCase().indexOf("PM") > -1;
                var targetH = h;
                if (isPM && h !== 12) targetH = h + 12;
                if (!isPM && h === 12) targetH = 0;
                var targetMin = targetH * 60 + m;
                var nowMin = this.locationMinutes();
                var diff = targetMin - nowMin;
                if (diff <= 0) diff = diff + 1440;
                if (diff > 1440) diff = diff - 1440;
                if (diff < 0) diff = 0;
                var hours = Math.floor(diff / 60);
                var mins = diff % 60;
                return hours + "h " + mins + "m";
            } catch(e) { return "calculating..."; }
        },
        getLabel(name) { return {'Fajr':'Fajr','Sunrise':'Sunrise','Dhuhr':'Dhuhr','Asr':'Asr','Maghrib':'Maghrib','Isha':'Isha'}[name] || name; },
        formatLocationDate() {
            return new Intl.DateTimeFormat('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: this.locationTimeZone }).format(new Date());
        },
        locationMinutes() {
            const parts = new Intl.DateTimeFormat('en-US', { hour: '2-digit', minute: '2-digit', hourCycle: 'h23', timeZone: this.locationTimeZone }).formatToParts(new Date());
            const value = type => Number(parts.find(part => part.type === type)?.value || 0);
            return value('hour') * 60 + value('minute');
        },
        calculateTimes(date) {
            // Offline fallback using the NOAA solar-position equations. The primary
            // path uses the ISNA/Hanafi timetable provider above.
            const day = Math.floor((Date.UTC(date.getFullYear(), date.getMonth(), date.getDate()) - Date.UTC(date.getFullYear(), 0, 0)) / 86400000);
            const gamma = (2 * Math.PI / 365) * (day - 1);
            const eqTime = 229.18 * (0.000075 + 0.001868 * Math.cos(gamma) - 0.032077 * Math.sin(gamma) - 0.014615 * Math.cos(2 * gamma) - 0.040849 * Math.sin(2 * gamma));
            const declination = 0.006918 - 0.399912 * Math.cos(gamma) + 0.070257 * Math.sin(gamma) - 0.006758 * Math.cos(2 * gamma) + 0.000907 * Math.sin(2 * gamma) - 0.002697 * Math.cos(3 * gamma) + 0.00148 * Math.sin(3 * gamma);
            const offset = this.timezoneOffset || -(new Date().getTimezoneOffset()) / 60;
            const solarNoon = 720 - 4 * this.longitude - eqTime + offset * 60;
            const hourAngle = zenith => {
                const cosine = (Math.cos(this._rad(zenith)) - Math.sin(this._rad(this.latitude)) * Math.sin(declination)) / (Math.cos(this._rad(this.latitude)) * Math.cos(declination));
                return this._deg(Math.acos(Math.max(-1, Math.min(1, cosine)))) * 4;
            };
            const asrAltitude = -this._deg(Math.atan(1 / (2 + Math.tan(Math.abs(this._rad(this.latitude) - declination)))));
            const fmt = minutes => {
                let value = Math.round(minutes) % 1440; if (value < 0) value += 1440;
                const hour = Math.floor(value / 60); const minute = value % 60;
                return `${hour % 12 || 12}:${String(minute).padStart(2, '0')} ${hour >= 12 ? 'PM' : 'AM'}`;
            };
            return { Fajr: fmt(solarNoon - hourAngle(105)), Sunrise: fmt(solarNoon - hourAngle(90.833)), Dhuhr: fmt(solarNoon), Asr: fmt(solarNoon + hourAngle(90 - asrAltitude)), Maghrib: fmt(solarNoon + hourAngle(90.833)), Isha: fmt(solarNoon + hourAngle(105)) };
        },
        _rad(deg) { return deg * Math.PI / 180; },
        _deg(rad) { return rad * 180 / Math.PI; }
    }));
});
</script>
@endpush
