var config = {
	map: {
        '*': {
            magiccartLookbook: 'Magiccart_Lookbook/js/lookbook'
        }
    },
	paths: {
		'magiccart/easypin'		: 'Magiccart_Lookbook/js/jquery.easypin.min',
	},
	shim: {
		'magiccart/easypin': {
			deps: ['jquery', 'magiccart/easing']
		},
	}
};
