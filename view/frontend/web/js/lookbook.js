define([
    'jquery',
    'easing',
    'easypin',
    'jquery/ui'
    ], function ($, easing, easypinShow) {
        'use strict';

        $.widget('magiccart.lookbook', {
            options: {
                lookbookSelector: '.magic-pin-banner-wrap',
            },

            _create: function () {
                this._initLookbook();
            },

            _initLookbook: function () {
                var options = this.options;
                var self = this;
                self.element.find(options.lookbookSelector).each(function() {
                        var _this = $(this);
                        if(!$(_this).hasClass('magic-inited')) {
                            $(_this).addClass('magic-inited');
                            var _init   = $(_this).data('pin');
                            var _img    = $(_this).find('img.magic_pin_image, img.magic_pin_pb_image');
                            var _tpl    = $(_this).find('.magic-easypin-tpl');
                            if(_init && $(_img).length >0) {
                                _img.attr('easypin-id', _img.data('easypin-id'));
                                _tpl.attr('easypin-tpl', '');
                                $(_img).easypinShow({
                                    data: _init,
                                    responsive: true,
                                    popover: { show: false, animate: false },
                                    each: function(index, data) {
                                        return data;
                                    },
                                    error: function() {
                                        
                                    },
                                    success: function() {
                                    }
                                });
                            }
                            
                            $(_img).on('click', function() {
                                $(_this).find('.easypin-popover').hide();
                            });
                            
                            $(document).on('keyup', function(e){
                                if (e.keyCode === 27) $(_img).trigger('click');
                            });
                        }
                    });
            }

        });
    return $.magiccart.lookbook;
});