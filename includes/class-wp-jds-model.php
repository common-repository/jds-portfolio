<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Model Class
 *
 * Handles generic plugin functionality.
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
class Wp_Jds_Model {

	public function __construct () {
				
	}

	/**
	 * Get terms by post ids
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_get_terms_by_post_ids($post_ids) {

		$trems_arr = array();
		$args = array('fields' => 'ids');

		if( !empty($post_ids) ) {
			foreach ($post_ids as $key => $value) {
				
				// get terms id
				$terms = wp_get_post_terms($value, 'jds_categories');

				// manage terms
				foreach ($terms as $term) {
					$trems_arr[$term->slug] = $term->name;
				}
				
			}
		}
		return $trems_arr;
	}

	/**
	 * Get terms by post ids
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	function wp_jds_get_portfolio_classes($post_id = null) {
	    
		$term_str = '';
	    if ($post_id === null)
	        return;
	    $terms = wp_get_post_terms($post_id, 'jds_categories');
	    foreach ($terms as $term) {
	        $term_str .= $term->slug." ";
	    }

		//$term_str = ltrim($term_str);
		$term_str = trim($term_str);

		return $term_str;
	}

}