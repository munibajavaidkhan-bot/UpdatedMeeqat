{{-- resources/views/layouts/partials/footer.blade.php --}}
@php
    $r = fn (string $name, string $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
@endphp

<footer style="background:#080b10;border-top:1px solid rgba(255,255,255,.05);overflow:hidden;position:relative;margin-top:80px" aria-label="Site footer">

    {{-- Background Glow --}}
    <div style="position:absolute;inset:0;opacity:0.2;pointer-events:none" aria-hidden="true">
        <div style="position:absolute;bottom:0;left:25%;width:24rem;height:24rem;background:#10b981;border-radius:50%;filter:blur(80px)"></div>
        <div style="position:absolute;top:0;right:25%;width:24rem;height:24rem;background:#d97706;border-radius:50%;filter:blur(80px);opacity:0.15"></div>
    </div>

    {{-- Main Footer --}}
    <div style="max-width:1160px;margin:0 auto;padding:64px 20px">
        <div style="display:grid;grid-template-columns:1fr;gap:40px">
            <div class="footer-grid">

                {{-- Brand Column --}}
                <div class="footer-brand">
                    <a href="{{ $r('home') }}"
                       class="flex items-center gap-3 mb-5 w-fit group"
                       aria-label="Meeqat.io — Home"
                       style="text-decoration:none">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center shadow-glow-green group-hover:shadow-glow-green-lg group-hover:scale-105 transition-all duration-200">
                            <span class="text-white font-black text-base font-heading" aria-hidden="true">M</span>
                        </div>
                        <span style="color:#fff;font-weight:700;font-size:1.25rem">
                            Meeqat<span style="color:#34d399">.io</span>
                        </span>
                    </a>

                    <p style="color:rgba(148,163,184,.7);font-size:.875rem;line-height:1.7;max-width:280px;margin-bottom:24px">
                        Smart digital tools for Hajj & Umrah pilgrims. Making your spiritual journey easier and more informed.
                    </p>

                    {{-- Arabic Dua --}}
                    <div style="background:rgba(30,41,59,.4);border:1px solid rgba(51,65,85,.3);border-radius:12px;padding:16px;display:inline-block"
                         aria-label="Quranic dua: Rabbana Taqabbal Minna">
                        <p dir="rtl" style="font-family:'Traditional Arabic','Scheherazade New',serif;color:#fbbf24;font-size:1.25rem;line-height:1.8;margin-bottom:4px">رَبَّنَا تَقَبَّلْ مِنَّا</p>
                        <p style="color:rgba(100,116,139,.6);font-size:.75rem;text-align:center;font-weight:500">Rabbana Taqabbal Minna</p>
                    </div>
                </div>

                {{-- Quick Tools --}}
                <div>
                    <h4 style="color:#fff;font-weight:600;font-size:.875rem;margin-bottom:20px;display:flex;align-items:center;gap:8px">
                        <span style="width:4px;height:16px;background:#10b981;border-radius:999px;display:inline-block" aria-hidden="true"></span>
                        Quick Tools
                    </h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px" role="list">
                        @php
                            $quickLinks = [
                                ['label' => 'Chaddar Calculator', 'route' => 'calculator.chaddar', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                                ['label' => 'Meeqat Finder',    'route' => 'meeqat.finder',   'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                                ['label' => 'Duas & Niyat',    'route' => 'duas.index',      'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                                ['label' => 'Ihram Guide',     'route' => 'ihram.index',     'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['label' => 'Virtual Try-On',  'route' => 'tryon.index',     'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                                ['label' => 'Qibla Direction', 'route' => 'qibla.index',     'icon' => 'M12 21a9 9 0 100-18 9 9 0 000 18zM12 12l4.5-2.25L12 12l-1.5 4.5L12 12z'],
                                ['label' => 'Prayer Times',    'route' => 'prayer.index',    'icon' => 'M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['label' => 'Hajj Checklist',  'route' => 'checklist.index', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ];
                        @endphp
                        @foreach($quickLinks as $link)
                            <li>
                                <a href="{{ $r($link['route']) }}"
                                   class="flex items-center gap-2.5 text-dark-400 text-body-sm hover:text-primary-400 transition-colors duration-200 group">
                                    <svg class="w-4 h-4 flex-shrink-0 text-dark-600 group-hover:text-primary-400 transition-colors duration-200"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                                         aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
                                    </svg>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Information --}}
                <div>
                    <h4 style="color:#fff;font-weight:600;font-size:.875rem;margin-bottom:20px;display:flex;align-items:center;gap:8px">
                        <span style="width:4px;height:16px;background:#fbbf24;border-radius:999px;display:inline-block" aria-hidden="true"></span>
                        Information
                    </h4>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;margin-bottom:32px" role="list">
                        @php
                            $infoLinks = [
                                ['label' => 'About Us',       'route' => 'about',   'anchor' => ''],
                                ['label' => 'Contact',        'route' => 'contact', 'anchor' => ''],
                                ['label' => 'Privacy Policy', 'route' => 'about',   'anchor' => '#privacy-policy'],
                                ['label' => 'Terms of Use',   'route' => 'about',   'anchor' => '#terms-of-use'],
                            ];
                        @endphp
                        @foreach($infoLinks as $link)
                            <li>
                                <a href="{{ $link['anchor'] ? $r($link['route']) . $link['anchor'] : $r($link['route']) }}"
                                   class="text-dark-400 text-body-sm hover:text-primary-400 transition-colors duration-200">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Social Links --}}
                    <div>
                        <h5 style="color:rgba(100,116,139,.6);font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">
                            Follow Us
                        </h5>
                        <div class="flex gap-2" role="list" aria-label="Social media links">
                            {{-- Facebook --}}
                            <a href="https://facebook.com/meeqatio" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-xl bg-dark-800 border border-dark-700/50 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:bg-primary-500/10 hover:border-primary-500/30 transition-all duration-200"
                               aria-label="Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>

                            {{-- Instagram --}}
                            <a href="https://instagram.com/meeqat.io" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-xl bg-dark-800 border border-dark-700/50 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:bg-primary-500/10 hover:border-primary-500/30 transition-all duration-200"
                               aria-label="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>

                            {{-- YouTube --}}
                            <a href="https://youtube.com/@meeqatio" target="_blank" rel="noopener noreferrer"
                               class="w-9 h-9 rounded-xl bg-dark-800 border border-dark-700/50 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:bg-primary-500/10 hover:border-primary-500/30 transition-all duration-200"
                               aria-label="YouTube">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div style="border-top:1px solid rgba(51,65,85,.3)">
        <div style="max-width:1160px;margin:0 auto;padding:20px;display:flex;flex-direction:column;align-items:center;justify-content:space-between;gap:12px" class="bottom-bar-row">
            <style>
                @media (min-width: 640px) {
                    .bottom-bar-row {
                        flex-direction: row !important;
                    }
                }
            </style>
            <p class="text-dark-500 text-body-sm">
                &copy; {{ date('Y') }}
                <a href="{{ $r('home') }}" class="text-primary-400 hover:text-primary-300 transition-colors duration-200">
                    Meeqat.io
                </a>
                — All rights reserved.
            </p>
            <p style="color:rgba(71,85,105,.6);font-size:.75rem">
                Made with care for Hajj &amp; Umrah pilgrims
            </p>
            <p style="color:rgba(71,85,105,.6);font-size:.75rem">
                AI try-on demo:
                <a href="https://developer.puter.com" target="_blank" rel="noopener noreferrer" style="color:#34d399">Powered by Puter</a>
            </p>
        </div>
    </div>

    {{-- Responsive grid styles --}}
    <style>
        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }
        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
            .footer-grid > .footer-brand {
                grid-column: span 2;
            }
        }
        @media (min-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr 1fr 1fr;
            }
            .footer-grid > .footer-brand {
                grid-column: span 2;
            }
        }
    </style>
</footer>
