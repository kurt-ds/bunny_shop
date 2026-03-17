import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'primary': '#7DD3C0',
                'secondary': '#2D3748',
                'tertiary': '#FF9F9B',
            },
            fontFamily: {
                sans: ['Poppins', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
