@extends('layouts.app')
@section('title', 'Qibla Direction Finder')
@section('meta_description', 'Find the exact Qibla direction from your current location using your device compass with real-time GPS positioning.')

@section('content')

{{-- ═══════════════════════════════════════
     PAGE WRAPPER - light background
═══════════════════════════════════════ --}}
<div style="background:#f8fafc;min-height:100vh">

<div class="bg-mesh" style="position:relative;padding-top:128px;padding-bottom:64px">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 relative">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8 animate-fade-in">
            <a href="{{ route('home') }}" style="color: #94a3b8;" class="hover:text-slate-600 transition-colors">Home</a>
            <svg class="w-4 h-4" style="color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span style="color: #059669; font-weight: 600;">Qibla Direction</span>
        </nav>

        {{-- ── Centered Header ── --}}
        <div class="text-center mb-3">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="flex items-center justify-center rounded-2xl flex-shrink-0"
                     class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center flex-shrink-0 shadow-glow-green">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                    </svg>
                </div>
                <h1 class="font-heading font-black text-white leading-tight" style="font-size:clamp(1.75rem,3.5vw,2.5rem);">
                    Qibla <span class="text-primary-400">Direction</span>
                </h1>
            </div>
            <p class="text-dark-300 text-body" style="margin-top:8px;">Point your device towards the Qibla using the compass below.</p>
        </div>


    </div>
</div>

<div style="padding:40px 0 80px">
<div class="max-w-6xl mx-auto px-5 sm:px-8">
        {{-- ══════════════ MAIN GRID ══════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-14">

            {{-- ══════ LEFT COLUMN ══════ --}}
            <div class="lg:col-span-4 flex flex-col gap-5">

                {{-- YOUR LOCATION --}}
                <div class="bg-white rounded-3xl p-6" style="box-shadow: 0 2px 12px rgba(0,0,0,0.04);"
                     x-data="{
                         lat:null,lng:null,city:'',country:'',loading:true,error:false,
                         getLocation(){
                             this.loading=true;this.error=false;
                             if(!navigator.geolocation){this.error=true;this.loading=false;return;}
                             navigator.geolocation.getCurrentPosition(pos=>{
                                 this.lat=pos.coords.latitude;this.lng=pos.coords.longitude;
                                 fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat='+this.lat+'&lon='+this.lng+'&addressdetails=1')
                                     .then(r=>r.json()).then(d=>{
                                         this.city=d.address?.city||d.address?.town||d.address?.village||'';
                                         this.country=d.address?.country||'';this.loading=false;
                                     }).catch(()=>this.loading=false);
                             },()=>{this.error=true;this.loading=false;},{enableHighAccuracy:true,timeout:10000});
                         }
                     }" x-init="getLocation()">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex items-center justify-center rounded-2xl flex-shrink-0"
                             style="width:44px;height:44px;background:linear-gradient(135deg,#10b981,#059669);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>
                        <span class="font-bold" style="color:#0f172a;font-size:1.15rem;">Your Location</span>
                    </div>

                    <template x-if="loading">
                        <div class="flex items-center gap-3 px-4 py-4 rounded-2xl mb-4" style="background:#f8fafc;">
                            <div class="rounded-full flex-shrink-0" style="width:20px;height:20px;border:2.5px solid #10b981;"></div>
                            <span class="text-sm" style="color:#94a3b8;">Detecting your location...</span>
                        </div>
                    </template>

                    <template x-if="!loading && !error">
                        <div class="px-4 py-4 rounded-2xl mb-4" style="background:#f0fdf4;">
                            <p class="text-sm font-semibold" style="color:#047857;" x-text="city?city+', '+country:'Location detected'"></p>
                            <p class="text-xs mt-1" style="color:#6ee7b7;" x-text="lat?.toFixed(4)+'°, '+lng?.toFixed(4)+'°'"></p>
                        </div>
                    </template>

                    <template x-if="!loading && error">
                        <div class="px-4 py-4 rounded-2xl mb-4" style="background:#f0fdf4;">
                            <p class="text-sm" style="color:#92400e;">Please enable location access</p>
                        </div>
                    </template>

                    <button @click="getLocation()"
                            class="w-full btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>
                        </svg>
                        Refresh Location
                    </button>
                </div>

                {{-- DETAILS --}}
                <div class="bg-white rounded-3xl p-6" style="box-shadow: 0 2px 12px rgba(0,0,0,0.04);" x-data="qiblaCompass()">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex items-center justify-center rounded-2xl flex-shrink-0"
                             style="width:44px;height:44px;background:linear-gradient(135deg,#10b981,#059669);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="font-bold" style="color:#0f172a;font-size:1.15rem;">Details</span>
                    </div>

                    <div>
                        <div class="flex justify-between items-center py-4" style="border-bottom:1px solid #f1f5f9;">
                            <span class="text-sm" style="color:#64748b;">Distance to Kaaba</span>
                            <span class="text-sm font-bold" style="color:#0f172a;" x-text="distance || '—'"></span>
                        </div>
                        <div class="flex justify-between items-center py-4" style="border-bottom:1px solid #f1f5f9;">
                            <span class="text-sm" style="color:#64748b;">Qibla (Degrees)</span>
                            <span class="text-sm font-bold" style="color:#059669;" x-text="qiblaAngle ? Math.round(qiblaAngle) + '°' : '—'"></span>
                        </div>
                        <div class="flex justify-between items-center py-4">
                            <span class="text-sm" style="color:#64748b;">Direction</span>
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full" style="background:#10b981;"></span>
                                <span class="text-sm font-bold" style="color:#0f172a;" x-text="qiblaDirection || 'N'"></span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- QUICK REFERENCE --}}
                <div class="bg-white rounded-3xl p-6" style="box-shadow: 0 2px 12px rgba(0,0,0,0.04);">
                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="flex items-center justify-center rounded-full flex-shrink-0"
                             style="width:22px;height:22px;border:1.5px solid #cbd5e1;">
                            <span class="text-xs font-bold" style="color:#94a3b8;">?</span>
                        </div>
                        <span class="font-bold uppercase tracking-wide" style="color:#94a3b8;font-size:0.75rem;letter-spacing:0.05em;">Quick Reference</span>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            'North America' => 'North-East (NE)',
                            'Europe'        => 'South-East (SE)',
                            'South Asia'    => 'West (W)',
                            'Australia'     => 'North-West (NW)',
                        ] as $region => $dir)
                        <div class="flex items-center gap-2.5 text-sm">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#10b981;"></span>
                            <span style="color:#64748b;">{{ $region }}: <strong style="color:#0f172a;">{{ $dir }}</strong></span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            {{-- END LEFT --}}

            {{-- ══════ RIGHT COLUMN ══════ --}}
            <div class="lg:col-span-8">

                {{-- COMPASS CARD --}}
                <div class="bg-white rounded-3xl p-8" style="box-shadow: 0 2px 12px rgba(0,0,0,0.04);"
                     x-data="qiblaCompass()" x-init="initCompass()">

                    {{-- Status pill --}}
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold"
                             :style="permission ? 'background:#f0fdf4;color:#059669;' : 'background:#f1f5f9;color:#94a3b8;'">
                            <span class="w-2 h-2 rounded-full" :class="permission?'animate-pulse':''"
                                  :style="permission?'background:#10b981;':'background:#94a3b8;'"></span>
                            <span x-text="permission?'Compass Active':'Compass Inactive'"></span>
                        </div>
                    </div>

                    {{-- ━━━━━━━ COMPASS VISUAL ━━━━━━━ --}}
                    <div class="relative flex items-center justify-center" style="height:340px;">

                        {{-- decorative flag icon top-left --}}
                        <div class="absolute" style="top:8px; left:22%;">
                            <svg width="26" height="20" viewBox="0 0 26 20" fill="none">
                                <rect x="1" y="1" width="18" height="12" rx="1" fill="#f0fdf4" stroke="#bbf7d0" stroke-width="1"/>
                                <line x1="1" y1="1" x2="1" y2="19" stroke="#94a3b8" stroke-width="1.5"/>
                            </svg>
                        </div>

                        {{-- Outer soft glow --}}
                        <div class="absolute rounded-full"
                             style="width:340px;height:340px;background:radial-gradient(circle,rgba(16,185,129,0.08) 0%,transparent 70%);"></div>

                        {{-- Main compass disk (STATIC — does not rotate) --}}
                        <div class="absolute rounded-full"
                             style="width:320px;height:320px;
                                    background:radial-gradient(circle at 50% 45%, #f0fdf4 0%, #dcfce7 45%, #bbf7d0 75%, #86efac 100%);
                                    box-shadow: 0 0 0 1px rgba(16,185,129,0.15), 0 8px 32px rgba(16,185,129,0.08);">

                            {{-- N marker with red N + green cross accent --}}
                            <div class="absolute left-1/2 -translate-x-1/2" style="top:-6px;">
                                <div class="relative flex items-center justify-center" style="width:28px;height:28px;">
                                    {{-- green cross --}}
                                    <div class="absolute" style="width:2px;height:20px;background:#10b981;left:50%;transform:translateX(-50%);"></div>
                                    <div class="absolute" style="height:2px;width:20px;background:#10b981;top:50%;transform:translateY(-50%);"></div>
                                    {{-- red N letter --}}
                                    <span class="relative font-black" style="font-size:0.7rem;color:#0f172a;top:-14px;">N</span>
                                </div>
                            </div>

                            {{-- W label --}}
                            <span class="absolute font-bold text-sm" style="left:14px;top:50%;transform:translateY(-50%);color:#78716c;">W</span>
                            {{-- E label --}}
                            <span class="absolute font-bold text-sm" style="right:14px;top:50%;transform:translateY(-50%);color:#78716c;">E</span>
                            {{-- S label --}}
                            <span class="absolute font-bold text-sm" style="left:50%;bottom:10px;transform:translateX(-50%);color:#78716c;">S</span>
                        </div>

                        {{-- ── ROTATING ARROW (rotates by qiblaAngle - heading, from North/up) ── --}}
                        <div class="absolute flex items-start justify-center transition-transform duration-300 ease-out"
                             style="width:320px;height:320px;"
                             :style="'transform:rotate('+(qiblaAngle - heading)+'deg);'">
                            <div class="absolute left-1/2" style="top:50%;transform:translate(-50%,-50%) rotate(-90deg);">
                                {{-- Arrow pointing "up" by default = towards center-top before rotation applied by parent --}}
                            </div>
                            {{-- Arrow shaft + head pointing from center outward (upward = 0deg = North) --}}
                            <div class="absolute" style="left:50%; top:50%; transform:translate(-50%,-100%);">
                                <div style="width:0;height:0;
                                            border-left:16px solid transparent;
                                            border-right:16px solid transparent;
                                            border-bottom:36px solid #10b981;
                                            filter:drop-shadow(0 4px 10px rgba(16,185,129,0.4));"></div>
                            </div>
                        </div>

                        {{-- Center green dot --}}
                        <div class="absolute z-30 rounded-full"
                             style="width:20px;height:20px;background:linear-gradient(135deg,#10b981,#059669);
                                    border:3px solid white;box-shadow:0 2px 10px rgba(5,150,105,0.4);"></div>

                    </div>
                    {{-- END COMPASS --}}

                    {{-- ── INFO BOXES ── --}}
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="p-5 rounded-2xl" style="background:#f0fdf4;">
                            <p class="text-sm mb-1" style="color:#059669;">Qibla Direction</p>
                            <p class="font-black" style="font-size:2rem;line-height:1.1;color:#059669;" x-text="qiblaDirection || 'W'"></p>
                            <p class="text-xs mt-1" style="color:#10b981;" x-text="Math.round(qiblaAngle) + '° from North'"></p>
                        </div>
                        <div class="p-5 rounded-2xl" style="background:#f0fdf4;">
                            <p class="text-sm mb-1" style="color:#6ee7b7;">Device Heading</p>
                            <p class="font-black" style="font-size:2rem;line-height:1.1;color:#059669;" x-text="Math.round(heading) + '°'"></p>
                            <p class="text-xs mt-1" style="color:#86efac;">Current orientation</p>
                        </div>
                    </div>

                    {{-- ── STATUS BANNER ── --}}
                    <div class="mt-4 px-5 py-5 rounded-2xl flex items-center gap-4" style="background:#f0fdf4;">
                        <div class="flex-shrink-0">
                            <template x-if="isAligned && heading > 0">
                                <svg class="w-6 h-6" style="color:#059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </template>
                            <template x-if="!(isAligned && heading > 0)">
                                <svg class="w-6 h-6" style="color:#059669;animation:spin 2.5s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>
                                </svg>
                            </template>
                        </div>
                        <div>
                            <template x-if="isAligned && heading > 0">
                                <div>
                                    <p class="text-sm font-bold" style="color:#059669;">Facing the Qibla!</p>
                                    <p class="text-xs" style="color:#10b981;">You're perfectly aligned.</p>
                                </div>
                            </template>
                            <template x-if="!isAligned && heading > 0">
                                <div>
                                    <p class="text-sm font-bold" style="color:#059669;">Rotate <span x-text="directionHint"></span></p>
                                    <p class="text-xs" style="color:#10b981;">Keep turning until aligned.</p>
                                </div>
                            </template>
                            <template x-if="heading === 0">
                                <div>
                                    <p class="text-sm font-bold" style="color:#059669;">Waiting for compass...</p>
                                    <p class="text-xs" style="color:#10b981;">Rotate your device to activate.</p>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
                {{-- END COMPASS CARD --}}

            </div>
            {{-- END RIGHT --}}

        </div>
    </div>
</div>
</div>


{{-- ═══════════════════════════════════════
     ALPINE JS
═══════════════════════════════════════ --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('qiblaCompass', () => ({
        heading: 0,
        qiblaAngle: 0,
        permission: false,
        distance: '',
        makkahLat: 21.4225,
        makkahLng: 39.8262,

        initCompass() {
            this.calculateQibla(0, 0);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    this.calculateQibla(pos.coords.latitude, pos.coords.longitude);
                    this.calculateDistance(pos.coords.latitude, pos.coords.longitude);
                }, () => {
                    this.qiblaAngle = 270;
                    this.distance = '—';
                }, { enableHighAccuracy: true, timeout: 10000 });
            }

            if (window.DeviceOrientationEvent) {
                const attach = () => {
                    this.permission = true;
                    window.addEventListener('deviceorientation', e => {
                        this.heading = e.webkitCompassHeading ?? e.alpha ?? 0;
                    }, true);
                };
                if (typeof DeviceOrientationEvent.requestPermission === 'function') {
                    DeviceOrientationEvent.requestPermission()
                        .then(s => { if (s === 'granted') attach(); }).catch(() => {});
                } else {
                    attach();
                }
            }
        },

        calculateQibla(lat, lng) {
            const dL = this.makkahLng - lng;
            const y = Math.sin(this.r(dL)) * Math.cos(this.r(this.makkahLat));
            const x = Math.cos(this.r(lat)) * Math.sin(this.r(this.makkahLat))
                    - Math.sin(this.r(lat)) * Math.cos(this.r(this.makkahLat)) * Math.cos(this.r(dL));
            this.qiblaAngle = (this.d(Math.atan2(y, x)) + 360) % 360;
        },

        calculateDistance(lat, lng) {
            const R = 6371;
            const dLat = this.r(this.makkahLat - lat);
            const dLng = this.r(this.makkahLng - lng);
            const a = Math.sin(dLat/2)**2 + Math.cos(this.r(lat)) * Math.cos(this.r(this.makkahLat)) * Math.sin(dLng/2)**2;
            const dist = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            this.distance = Math.round(dist).toLocaleString() + ' km';
        },

        r(deg) { return deg * Math.PI / 180; },
        d(rad) { return rad * 180 / Math.PI; },

        get qiblaDirection() {
            const dirs = ['N','NE','E','SE','S','SW','W','NW'];
            return dirs[Math.round(this.qiblaAngle / 45) % 8];
        },
        get isAligned() {
            const diff = ((this.qiblaAngle - this.heading) % 360 + 360) % 360;
            return diff <= 5 || diff >= 355;
        },
        get directionHint() {
            const diff = ((this.qiblaAngle - this.heading) % 360 + 360) % 360;
            return diff < 180 ? 'clockwise →' : '← anti-clockwise';
        }
    }));
});
</script>

@endsection