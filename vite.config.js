import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    resolve: {
        alias: {
            '~inter': '/node_modules/inter-ui',
            '~title-font': '/node_modules/@fontsource/instrument-serif',
            '~font-awesome': '/node_modules/@fortawesome/fontawesome-free',
            '~easyMDE': '/node_modules/easymde',
            '@': '/resources/assets',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/style.scss',
                'resources/sass/backend.scss',
                'resources/sass/easymde.scss',
                'resources/js/backend.js',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        purge({
            paths: ['resources/views/**/*.blade.php'],
            safelist: {
                deep: [
                    /CodeMirror/,
                    /editor-/,
                    /easymde/,
                    /cm-/,
                ]
            }
        })
    ],
});
