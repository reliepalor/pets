import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'gradient-to-r': 'linear-gradient(to right, #800080, #FF69B4, #FFA500)',
            },
        },
    },

    safelist: [
        'bg-gradient-to-r',
        'from-[#800080]',
        'via-[#FF69B4]',
        'to-[#FFA500]',
    ],

    plugins: [forms],
};