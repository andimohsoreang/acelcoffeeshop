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
            colors: {
                brand: {
                    primary: '#4B2C20',   // Dark Coffee Brown
                    secondary: '#F8F1E7', // Light Cream (Page Background)
                    accent: '#E31E24',    // Crimson Red
                    dark: '#2D1810',      // Deep Brown
                    muted: '#A29691',     // Medium Muted Brown (Accents)
                    surface: '#FFFFFF',   // Pure White (Cards/Content)
                    cream: '#FCF9F1',     // Soft Off-White
                }
            }
        },
    },

    plugins: [forms],
};
