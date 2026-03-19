import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                quietDeps: true,
                silenceDeprecations: ['import', 'global-builtin', 'if-function', 'color-functions'],
            },
        },
    },
    plugins: [
        laravel({
            input: [
                //css
                "resources/scss/style.scss",
                "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
                "node_modules/bootstrap-icons/font/bootstrap-icons.css",
                "node_modules/tiny-slider/dist/tiny-slider.css",
                "node_modules/glightbox/dist/css/glightbox.css",
                "node_modules/aos/dist/aos.css",
                "node_modules/choices.js/public/assets/styles/choices.min.css",
                "node_modules/plyr/dist/plyr.css",
                "node_modules/apexcharts/dist/apexcharts.css",
                "node_modules/quill/dist/quill.snow.css",
                "node_modules/bs-stepper/dist/css/bs-stepper.min.css",
                "node_modules/overlayscrollbars/styles/overlayscrollbars.min.css",

                //js
                "resources/js/functions.js",
            ],
            refresh: true,
        }),
    ],
});
