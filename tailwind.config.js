// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50:  '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#059669',
                    600: '#047857',
                    700: '#065f46',
                    800: '#064E3B',
                    900: '#022c22',
                },

                secondary: {
                    50:  '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#D97706',
                    600: '#b45309',
                    700: '#92400e',
                    800: '#78350f',
                    900: '#451a03',
                },

                gold: {
                    50:  '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#D97706',
                    600: '#b45309',
                    700: '#92400e',
                },

                accent: {
                    50:  '#fdf2f8',
                    100: '#fce7f3',
                    200: '#fbcfe8',
                    300: '#f9a8d4',
                    400: '#f472b6',
                    500: '#6B342D',
                    600: '#5a2b25',
                    700: '#4a221e',
                },

                amber: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                },

                blue: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                },

                purple: {
                    50: '#faf5ff',
                    100: '#f3e8ff',
                    200: '#e9d5ff',
                    300: '#d8b4fe',
                    400: '#a78bfa',
                    500: '#8b5cf6',
                    600: '#7c3aed',
                    700: '#6d28d9',
                },

                pink: {
                    50: '#fdf2f8',
                    100: '#fce7f3',
                    200: '#fbcfe8',
                    300: '#f9a8d4',
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
                    700: '#be185d',
                },

                dark: {
                    50:  '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#020617',
                },

                surface: '#FFFFFF',
                background: '#F8FAFC',
                heading: '#111827',
                body:    '#374151',
                muted:   '#6B7280',
                border:  '#E5E7EB',
                footer: '#111827',
            },

            fontFamily: {
                sans:     ['Inter', ...defaultTheme.fontFamily.sans],
                heading:  ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                arabic:   ['Amiri', 'serif'],
                urdu:     ['Noto Nastaliq Urdu', 'Amiri', 'serif'],
            },

            fontSize: {
                display:   ['3.5rem',  { lineHeight: '1.1',  fontWeight: '700', letterSpacing: '-0.02em' }],
                h1:        ['2.5rem',  { lineHeight: '1.2',  fontWeight: '700', letterSpacing: '-0.02em' }],
                h2:        ['2rem',    { lineHeight: '1.25', fontWeight: '700', letterSpacing: '-0.01em' }],
                h3:        ['1.5rem',  { lineHeight: '1.3',  fontWeight: '600', letterSpacing: '-0.01em' }],
                h4:        ['1.25rem', { lineHeight: '1.4',  fontWeight: '600' }],
                h5:        ['1.125rem',{ lineHeight: '1.5',  fontWeight: '600' }],
                'body-lg': ['1.125rem',{ lineHeight: '1.75' }],
                body:      ['1rem',    { lineHeight: '1.75' }],
                'body-sm': ['0.875rem',{ lineHeight: '1.6'  }],
                caption:   ['0.75rem', { lineHeight: '1.5'  }],
            },

            borderRadius: {
                card:   '1.5rem',
                btn:    '0.75rem',
                input:  '0.75rem',
                badge:  '9999px',
            },

            boxShadow: {
                card:           '0 4px 24px 0 rgba(0, 0, 0, 0.06)',
                'card-hover':   '0 12px 40px 0 rgba(0, 0, 0, 0.12)',
                elevated:       '0 8px 32px 0 rgba(0, 0, 0, 0.08)',
                'glow-green':   '0 0 20px rgba(5, 150, 105, 0.25)',
                'glow-green-lg': '0 0 30px rgba(5, 150, 105, 0.35)',
                'glow-amber':   '0 0 20px rgba(217, 119, 6, 0.25)',
                btn:            '0 2px 8px 0 rgba(5, 150, 105, 0.3)',
                'inner-glow':   'inset 0 0 20px rgba(0, 0, 0, 0.1)',
            },

            backgroundImage: {
                islamic:       'radial-gradient(ellipse at 20% 50%, rgba(5,150,105,0.04) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(217,119,6,0.03) 0%, transparent 60%)',
                'hero-overlay': 'linear-gradient(135deg, rgba(6,78,59,0.85) 0%, rgba(5,150,105,0.60) 50%, rgba(6,78,59,0.80) 100%)',
                sidebar:       'linear-gradient(180deg, #0f172a 0%, #0b1120 100%)',
                'btn-primary':  'linear-gradient(135deg, #059669 0%, #047857 100%)',
                mesh:          'radial-gradient(ellipse at 20% 50%, rgba(5,150,105,0.08) 0%, transparent 50%), radial-gradient(ellipse at 80% 80%, rgba(6,78,59,0.12) 0%, transparent 50%)',
                'hero-glow':    'radial-gradient(ellipse at 30% 50%, rgba(5,150,105,0.15) 0%, transparent 60%), radial-gradient(ellipse at 70% 50%, rgba(217,119,6,0.08) 0%, transparent 60%)',
            },

            animation: {
                'fade-in':    'fadeIn 0.4s ease-out',
                'slide-up':   'slideUp 0.4s ease-out',
                'scale-in':   'scaleIn 0.3s ease-out',
                'pulse-slow': 'pulseSlow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                float:        'float 3s ease-in-out infinite',
                glow:         'glow 2s ease-in-out infinite alternate',
            },

            keyframes: {
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%':   { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%':   { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                pulseSlow: {
                    '0%, 100%': { opacity: '1' },
                    '50%':      { opacity: '0.4' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%':      { transform: 'translateY(-8px)' },
                },
                glow: {
                    '0%':   { boxShadow: '0 0 10px rgba(5, 150, 105, 0.3)' },
                    '100%': { boxShadow: '0 0 30px rgba(5, 150, 105, 0.6)' },
                },
            },
        },
    },

    plugins: [forms],
};