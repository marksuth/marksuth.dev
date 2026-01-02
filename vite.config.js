import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    resolve: {
        alias: {
            '~inter': '/node_modules/inter-ui',
            '~title-font': '/node_modules/@fontsource/instrument-serif',
            '~font-awesome': '/node_modules/@fortawesome/fontawesome-free',
            '@': '/resources/assets',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/style.scss',
                'resources/sass/backend.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        purge({
            paths: ['resources/views/**/*.blade.php']
        })
    ],
});
