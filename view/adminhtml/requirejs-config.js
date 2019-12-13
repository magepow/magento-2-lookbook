var config = {
    map: {
        '*': {
            lookbook: "Magiccart_Lookbook/js/lookbook",
        },
    },

	paths: {
		'magiccart/easing'		: 'Magiccart_Lookbook/js/plugins/jquery.easing.min',
		'magiccart/easypin'		: 'Magiccart_Lookbook/js/plugins/jquery.easypin.min',
		'magiccart/select2'		: 'Magiccart_Lookbook/js/plugins/select2.min',
	},

	shim: {
		'magiccart/easing': {
			deps: ['jquery']
		},
		'magiccart/select2': {
			deps: ['jquery']
		},
		'magiccart/easypin': {
			deps: ['jquery', 'magiccart/easing']
		},
	}

};
