import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    resolve: {
        alias: {
            '~bootstrap': '/node_modules/bootstrap',
            '~geist': '/node_modules/geist/dist/fonts',
            '~@fortawesome': '/node_modules/@fortawesome',
            '~easymde': '/node_modules/easymde/dist',
            '~fancy-title': '/node_modules/@fontsource/space-grotesk',
            '@': '/resources/assets',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/style.scss',
                'resources/sass/backend.scss',
                'resources/sass/easymde.scss',
                'resources/js/app.js',
                'resources/js/backend.js',
                'resources/js/easymde.js',
            ],
            refresh: true,
        }),
        purge({
            templates: ['blade']
        })
    ],
});
