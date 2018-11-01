const mix = require('laravel-mix')
//const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')

    .sourceMaps()
    .disableNotifications()

if (mix.inProduction) {
    mix.version()
}

mix.webpackConfig({
    plugins: [
        //new BundleAnalyzerPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
    },
    output: {
        publicPath: mix.config.hmr ? '//localhost:8080' : '/',
        jsonpFunction: 'webpackJsonp'
    }
})