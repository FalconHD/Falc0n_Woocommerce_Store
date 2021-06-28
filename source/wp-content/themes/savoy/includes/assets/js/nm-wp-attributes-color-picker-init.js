(function($) {
	
	'use strict';
    
	$(function() { // Doc ready
        // Get product-attribute form container
		var $paFormContainer = ( $('#addtag').length ) ? $('#addtag') : $('#edittag');
        // Init color picker
        $paFormContainer.find('.nm_pa_color-picker').wpColorPicker();
	});
    
} (jQuery));