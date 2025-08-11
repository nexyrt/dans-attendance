import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        require('./vendor/tallstackui/tallstackui/tailwind.config.js') 
    ],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        './vendor/tallstackui/tallstackui/src/**/*.php', 
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',  // Primary color from design
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                    950: '#172554',
                },
                secondary: {
                    50: '#f8fafc',
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
            },
            listStyleType: {
                none: 'none',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backdropFilter: {
                'none': 'none',
                'blur': 'blur(10px)',
            },
            boxShadow: {
                'blur-spread': '0 0 15px 5px rgba(59, 130, 246, 0.5)',
            },
        },
        variants: {
            extend: {
                backdropFilter: ['responsive', 'hover', 'focus'],
                boxShadow: ['focus'],
            },
        },
        screens: {
            'md': '640px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1440px'
        },
    },
    plugins: [
        forms,
    ],
};