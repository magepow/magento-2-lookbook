var config = {
    map: {
        '*': {
            select2: 'magiccart/select2',
        },
    },

	paths: {
		'magiccart/select2'		: 'Magiccart_Lookbook/js/plugins/select2.min',
	},

	shim: {
		'magiccart/select2': {
			deps: ['jquery']
		}
	}

};
