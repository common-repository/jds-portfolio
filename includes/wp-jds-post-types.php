<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Post Type Functions
 *
 * Handles all custom post types
 * 
 * @package JDs Portfolio
 * @since 2.0.0 
 */

/**
 * Setup Follow Post PostTypes
 *
 * Registers the follow post posttypes
 * 
 * @package JDs Portfolio
 * @since 2.0.0 
 */
function wp_jds_register_post_types() {
	
	//follow post - post type
	$portfolio_labels = array(
		'name'				=> __('Portfolios','wpjdsp'),
		'singular_name'		=> __('Portfolio','wpjdsp'),
		'add_new' 			=> __('Add New','wpjdsp'),
		'add_new_item'		=> __('Add New Portfolio','wpjdsp'),
		'edit_item'			=> __('Edit Portfolio','wpjdsp'),
		'new_item'			=> __('New Portfolio','wpjdsp'),
		'all_items'			=> __('All Portfolios','wpjdsp'),
		'view_item'			=> __('View Portfolio','wpjdsp'),
		'search_items'		=> __('Search portfolios','wpjdsp'),
		'not_found'			=> __('No portfolios found','wpjdsp'),
		'not_found_in_trash'=> __('No follow portfolios in Trash','wpjdsp'),
		'parent_item_colon'	=> __('NParent portfolio : ','wpjdsp'),
		'menu_name'			=> __('JDs Portfolio','wpjdsp'),
	);
	$portfolio_args = array(
		'labels' 				=> $portfolio_labels,
		'public' 				=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'page',
		'can_export' 			=> true,
		'hierarchical' 			=> false,
		'menu_icon'				=> 'dashicons-schedule',
		'supports'				=> array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
	    'rewrite'				=> array(
										'slug'				=> _x('portfolio', 'slug', 'wpjdsp'),
										'with_front'		=> false,
										'hierarchical'		=> true,
									),
	);
	
	//register follow posts post type
	register_post_type( WP_JDS_POST_TYPE, $portfolio_args );

	// register texonomy
	 $labels = array( 
        'name' => _x( 'portfolio categories', 'wpjdsp' ),
        'singular_name' => _x( 'Portfolio Category', 'wpjdsp' ),
        'search_items' => _x( 'Search portfolio categories', 'wpjdsp' ),
        'popular_items' => _x( 'Popular portfolio categories', 'wpjdsp' ),
        'all_items' => _x( 'All Portfolio categories', 'wpjdsp' ),
        'parent_item' => _x( 'Parent Portfolio Category', 'wpjdsp' ),
        'parent_item_colon' => _x( 'Parent Portfolio Category:', 'wpjdsp' ),
        'edit_item' => _x( 'Edit Portfolio Category', 'wpjdsp' ),
        'update_item' => _x( 'Update Portfolio Category', 'wpjdsp' ),
        'add_new_item' => _x( 'Add New Portfolio Category', 'wpjdsp' ),
        'new_item_name' => _x( 'New Portfolio Category', 'wpjdsp' ),
        'separate_items_with_commas' => _x( 'Separate portfolio categories with commas', 'wpjdsp' ),
        'add_or_remove_items' => _x( 'Add or remove portfolio categories', 'wpjdsp' ),
        'choose_from_most_used' => _x( 'Choose from the most used portfolio categories', 'wpjdsp' ),
        'menu_name' => _x( 'Portfolio Categories', 'wpjdsp' ),
	);

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,

        'rewrite' => array('with_front' => false, 'hierarchical' => true),
        'query_var' => true
    );

    // register taxonomy
    register_taxonomy( 'jds_categories', WP_JDS_POST_TYPE, $args );

	//IMP Call of Function
	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();

}

//register custom post type
add_action( 'init', 'wp_jds_register_post_types', 100 ); // we need to keep priority 100, because we need to execute this init action after all other init action called.
?>