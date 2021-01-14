const path = require('path');

module.exports = {
  entry: './assets/js/index.js',
  mode: 'production',
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: 'bundle.js'
  }
};
