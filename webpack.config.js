const path = require('path');

module.exports = {
  entry: './src/index.js', // Punto de entrada de tu aplicación
  output: {
    path: path.resolve(__dirname, 'build'), // La carpeta de salida de los archivos compilados
    filename: 'mi-react-app.js', // El nombre del archivo JavaScript compilado
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx|ts|tsx)$/, // Para archivos .js, .jsx, .ts, y .tsx
        exclude: /node_modules/, // Excluye la carpeta node_modules
        use: {
          loader: 'babel-loader', // Usa babel-loader para transpilar los archivos
          options: {
            presets: ['@babel/preset-react', '@babel/preset-typescript'], // Presets para React y TypeScript
          },
        },
      },
      {
        test: /\.css$/, // Para archivos .css
        use: [
          'style-loader', // Inyecta CSS en el DOM
          'css-loader', // Interpreta @import y url() como import/require()
        ],
      },
      // Regla para ts-loader específicamente para archivos TypeScript
      {
        test: /\.tsx?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
    ],
  },
  resolve: {
    extensions: ['.tsx', '.ts', '.js', '.jsx'], // Extensiones que Webpack procesará
  },
};


