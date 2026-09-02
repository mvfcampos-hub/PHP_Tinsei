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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Azul institucional da Databit. Ajustar os tons caso a Databit
                // forneça o manual de marca oficial com valores hexadecimais exatos.
                brand: {
                    50: '#eef4ff',
                    100: '#dbe6fe',
                    200: '#bcd0fd',
                    300: '#8fb0fc',
                    400: '#5b87f8',
                    500: '#3363f0',
                    600: '#2347d6',
                    700: '#1d38ab',
                    800: '#1c3189',
                    900: '#1b2c6e',
                    950: '#0e1836',
                },
                // Acento ciano usado com moderação para reforçar a identidade
                // tecnológica (cloud, dados) sem sobrepor o azul institucional.
                accent: {
                    400: '#22d3ee',
                    500: '#06b6d4',
                    600: '#0891b2',
                },
            },
            backgroundImage: {
                'grid-pattern': "linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px)",
            },
        },
    },
    plugins: [typography],
};
