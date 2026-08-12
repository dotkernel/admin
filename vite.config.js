/*
 * Vite is used to compile and minify JS and Sass.
 *
 * Assets are compiled from src/App/assets into the public directory:
 *   js/*.js     - one file per entry below, plus the shared js/vendor.js
 *   css/app.css - compiled from scss/index.scss (imported by js/index.js)
 *   fonts/*     - emitted for every font referenced by the stylesheets
 *   images/app/ - copied verbatim from App/assets/images
 *
 * So please, DO NOT MANUALLY ADD ASSETS TO THE PUBLIC DIRECTORY!
 */

import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import fs from 'fs';
import path from 'path';

const projectRoot = import.meta.dirname;

const assetsPath = 'App/assets';
const imagesPath = `${assetsPath}/images`;

/*
 * The public directory is never emptied, so a production build has to clear out
 * the source maps a previous development build left behind. Without this they
 * would linger next to the minified assets they no longer describe.
 */
const removeStaleSourceMaps = () => ({
    name: 'remove-stale-source-maps',
    closeBundle() {
        for (const directory of ['js', 'css']) {
            const directoryPath = path.resolve(projectRoot, 'public', directory);
            if (! fs.existsSync(directoryPath)) {
                continue;
            }

            for (const file of fs.readdirSync(directoryPath)) {
                if (file.endsWith('.map')) {
                    fs.unlinkSync(path.join(directoryPath, file));
                }
            }
        }
    },
});

/*
 * Each entry becomes public/js/<name>.js and is loaded by a template as
 * <script type="module">. Code shared between them (jQuery, Bootstrap,
 * Chart.js, ...) is emitted once as a shared chunk.
 */
const entries = {
    app: `${assetsPath}/js/index.js`,
    admin: `${assetsPath}/js/components/_admin.js`,
    table_settings: `${assetsPath}/js/components/_table_settings.js`,
    user: `${assetsPath}/js/components/_user.js`,
};

export default defineConfig(({ mode }) => {
    const isDevelopment = mode === 'development';

    return {
        // Look for source files under src, mirroring the asset paths above.
        root: path.resolve(projectRoot, 'src'),

        plugins: [
            viteStaticCopy({
                targets: [
                    {
                        src: `${imagesPath}/**/*`,
                        dest: 'images/app',
                        // Globs only match files, so the images directory has to
                        // be walked recursively and its leading path segments
                        // dropped to keep the nested directories intact.
                        rename: { stripBase: imagesPath.split('/').length },
                    },
                ],
            }),
            ! isDevelopment && removeStaleSourceMaps(),
        ],

        build: {
            outDir: path.resolve(projectRoot, 'public'),

            // public/ also holds index.php, robots.txt and uploads/, so it must
            // never be wiped. Compiled assets use stable names and overwrite in
            // place instead.
            emptyOutDir: false,

            /*
             * Development builds are readable and mapped, production builds are
             * minified with no map. The maps are written as separate .map files
             * (ignored by git) rather than inlined, so that the committed
             * bundles never carry a base64 copy of their own sources.
             *
             * Only `npm run prod` produces assets meant to be committed.
             */
            sourcemap: isDevelopment,
            minify: ! isDevelopment,

            rollupOptions: {
                input: entries,
                output: {
                    entryFileNames: 'js/[name].js',
                    chunkFileNames: 'js/[name].js',
                    assetFileNames: (assetInfo) => {
                        const fileName = assetInfo.names?.[0] ?? assetInfo.name ?? '';
                        const sourcePath = assetInfo.originalFileNames?.[0] ?? '';

                        if (/\.css$/i.test(fileName)) {
                            return 'css/[name][extname]';
                        }

                        // An SVG may be either a font or an image, so anything
                        // living in an image directory is not treated as a font.
                        if (
                            /\.(woff2?|eot|ttf|otf|svg)$/i.test(fileName)
                            && ! /(^|\/)(images?|img)\//i.test(sourcePath)
                        ) {
                            return 'fonts/[name][extname]';
                        }

                        return 'assets/[name][extname]';
                    },
                    /*
                     * Chunking is deliberately left to Rollup. Forcing the
                     * dependencies into a chunk of their own reorders them ahead
                     * of the entry that sets window.jQuery, which breaks
                     * jquery-sparkline: it reads the global instead of importing
                     * jQuery, so it throws while the bundle is still loading.
                     */
                },
            },
        },

        css: {
            preprocessorOptions: {
                scss: {
                    // Bootstrap 5.3 still uses @import internally; silence the
                    // Dart Sass deprecation warnings it emits.
                    quietDeps: true,
                },
            },
        },
    };
});
