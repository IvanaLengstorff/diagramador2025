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
        hmr: process.env.VITE_HMR_HOST ? {
            host: process.env.VITE_HMR_HOST,
            port: process.env.VITE_HMR_PORT || 443,
            protocol: process.env.VITE_HMR_PROTOCOL || 'https',
        } : true,
    },
});
