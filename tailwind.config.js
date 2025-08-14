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
        },
    },

    plugins: [
        forms({
            strategy: 'base', // Isso remove os estilos padrão do plugin do forms
        }),
        function ({ addBase, theme }) {
            addBase({
                // Estilos personalizados para os campos de formulário
                'input:not([type="checkbox"]):not([type="radio"]), textarea, select': {
                    'background-color': 'white',
                    'border-color': theme('colors.gray.300'),
                    'color': theme('colors.gray.900'),
                    '&:focus': {
                        'border-color': theme('colors.indigo.500'),
                        'box-shadow': theme('boxShadow.sm'),
                        '--tw-ring-color': theme('colors.indigo.500'),
                    },
                },
                // Estilos para as labels
                colors: {
                'primary-text': '#111827', // <-- Sua nova cor para o texto
            },

            });
        },
    ],
};