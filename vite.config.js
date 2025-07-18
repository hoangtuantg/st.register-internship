import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss', 
                'resources/js/app.js',
                'resources/css/auth.scss',
                'resources/js/campaign/index.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
