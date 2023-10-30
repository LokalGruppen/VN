var config = require('./webpack.config.dev');
var webpack = require('webpack');

config = Object.assign({}, config, {
    devtool: 'source-map',
    plugins: [
        ...config.plugins,
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': "'production'"
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true,
            debug: false
        }),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            },
            output: {
                comments: false
            },
            sourceMap: true
        })
    ]
});

module.exports = config;