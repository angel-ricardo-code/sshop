import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    // Build to public/build so the compiled assets can be served as static files
    // (Vercel will use the `public` folder as the output directory).
    build: {
        manifest: true,
        outDir: 'public/build',
        // keep other files in public (don't empty it)
        emptyOutDir: false,
    },
});
