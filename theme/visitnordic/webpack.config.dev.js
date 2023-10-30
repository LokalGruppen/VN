var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    devtool: 'source-map',
    entry: [
        'main.js'
    ],
    output: {
        path: path.join(__dirname, 'dist/'),
        filename: 'bundle.js'
    },
    resolve: {
        modules: [path.resolve('assets/js'), 'node_modules']
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            //'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default']
        }),
        new ExtractTextPlugin({
            filename: "bundle.css",
            allChunks: true
        })

    ],
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                include: path.join(__dirname, 'assets/js'),
                exclude: [
                    /node_modules\/slick-carousel/
                ]
            },
            {
                test: /\.css/,
                loader: ExtractTextPlugin.extract({
                    //fallbackLoader: "style-loader",
                    loader: ['css-loader?sourceMap', 'postcss-loader'].join('!')
                })
            },
            {
                test: /\.scss/,
                loader: ExtractTextPlugin.extract({
                    //fallbackLoader: "style-loader",
                    loader: ['css-loader?sourceMap', 'postcss-loader', 'sass-loader?sourceMap'].join('!')
                })
            },
            {
                test: /\.(eot|svg|ttf|otf|woff|woff2)$/,
                loader: 'file-loader?name=fonts/[name].[ext]'
            },
            {
                test: /\.(png|jpg|gif)$/,
                loader: 'file-loader?name=images/[name].[ext]!img-loader?optimize&optimizationLevel=2&progressive=true'
            }
        ]
    }
};