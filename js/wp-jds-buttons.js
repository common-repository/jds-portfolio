// JavaScript Document
jQuery(document).ready(function($) {

	// Start Shortcodes Click
	(function() {
	    tinymce.create('tinymce.plugins.wpjdsshortcodes', {
	        init : function(ed, url) {
	        	
	            ed.addButton('wpjdsshortcodes', {
	                title : 'JDs Portfolio Shortcodes',
	                image : url+'/jds-icon.png',
	                onclick : function() {

	                	// Hide errors
	                	jQuery('.wp-jds-popup-error').hide();

	                	// Fade in popups
						jQuery('.wp-jds-popup-overlay').fadeIn();
	                    jQuery('.wp-jds-popup-content').fadeIn();
	 				}
	            });
	        },
	        createControl : function(n, cm) {
	            return null;
	        },
	    });
	 
	    tinymce.PluginManager.add('wpjdsshortcodes', tinymce.plugins.wpjdsshortcodes);
	})();

	jQuery( document ).on('click', '#wp_jds_insert_shortcode', function () {
		
		var shortcode = jQuery('#wp_jds_shortcode_select').val();
		var shortcodestr = '';

		if(shortcode == '') {
			jQuery('.wp-jds-popup-error').fadeIn();
			return false;
		} else {

			jQuery('.wp-jds-popup-error').hide();
				
			switch(shortcode) {
				case 'jds_portfolio' :
					
					var orderby = jQuery('#jds_port_orderby').val();
					var order 	= jQuery('#jds_port_order').val();

					shortcodestr += '[JDs_portfolio';

					if( orderby != '' ) {
						shortcodestr += ' orderby="'+orderby+'"';						
					}

					if( orderby != '' ) {
						shortcodestr += ' order="'+order+'"';						
					}

					shortcodestr += '][/JDs_portfolio]';
					break;

				default:
					break;
			}
		}
			 	
	 	//send_to_editor(str);
        tinymce.get('content').execCommand('mceInsertContent',false, shortcodestr);

  		jQuery('.wp-jds-popup-overlay').fadeOut();
		jQuery('.wp-jds-popup-content').fadeOut();
	});

	// Hide adn show shortcode options on selects shortcode
	jQuery('#wp_jds_shortcode_select').change(function() {
		
		var shortcode = jQuery(this).val();
		
		// Hide all the boxes
		jQuery('.wp-jds-shortcodes-options').hide();

		switch(shortcode) {
			case 'jds_portfolio' 	:
				jQuery('#wp_jds_portfolio_short').show();
				break;
								
			default:
				break;
		}
	});

	// Close popup
	jQuery( document ).on('click', '.wp-jds-popup-close-button, .wp-jds-popup-overlay', function () {
		jQuery('.wp-jds-popup-overlay').fadeOut();
		jQuery('.wp-jds-popup-content').fadeOut();
	});
	
});