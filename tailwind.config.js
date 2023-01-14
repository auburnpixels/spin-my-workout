const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {

        extend: {
            fontFamily: {
                sans: ['Gotham', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'pakapou-primary': '#086151',
                'pakapou-primary-lighter': '#01715D',
                'pakapou-secondary': '#FDD65C'
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
