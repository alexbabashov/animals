
const webpack = require('webpack');
const path = require('path');
const Dotenv = require('dotenv-webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyPlugin = require("copy-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { VueLoaderPlugin } = require("vue-loader");

if( (process.env.NODE_ENV != 'production') && (process.env.NODE_ENV != 'development') ){
    process.env.NODE_ENV = 'development';
}
console.log('Common config mode: ' + process.env.NODE_ENV);

let isDev = (process.env.NODE_ENV === 'development');
let cfgDefinePlugin = {
    __VUE_OPTIONS_API__: isDev,
    __VUE_PROD_DEVTOOLS__: isDev
};

let pathStorage = path.resolve(__dirname,'storage');
let pathResources = path.resolve(__dirname,'resources');
let pathPublicRoot = path.resolve(__dirname,"public/");

let cfgWebpack = {
    mode: process.env.NODE_ENV,
    devtool: 'eval-cheap-source-map',
    context: pathResources,
    entry: {
        'assets/main': './js/main.js',
        'assets/styles': ['./css/styles.css'],
        'assets/vue': ['./js/vue/vueInit.js'],
    },
    output:{
        filename:  '[name].js',
        path: pathPublicRoot,
        publicPath: '/assets/',
    },
    resolve: {
        alias: {
            resources: path.resolve(__dirname, 'resources'),
        },
        extensions: ['*',".js", ".vue", ".json",".css",".sass",".scss"],
    },
    module:{
        rules:[
            {
                test: /\.js$/,
                exclude: '/node_modules/',
                use: {
                    loader: 'babel-loader',
                    options: {
                        compact: false,
                        presets: [
                            [
                                '@babel/preset-env',
                                {
                                    targets: {
                                      esmodules: true, //Uncaught ReferenceError: regeneratorRuntime is not defined
                                    },
                                },
                            ]
                        ],
                        plugins: [
                            [
                                "module:fast-async", { "spec": true },
                            ],
                        ]
                    }
                },
                resolve: {
                    fullySpecified: false,
                }
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.s?css$/,
                exclude: path.resolve(__dirname, 'node_modules'),
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: false,
                        }
                    },
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        'postcss-preset-env',
                                        {
                                          // Options
                                        },
                                    ],
                                ],
                            }
                        }
                    },
                    "sass-loader",
                ],
              },
        ]
    },
    plugins:[
        new VueLoaderPlugin(),
        new Dotenv({
            path: './.env',
            //path: `./.env.${env}`
            //safe: true, // load .env.example (defaults to "false" which does not use dotenv-safe)
        }),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns:[
                                          'assets/**',
                                          '!assets/vendor',
                                          '!assets/img',
                                        ]
        }),
        new CopyPlugin({
            patterns: [
                {
                  from: pathStorage+"/app/public/",
                  to: pathPublicRoot,
                  force: true
                },
            ],
          }),
        new MiniCssExtractPlugin({
            //filename: ({ chunk }) => `${chunk.name.replace("/js/", "/css/")}.css`,
            ignoreOrder : false
        }),
        new webpack.ids.HashedModuleIdsPlugin({
            // Options...
        }),
        new webpack.EvalSourceMapDevToolPlugin({
            exclude: ['assets/vendors.js'],
        }),
        new webpack.DefinePlugin(cfgDefinePlugin),
    ],
    optimization: {
        runtimeChunk: {
            name: 'assets/runtime',
        },
        splitChunks: {
          cacheGroups: {
            vendor: {
              test: /[\\/]node_modules[\\/]/,
              name: "assets/vendors",
              priority: -10,
              chunks: "all",
            },
          },
        },
    },
}
module.exports = cfgWebpack;
