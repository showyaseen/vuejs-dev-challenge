module.exports = {
	// prefix: 'ytaha-',
	content: [
		// Ensure changes to PHP files and trigger a rebuild.
		"./includes/admin/views/**/*.php",
		"./includes/admin/assets/js/**/*.{js,vue}"
	],
	corePlugins: {
		preflight: false,
	},
};
