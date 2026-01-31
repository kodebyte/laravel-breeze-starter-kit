import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 1. Aset Web
                'resources/css/app.css',
                'resources/js/app.js',
                
                // 2. Aset Admin (BARU)
                'resources/css/admin-app.css',
                'resources/js/admin-app.js',
            ],
            refresh: true,
        }),
    ],
});
