import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['favicon.ico', 'apple-touch-icon.png', 'favicon-96x96.png'],
            manifest: {
                name: 'App Academia',
                short_name: 'Academia',
                description: 'App para gerenciamento de treinos e medidas corporais.',
                theme_color: '#ffffff',
                background_color: '#ffffff',
                display: 'standalone',
                start_url: '/',
                id: '/',
                scope: '/',
                icons: [
                    {
                        src: 'web-app-manifest-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: 'web-app-manifest-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ],
                screenshots: [
                    {
                      "src": "https://placehold.co/540x720.png",
                      "type": "image/png",
                      "sizes": "540x720",
                      "form_factor": "narrow",
                      "label": "Tela Principal do App (Mobile)"
                    },
                    {
                      "src": "https://placehold.co/1280x720.png",
                      "type": "image/png",
                      "sizes": "1280x720",
                      "form_factor": "wide",
                      "label": "Tela Principal do App (Desktop)"
                    }
                ]
            },
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg}'],
                runtimeCaching: [
                    {
                        urlPattern: new RegExp('^https://fonts\.bunny\.net/.*', 'i'),
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'google-fonts-cache',
                            expiration: {
                                maxEntries: 10,
                                maxAgeSeconds: 60 * 60 * 24 * 365 // <== 365 days
                            },
                            cacheableResponse: {
                                statuses: [0, 200]
                            }
                        }
                    }
                ]
            }
        })
    ],
});