/* eslint-env node */
module.exports = {
	plugins: [
		require('postcss-mixins'),
		require('postcss-import-ext-glob'),
		require('postcss-import'),
		require('postcss-simple-vars'),
		require('tailwindcss/nesting'),
		require('tailwindcss'),
	],
}
