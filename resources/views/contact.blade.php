{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')
@section('title', 'Contact Us - Meeqat.io')

@section('content')

<style>
    .contact-header{background:#0B0F14;padding:100px 24px 40px;position:relative;overflow:hidden}
    .contact-header::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:radial-gradient(ellipse at 30% 50%,rgba(16,185,129,.08) 0%,transparent 60%),radial-gradient(ellipse at 70% 20%,rgba(251,191,36,.04) 0%,transparent 50%);pointer-events:none}
    .contact-header .breadcrumb{display:flex;align-items:center;gap:8px;font-size:.8rem;color:rgba(255,255,255,.4);margin-bottom:16px;position:relative}
    .contact-header .breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none;transition:color .2s}
    .contact-header .breadcrumb a:hover{color:#34d399}
    .contact-header .breadcrumb .current{color:#34d399;font-weight:500}
    .contact-header h1{font-size:clamp(1.6rem,3.5vw,2.2rem);font-weight:800;color:#fff;position:relative;line-height:1.2}
    .contact-header h1 span{color:#34d399}
    .contact-header p{color:rgba(255,255,255,.45);font-size:.95rem;margin-top:10px;position:relative;max-width:500px}

    .page-body{background:#F1F5F9;min-height:60vh;padding:40px 24px 60px}
    @media(min-width:768px){.page-body{padding:48px 32px 70px}}

    .section-title{display:flex;align-items:center;gap:10px;margin-bottom:6px}
    .section-title h2{font-size:1.15rem;font-weight:700;color:#0B0F14}
    .section-title .tag{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:999px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#059669;font-size:.7rem;font-weight:600}
    .section-sub{color:#6B7280;font-size:.85rem;margin-bottom:28px}

    .info-card{background:#fff;border:1px solid #E5E7EB;border-radius:14px;padding:22px;transition:all .25s ease}
    .info-card:hover{border-color:rgba(16,185,129,.3);box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .info-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .info-icon.green{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.18)}
    .info-icon.amber{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.18)}
    .info-icon.blue{background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.18)}
    .info-icon.purple{background:rgba(139,92,246,.1);border:1px solid rgba(139,92,246,.18)}

    .form-card{background:#fff;border:1px solid #E5E7EB;border-radius:14px;padding:32px;position:relative;overflow:hidden}
    .form-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#10b981,#059669)}

    .field-label{display:block;color:#374151;font-size:.78rem;font-weight:600;margin-bottom:6px;text-transform:uppercase;letter-spacing:.03em}
    .field-input{width:100%;padding:11px 14px;background:#F9FAFB;border:1px solid #E5E7EB;border-radius:8px;color:#0B0F14;font-size:.88rem;font-family:inherit;transition:all .2s ease;outline:none}
    .field-input::placeholder{color:#9CA3AF}
    .field-input:focus{border-color:#10b981;background:#fff;box-shadow:0 0 0 3px rgba(16,185,129,.1)}
    textarea.field-input{resize:vertical;min-height:120px}

    .send-btn{width:100%;padding:13px 24px;border:none;border-radius:10px;font-size:.92rem;font-weight:700;font-family:inherit;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#10b981;color:#fff;transition:all .25s ease;box-shadow:0 2px 12px rgba(16,185,129,.25)}
    .send-btn:hover{background:#059669;transform:translateY(-1px);box-shadow:0 4px 20px rgba(16,185,129,.35)}

    .social-btn{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:#F3F4F6;border:1px solid #E5E7EB;color:#6B7280;transition:all .2s ease}
    .social-btn:hover{background:#ECFDF5;border-color:rgba(16,185,129,.3);color:#059669}

    .faq-item{background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:18px 20px;transition:all .2s ease}
    .faq-item:hover{border-color:rgba(16,185,129,.25)}
    .faq-q{font-weight:600;color:#0B0F14;font-size:.9rem;margin-bottom:4px}
    .faq-a{color:#6B7280;font-size:.83rem;line-height:1.6}
</style>

{{-- Header --}}
<div class="contact-header">
    <div style="max-width:1100px;margin:0 auto;position:relative">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="current">Contact</span>
        </div>
        <h1>Contact <span>Us</span></h1>
        <p>Have questions or suggestions? We'd love to hear from you. Our team is here to help.</p>
    </div>
</div>

{{-- Body --}}
<div class="page-body">
    <div style="max-width:1100px;margin:0 auto">

        {{-- Section Title --}}
        <div class="section-title">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.18)">
                <svg class="w-5 h-5" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            </div>
            <h2>Get In Touch</h2>
            <span class="tag">
                <span style="width:5px;height:5px;border-radius:50%;background:#059669"></span>
                Active
            </span>
        </div>
        <p class="section-sub">Fill out the form and our team will get back to you within 24 hours.</p>

        {{-- Two Column --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Form --}}
            <div class="lg:col-span-2">
                <div class="form-card">
                    <div class="flex items-center gap-3 mb-6 pb-5" style="border-bottom:1px solid #F3F4F6">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.18)">
                            <svg class="w-5 h-5" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </div>
                        <div>
                            <h3 style="color:#0B0F14;font-weight:700;font-size:1rem">Send us a message</h3>
                            <p style="color:#9CA3AF;font-size:.8rem">We typically respond within 24 hours</p>
                        </div>
                    </div>

                    <form action="{{ route('contact.send') }}" method="POST" novalidate>
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="contact-name" class="field-label">Name *</label>
                                <input type="text" id="contact-name" name="name" class="field-input" value="{{ old('name') }}" required autocomplete="name" placeholder="Your full name">
                                @error('name')
                                    <p style="color:#DC2626;font-size:.76rem;margin-top:5px;display:flex;align-items:center;gap:4px">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label for="contact-email" class="field-label">Email *</label>
                                <input type="email" id="contact-email" name="email" class="field-input" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">
                                @error('email')
                                    <p style="color:#DC2626;font-size:.76rem;margin-top:5px;display:flex;align-items:center;gap:4px">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="contact-subject" class="field-label">Subject</label>
                            <input type="text" id="contact-subject" name="subject" class="field-input" value="{{ old('subject') }}" placeholder="What is this about?">
                        </div>

                        <div class="mb-6">
                            <label for="contact-message" class="field-label">Message *</label>
                            <textarea id="contact-message" name="message" class="field-input" rows="5" required placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                            @error('message')
                                <p style="color:#DC2626;font-size:.76rem;margin-top:5px;display:flex;align-items:center;gap:4px">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit" class="send-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right: Info Cards --}}
            <div class="flex flex-col gap-5">

                {{-- Email --}}
                <div class="info-card">
                    <div class="flex items-start gap-3.5">
                        <div class="info-icon green">
                            <svg class="w-5 h-5" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div>
                            <h4 style="color:#0B0F14;font-weight:600;font-size:.9rem;margin-bottom:2px">Email Us</h4>
                            <p style="color:#6B7280;font-size:.82rem">support@meeqat.io</p>
                            <p style="color:#9CA3AF;font-size:.72rem;margin-top:3px">We reply within 24 hours</p>
                        </div>
                    </div>
                </div>

                {{-- Response Time --}}
                <div class="info-card">
                    <div class="flex items-start gap-3.5">
                        <div class="info-icon amber">
                            <svg class="w-5 h-5" style="color:#D97706" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 style="color:#0B0F14;font-weight:600;font-size:.9rem;margin-bottom:2px">Global Support</h4>
                            <p style="color:#6B7280;font-size:.82rem">Available worldwide for pilgrims</p>
                            <p style="color:#9CA3AF;font-size:.72rem;margin-top:3px">Mon - Fri, 9am - 6pm PKT</p>
                        </div>
                    </div>
                </div>

                {{-- Feedback --}}
                <div class="info-card">
                    <div class="flex items-start gap-3.5">
                        <div class="info-icon blue">
                            <svg class="w-5 h-5" style="color:#2563EB" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                        </div>
                        <div>
                            <h4 style="color:#0B0F14;font-weight:600;font-size:.9rem;margin-bottom:2px">Feedback</h4>
                            <p style="color:#6B7280;font-size:.82rem">Help us improve Meeqat.io</p>
                            <p style="color:#9CA3AF;font-size:.72rem;margin-top:3px">Your ideas shape our roadmap</p>
                        </div>
                    </div>
                </div>

                {{-- Social --}}
                <div class="info-card">
                    <h4 style="color:#0B0F14;font-weight:600;font-size:.9rem;margin-bottom:12px">Follow Us</h4>
                    <div class="flex gap-2.5">
                        <a href="https://facebook.com/meeqatio" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://instagram.com/meeqat.io" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://youtube.com/@meeqatio" target="_blank" rel="noopener noreferrer" class="social-btn" aria-label="YouTube">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- FAQ --}}
                <div>
                    <h4 style="color:#0B0F14;font-weight:700;font-size:.95rem;margin-bottom:14px">Frequently Asked</h4>
                    <div class="flex flex-col gap-3">
                        <div class="faq-item">
                            <p class="faq-q">How do I calculate my Chaddar size?</p>
                            <p class="faq-a">Use our Chaddar Calculator — enter your height and choose your style to get exact fabric meters.</p>
                        </div>
                        <div class="faq-item">
                            <p class="faq-q">Is Meeqat.io free to use?</p>
                            <p class="faq-a">Yes, all tools are completely free for every pilgrim.</p>
                        </div>
                        <div class="faq-item">
                            <p class="faq-q">How do I find my nearest Meeqat?</p>
                            <p class="faq-a">Open the Meeqat Finder, allow location access, and it will show the nearest Meeqat with distance.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
