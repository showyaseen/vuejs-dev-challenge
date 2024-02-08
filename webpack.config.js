const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    entry: {
        app: './includes/admin/assets/js/app.js',
    },
    output: {
        publicPath: '/wp-content/plugins/vuejs-dev-challenge/',
        filename: 'includes/public/dist/[name].js',
        path: path.resolve(__dirname),
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader',
                ],
            },
        ],
    },
    plugins: [new VueLoaderPlugin()],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm-bundler.js', // Use the bundler version for Vue 3
        },
        extensions: ['*', '.js', '.vue', '.json'],
    },
};
