import defaultTheme from 'tailwindcss/defaultTheme';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Open Sans"', ...defaultTheme.fontFamily.sans],
                heading: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Identidade visual oficial do CRN-9 (verde sóbrio como cor
                // primária), extraída de https://crn9.org.br/identidade-visual-do-crn-9/
                brand: {
                    50: '#f4f4f0',
                    100: '#deded4',
                    200: '#c8c9b8',
                    300: '#b3b49c',
                    400: '#9d9e7f',
                    500: '#878963',
                    600: '#727347',
                    700: '#5c5e2b',
                    800: '#474921',
                    900: '#313318',
                    950: '#1c1e0e',
                },
                // Cores de apoio da identidade visual do CRN-9.
                'brand-leaf': '#a3a64a', // verde jovial
                'brand-orange': '#f58c4a', // laranja — proximidade com o público
                'brand-blue': '#85b0ff', // azul luminoso — seriedade e credibilidade
            },
        },
    },
    plugins: [typography],
};
