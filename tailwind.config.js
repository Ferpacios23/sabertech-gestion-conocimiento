const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
            colors: {
                // Azul institucional de SaberTech
                marca: {
                    50: '#EEF4FA',
                    100: '#D9E6F2',
                    200: '#B3CDE5',
                    500: '#2C6AA3',
                    600: '#1F4E79',
                    700: '#183E61',
                    800: '#12304B',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
