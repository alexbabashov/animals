

console.log('Start webpack mode: ' + process.env.NODE_ENV);

module.exports = () => {
    let config = require('./webpack.common.js');

    if(process.env.NODE_ENV != 'undefined') {
        const fs = require("fs");
        let path = `./webpack.${process.env.NODE_ENV}.js`;
        if ( fs.existsSync(path) ) {
            const { merge } = require('webpack-merge');
            //const envConfig = require(path);
            config = merge( require('./webpack.common.js'), require(path));
        }
    }

    return config;
};
