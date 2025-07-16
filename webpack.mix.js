const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/dist/js")
    .sass("resources/sass/app.scss", "public/dist/css")
.options({
    processCssUrls: false,
    postCss: [tailwindcss("./tailwind.config.js")],
})
.autoload({
    "cash-dom": ["$"],
})
.copyDirectory("resources/json", "public/dist/json")
.copyDirectory("resources/fonts", "public/dist/fonts")
.copyDirectory("resources/images", "public/dist/images")
.browserSync({
    proxy: "localhost",
    files: ["resources/**/*.*"],
});


// Plugins JS
mix.combine([
    'resources/plugins/js/3.7.0_jquery.min.js',
    'resources/plugins/js/datatables/datatables.min.js',
    'resources/plugins/js/datatables/dataTables.buttons.min.js',
    'resources/plugins/js/datatables/pdfmake.min.js',
    'resources/plugins/js/datatables/buttons.html5.min.js',
    'resources/plugins/js/datatables/buttons.print.min.js',
    'resources/plugins/js/datatables/jszip.min.js'
], 'public/dist/plugins/js/plugins.js');

// Plugins CSS
mix.combine([
    'resources/plugins/css/datatables.min.css',
    'resources/plugins/css/buttons.dataTables.min.css'
], 'public/dist/plugins/css/plugins.css');

// Customize CSS
mix.combine([
    'resources/css/datatables-custom.css'
], 'public/dist/css/custom.css');

// get images
mix.copy('resources/images', 'public/images');