import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: '#ee2b8c',
                'background-light': '#f8f6f7',
                'background-dark': '#221019',
                'soft-lavender': '#f3e8ff',
            },
            fontFamily: {
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                DEFAULT: '0.5rem',
                lg: '1rem',
                xl: '1.5rem',
                full: '9999px',
            },
        },
    },
    plugins: [forms],
};
