/*
 * Webpack is used to compile and minify/uglify JS and Sass.
 * Since this will nuke some of the directories inside the public directory,
 * you should no longer manually add images etc. to the public folder.
 * We have setup a configuration that will automatically copy any image
 * from the images folder here to public/images/{moduleName}.
 *
 * so please, DO NOT MANUALLY ADD ASSETS TO THE PUBLIC DIRECTORY!
 */

"use strict";


// Every module that publishes assets should
// be registered below
const appModules = [{
    name: 'app',
    assets_path: './App/assets',
    styles: true,
    js: true,
    images: true
}];


// These paths will be completely
// rebuilt before every commit.
// DO NOT MANUALLY ADD ANYTHING
// TO THESE DIRECTORIES
const pathsToNuke = [
    './public/js',
    './public/css',
    './public/fonts',
    './public/images'
];


/*
 *
 * Do not touch anything below here,
 * unless you know what you are doing.
 *
 * The only configuration you should
 * need to touch will be above this comment.
 *
 */

// Include npm modules
const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require("extract-text-webpack-plugin");


// Prepare plugin to extract styles into a css file
// instead of a javascript file
const extractStyles = new ExtractTextPlugin({
    filename: "[name]",
});

// dynamically build webpack entries based on registered app modules
let entries = {};
let copyImages = [];
let rules = generateBaseRules();


/*
 * Run the setup to prepare
 * each module for asset transfer.
 *
 */
appModules.forEach(function (appModule) {
    if (appModule.js === true) {
        entries['js/' + appModule.name + '.js'] = appModule.assets_path + '/js/index.js';
    }
    if (appModule.styles === true) {
        entries['css/' + appModule.name + '.css'] = appModule.assets_path + '/scss/index.scss';
    }
    if (appModule.images === true) {
        copyImages.push({from: appModule.assets_path + '/images', to: './images/' + appModule.name});

        rules.push({
            test: /\.(png|svg|jpg|gif)$/,
            include: [
                path.resolve(__dirname, './src/' + appModule.assets_path)
            ],
            use: [
                // As SVG may count as both font or image
                // we will not treat any file in a folder
                // with the name of font(s) as an image
                'file-loader?name=images/' + appModule.name + '/[name].[ext]'
            ]
        })
    }
});

/*
 * Lastly, export the final module
 * and the assets
 */
module.exports = {
    // This is the basepath for Webpack to look for source files
    // if you need to include modules outside of the App module,
    // move the "/App/assets" portion of the context onto the two
    // strings below, so it becomes "./App/assets/js/app.js" etc.
    context: path.resolve(__dirname, './src'),

    // These are our entry files, this is the files Webpack will use
    // when looking for Sass and Javascript to compile.
    // The format is "DESTINATION": "SOURCE", and each path is
    // relative to the output path and the context respectively.
    entry: entries,

    // The Output is where Webpack will export our files to
    // the filename will be resolved to the key in the entry object above.
    // The publicPath is what it'll rewrite css relative urls to use.
    // The path is where it'll save files too
    output: {
        filename: '[name]',
        publicPath: '/', // URL root
        path: path.resolve(__dirname, './public/') // Save-file root
    },

    // This is all the available file-loaders, feel free to append your own.
    // IMPORTANT NOTE: loaders are evaluated in REVERSE-ARRAY ORDER,
    // that means that they move from the end and towards the start.
    module: {
        rules: rules,
    },

    stats: {
        children: false
    },

    plugins: [
        extractStyles,

        // Nuke the assets folder
        // This will only be run on production
        new CleanWebpackPlugin(pathsToNuke, {
            verbose: process.env.NODE_ENV !== "development",
            dry: process.env.NODE_ENV === "development"
        }),

        // Copy images from the source folder to the
        // destination folder
        new CopyWebpackPlugin(copyImages),
    ]
};

/*
 * Generate base rule-set to be manipulated
 * in the forEach loop
 */
function generateBaseRules()
{
    return [
        {
            test: /\.js$/,
            exclude: [/node_modules/],
            use: [{
                loader: 'babel-loader',
                options: {
                    presets: ['babel-preset-env'],
                    comments: process.env.NODE_ENV === "development",
                    minified: process.env.NODE_ENV === "development",
                    sourceMaps: process.env.NODE_ENV === "development"
                },
            }],
        },
        {
            test: /\.tsx?$/,
            exclude: [/node_modules/],
            use: [{
                loader: 'ts-loader',
                options: {
                    sourceMap: process.env.NODE_ENV === "development",
                }
            }]
        },
        {
            test: /\.scss$/,
            use: extractStyles.extract({
                use: [{
                    loader: "css-loader",
                    options: {
                        url: true,
                        sourceMap: process.env.NODE_ENV === "development"
                    }
                }, {
                    loader: 'postcss-loader',
                    options: {
                        sourceMap: process.env.NODE_ENV === "development",
                        plugins() {
                            return [autoprefixer]
                        }
                    }
                }, {
                    loader: "resolve-url-loader"
                }, {
                    loader: "sass-loader",
                    options: {
                        sourceMap: true
                    }
                }],
                fallback: "style-loader"
            })
        },
        {
            test: /\.(png|jpg|gif)$/,
            include: [
                path.resolve(__dirname, 'node_modules')
            ],
            use: [
                'file-loader?name=images/[name].[ext]'
            ]
        },
        {
            test: /\.(woff|woff2|eot|ttf|otf|svg)$/,
            exclude: [/images?|img/],
            use: [
                // As SVG may count as both font or image
                // we will not treat any file in a folder
                // with the name image(s) or img as a font
                'file-loader?name=fonts/[name].[ext]'
            ]
        }
    ];
}
