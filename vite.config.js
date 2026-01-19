// vite.config.js - Asegurar JointJS
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    define: {
        global: 'globalThis',
    },
    optimizeDeps: {
        include: ['jointjs', 'lodash', 'backbone', 'jquery']
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        manifest: true,
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: false,
        hmr: {
            host: '98.83.42.61',
            port: 443,
            protocol: 'https',
        },
    },
});
