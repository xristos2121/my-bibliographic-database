import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/front.scss',
                'resources/js/app.js',
                'resources/js/front.js',
            ],
            refresh: true,
        }),
    ],
    resolve : {
        alias: {
            '$':'jQuery',
        }
    },
});
