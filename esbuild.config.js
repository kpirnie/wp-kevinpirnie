const esbuild = require('esbuild');

esbuild.build({
    entryPoints: ['./assets/js/theme.debug.js'],
    bundle: true,
    minify: true,
    outfile: './assets/js/theme.min.js',
    format: 'esm',
    platform: 'browser',
    loader: {
        '.woff': 'file',
        '.woff2': 'file',
        '.ttf': 'file',
        '.eot': 'file',
        '.svg': 'file'
    },
    assetNames: '/fonts/[name]',
    publicPath: '/wp-content/themes/kevinpirnie/assets'
}).catch(() => process.exit(1));