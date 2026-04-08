import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/topbar.css',
                'resources/css/sidebar-mobile.css',
                'resources/css/pharmacy-mobile.css',
                'public/css/pharmacy/obat.css',
                'public/css/pharmacy/antrian.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});