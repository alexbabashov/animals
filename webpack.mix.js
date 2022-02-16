const mix = require('laravel-mix');
const cfgWebpack = require('./webpack.config.js');
mix.webpackConfig(cfgWebpack);
if (mix.inProduction()) {
    mix.version(['assets/main.js', "/assets/vue.js", "/assets/styles.css"]);
}
