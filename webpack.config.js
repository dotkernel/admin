/*
 * Webpack is used to compile and minify/uglify JS and Sass.
 * Since this will nuke some of the directories inside the public directory,
 * you should no longer manually add images etc. to the public folder.
 * We have set up a configuration that will automatically copy any image
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

const CopyWebpackPlugin = require('copy-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require('terser-webpack-plugin');



// Prepare plugin to extract styles into a css file
// instead of a javascript file

// dynamically build webpack entries based on registered app modules
let entries = {
    app: []
};
let copyImages = [];
let rules = generateBaseRules();


/*
 * Run the setup to prepare
 * each module for asset transfer.
 *
 */
appModules.forEach(function (appModule) {
    if (appModule.js === true) {
        entries.app.push(appModule.assets_path + '/js/index.js')
    }
    if (appModule.styles === true) {
        entries.app.push(appModule.assets_path + '/scss/index.scss')
    }
    if (appModule.images === true) {
        copyImages.push({ from: appModule.assets_path + '/images', to: 'images/' + appModule.name });

        rules.push({
            test: /\.(png|jpg|gif)$/,
            include: [
                path.resolve(__dirname, './src/' + appModule.assets_path)
            ],
            use: [
                {loader: 'file-loader'}
            ],
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
        filename: './js/[name].js',
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
        new MiniCssExtractPlugin({
            filename: './css/[name].css'
        }),
        // Nuke the assets folder
        // This will only be run on production
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: pathsToNuke,
            verbose: process.env.NODE_ENV !== "development",
            dry: process.env.NODE_ENV === "development"
        }),

        // Copy images from the source folder to the
        // destination folder
        new CopyWebpackPlugin({
            patterns: copyImages
        }),
    ],
    optimization: {
        minimizer: [new TerserPlugin({
            extractComments: false,
        })],
    },
};

/*
 * Generate base rule-set to be manipulated
 * in the forEach loop
 */
function generateBaseRules()
{
    return [
        {
            test: require.resolve("jquery"),
            loader: "expose-loader",
            options: {
                exposes: ["$", "jQuery"],
            },
        },
        {
            test: /\.js$/,
            exclude: [/node_modules/],
            use: [{
                loader: 'babel-loader',
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
            test: /\.(css|sass|scss)$/,
            use: [
                MiniCssExtractPlugin.loader,
                {
                    loader: 'css-loader',
                    options: {
                        url: true,
                        sourceMap: process.env.NODE_ENV === "development"
                    }
                },
                {
                    loader: 'sass-loader',
                    options: {
                        sourceMap: true
                    }
                }
            ]
        },
        {
            test: /\.(png|jpg|gif|jpeg)$/,
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