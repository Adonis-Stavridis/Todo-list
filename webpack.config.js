const path = require('path');

module.exports = {
  entry: './Web/assets/js/index.js',
  mode: 'production',
  output: {
    path: path.resolve(__dirname, 'Web/public/js'),
    filename: 'bundle.js'
  }
};
