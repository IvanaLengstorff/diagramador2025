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
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: false,
        hmr: {
            host: process.env.VITE_HMR_HOST || 'localhost',
            port: process.env.VITE_HMR_PORT || 5173,
            protocol: process.env.VITE_HMR_PROTOCOL || 'http',
        },
    },
});
