// resources/js/app.js

import './bootstrap';
import Alpine from 'alpinejs';
import './tryon/index.js';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

// ── Alpine Plugins ──────────────────────────────────────────
Alpine.plugin(intersect);
Alpine.plugin(collapse);


// Only start Alpine if it hasn't been started already
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}

// ── Toast Notification Manager ──────────────────────────────
Alpine.data('toast', () => ({
    notifications: [],
    nextId: 0,

    add(message, type = 'success') {
        const id = this.nextId++;
        this.notifications.push({ id, message, type });

        // Auto-remove after 4 seconds
        setTimeout(() => this.remove(id), 4000);
    },

    remove(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    },
}));

// ── Navbar scroll state ──────────────────────────────────────
Alpine.data('navbar', () => ({
    scrolled: false,
    mobileOpen: false,

    init() {
        this.scrolled = window.scrollY > 20;
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 20;
        }, { passive: true });
    },

    toggleMobile() {
        this.mobileOpen = !this.mobileOpen;
    },

    closeMobile() {
        this.mobileOpen = false;
    },
}));

// ── Counter Animation ────────────────────────────────────────
Alpine.data('counter', (target, duration = 1500) => ({
    current: 0,
    target,
    duration,

    start() {
        const start = performance.now();
        const animate = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / this.duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            this.current = Math.round(eased * this.target);
            if (progress < 1) requestAnimationFrame(animate);
        };
        requestAnimationFrame(animate);
    },
}));

// ── Accordion ───────────────────────────────────────────────
Alpine.data('accordion', () => ({
    openItem: null,

    toggle(item) {
        this.openItem = this.openItem === item ? null : item;
    },

    isOpen(item) {
        return this.openItem === item;
    },
}));

// ── Image Lazy Load with fade ────────────────────────────────
Alpine.data('lazyImage', () => ({
    loaded: false,

    onLoad() {
        this.loaded = true;
    },
}));

// ── Scroll Reveal Animation ─────────────────────────────────
Alpine.data('reveal', () => ({
    visible: false,

    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.visible = true;
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        observer.observe(this.$el);
    },
}));

// ── Mount Alpine ────────────────────────────────────────────
window.Alpine = Alpine;
Alpine.start();