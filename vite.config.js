import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: '/build/', // ⬅️ WAJIB

    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/topbar.css',
                'resources/css/sidebar-mobile.css',
                'resources/css/pharmacy-mobile.css',
                'resources/css/obat.css',
                'resources/css/antrian.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});