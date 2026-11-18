import defaultTheme from 'tailwindcss/defaultTheme';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Sora', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Azul-petróleo da Tinsei (o mesmo da loja B2B: #003B5A no 800).
                brand: {
                    50: '#f1f7fb',
                    100: '#e1eef6',
                    200: '#c0dcec',
                    300: '#8cbedb',
                    400: '#4f98c3',
                    500: '#2277a6',
                    600: '#0b5a85',
                    700: '#0a4b6f',
                    800: '#003b5a',
                    900: '#012c44',
                    950: '#001a29',
                },
                // Dourado de destaque da loja (#E8B042) — CTAs e números.
                gold: {
                    50: '#fdf8ec',
                    100: '#faedcc',
                    200: '#f5db99',
                    300: '#efc766',
                    400: '#e8b042',
                    500: '#d4992a',
                    600: '#a8781c',
                    700: '#866019',
                    800: '#5e4415',
                    900: '#3f2e10',
                },
                // Verde e laranja do símbolo da Tinsei — sustentabilidade.
                leaf: {
                    50: '#f2f8ec',
                    100: '#e1efd3',
                    300: '#9fcb6f',
                    400: '#6fa83a',
                    500: '#57961f',
                    600: '#3c7720',
                    700: '#2f5f1a',
                    800: '#164c1e',
                },
                ember: {
                    400: '#fe8c1a',
                    500: '#fe7e17',
                    600: '#e5590e',
                },
            },
            backgroundImage: {
                'grid-pattern': 'linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px)',
                'dot-pattern': 'radial-gradient(rgba(0,59,90,.12) 1px, transparent 1px)',
            },
            backgroundSize: {
                grid: '44px 44px',
                dot: '18px 18px',
            },
            boxShadow: {
                soft: '0 10px 40px -12px rgba(0, 42, 64, 0.18)',
            },
        },
    },
    plugins: [typography],
};
