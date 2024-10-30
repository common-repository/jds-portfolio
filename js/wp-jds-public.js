jQuery(document).ready(function($) {
	
	// initialize prettyphoto
	$("a[rel^='prettyPhoto']").prettyPhoto({
											theme:'dark_rounded'
											});

	// mixit initialize
	jQuery('#wp_jds_portfolio_container').mixItUp({
		animation: {
			duration: 400,
			effects: 'fade translateZ(-360px) stagger(34ms)',
			easing: 'ease'
		}	
	});
	
});