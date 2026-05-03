import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Livewire/**/*.php',
    ],

    safelist: [
        // Booking status colors
        'from-blue-500/90', 'to-blue-600/90', 'border-blue-400/50', 'shadow-blue-500/30',
        'from-emerald-500/90', 'to-green-600/90', 'border-emerald-400/50', 'shadow-emerald-500/30',
        'from-rose-500/90', 'to-red-600/90', 'border-rose-400/50', 'shadow-rose-500/30',
        'from-slate-500/80', 'to-slate-600/80', 'border-slate-400/40', 'shadow-slate-500/20',
        // Rounded variants
        'rounded-xl', 'rounded-l-xl', 'rounded-r-xl', 'rounded-none',
        // Text colors
        'text-blue-50', 'text-emerald-50', 'text-rose-50', 'text-slate-100',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateColumns: {
                '24': 'repeat(24, minmax(0, 1fr))',
            },
            // Enhanced shadows for depth
            boxShadow: {
                'inner-lg': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.3)',
            },
            // Smooth transitions
            transitionDuration: {
                '200': '200ms',
                '300': '300ms',
            },
        },
    },

    plugins: [forms],
};
