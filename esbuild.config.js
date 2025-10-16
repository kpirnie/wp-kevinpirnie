const esbuild = require('esbuild');

esbuild.build({
    entryPoints: ['./assets/js/theme.debug.js'],
    bundle: true,
    minify: true,
    outfile: './assets/js/theme.min.js',
    format: 'esm',
    platform: 'browser',
    logLevel: 'info'
}).catch(() => process.exit(1));