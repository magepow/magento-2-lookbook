var config = {

	map: {
		'*': {
			'easing': 'magiccart/easing',
			'easypin': 'magiccart/easypin'
		}
	},

	paths: {
		'magiccart/easing': 'Magiccart_Lookbook/js/plugin/jquery.easing.min',
		'magiccart/easypin': 'Magiccart_Lookbook/js/plugin/jquery.easypin.min'
	},

	shim: {
		'magiccart/easing': {
			deps: ['jquery']
		},
		'magiccart/easypin': {
			deps: ['jquery', 'easing']
		}
	}

};
