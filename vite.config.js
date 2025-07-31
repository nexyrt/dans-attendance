import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/face-attendance.js',  // Add thi
                'resources/js/qr-attendance.js'  // Add this
            ],
            refresh: true,
        }),
    ],
});