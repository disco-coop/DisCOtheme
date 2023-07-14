import json from '@rollup/plugin-json';
import terser from '@rollup/plugin-terser';
import buble from '@rollup/plugin-buble';
import scss from 'rollup-plugin-scss'

export default {
  watch: {
    chokidar: {
      usePolling: true
    }
  },
  input: 'src/app.js',
  output: [{
    file: 'dist/bundle.js',
    format: 'cjs'
  }, {
    file: 'dist/bundle.min.js',
    format: 'iife',
    name: 'version',
    plugins: [terser()]
  }],
  plugins: [
    json(),
    // babel({babelHelpers: 'bundled'}),
    buble({
      exclude: '**/*.{css,sass,scss}'
    }),
    scss({
      // outputStyle: 'compressed',
      fileName: 'bundle.css',
      verbose: true,
    }) // will output compiled styles to "bundle.css"
  ]
};
