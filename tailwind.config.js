import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./node_modules/flowbite/**/*.js",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Remove any custom list styling
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
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
