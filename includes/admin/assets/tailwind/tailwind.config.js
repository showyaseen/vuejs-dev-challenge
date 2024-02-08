module.exports = {
	prefix: 'vuejsdevchallenge-',
	content: [
		// Ensure changes to PHP files and trigger a rebuild.
		"./admin/views/**/*.php",
		"./admin/assets/js/app/**/*.{js,jsx}",
	],
	corePlugins: {
		preflight: false,
	},
	theme: {
		colors: {
			'alabaster': '#F8F8F8',
			'black': '#000000',
			'blue-gem': '#3C15B4',
			'cerulean': '#00A0D2',
			'chateau-green': '#3CAF66',
			'concrete': '#F2F2F2',
			'cornflower-blue': '#697BF8',
			'current': 'currentColor',
			'cyprus': '#003742',
			'dodger-blue': '#4C8FFA',
			'emperor': '#555555',
			'equator': '#DDB861',
			'gallery': '#EFEFEF',
			'gray': {
				200: '#E5E5E5',
				300: '#DDDDDD',
				400: '#888888',
				500: '#888888',
			},
			'green': {
				DEFAULT: '#46B450',
			},
			'iron': '#DEDFE0',
			'orange': {
				400: '#FB83B3',
				DEFAULT: '#FF9500',
			},
			'mercury': '#E3E3E3',
			'pink': {
				DEFAULT: '#E6186B',
				400: '#FB83B3',
				500: '#E60FA1',
				600: '#EC2C79',
				800: '#A80A4A',
				950: '#640129',
			},
			'purple': {
				'dark': '#28088D',
				'darkest': '#1A0361',
				DEFAULT: '#4B1CDD',
				'light': '#5B2EE4',
				'lightest': '#A084F7',
				300: '#BEADF3',
				900: '#281F2E',
			},
			'red': {
				DEFAULT: '#E81819',
			},
			'rob-roy': ' #EBC876',
			'rolling-stone': '#767779',
			'seashell': '#F1F1F1',
			'shuttle-gray': '#555D66',
			'silver': '#CCCCCC',
			'transparent': 'transparent',
			'trout': '#4F575F',
			'tundora': '#444444',
			'turquoise': '#27CCC0',
			'white': '#FFFFFF',
			'white-ice': '#EEFDF4',
			'wild-sand': '#F5F5F5',
		},
		// Extend the default Tailwind theme.
		extend: {
			screens: {
				'sm': '640px',
				'md': '783px',
			},
			backgroundImage: {
				'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
				'gradient-135': 'linear-gradient(135deg, var(--tw-gradient-stops))',
				'gradient-235': 'linear-gradient(235deg, var(--tw-gradient-stops))',
			},
			boxShadow: {
				'dropdown': '0 0 10px 0 var(--tw-shadow-color)',
				'cardfocus': 'inset 1px 1px 5px 0 rgba(0,0,0,0.15), 0 0 10px 0 rgba(75,27,226,0.16)',
				'black/[.08]': '0 0 10px 0 rgba(0,0,0,0.08)',
			},
			fontFamily: {
				'roboto': 'var(--wp--preset--font-family--roboto)',
			},
			margin: {
				'1px': '1px',
			},
			opacity: {
				'8': '.08',
			}
		},
	},
};
