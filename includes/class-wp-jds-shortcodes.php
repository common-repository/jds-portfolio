<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes Class
 *
 * Handles shortcodes functionality of plugin
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
class Wp_Jds_Shortcodes {
	
	public $model;
	
	public function __construct(){
		
		global $wp_jds_model;
		
		$this->model = $wp_jds_model;
	}

	/**
	 * Adding hooks for calling shortcodes.
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 **/
	public function wp_jds_portfolio_shortcode($atts, $content) {

		extract( shortcode_atts( array(
			'user'		=> '',
			'orderby'	=> '',
			'order'		=> 'ASC',
		), $atts ) );

		global $wp_jds_options;

		$args = array(
			'post_type'			=> WP_JDS_POST_TYPE,
			'posts_per_page'	=> -1,
			'fields'			=> 'ids',
		);

		// Add order by portfolios
		if( !empty($orderby) ) {

			// add order by arguments
			$args['orderby']	= $orderby;
			$args['order']		= $order;
		}
		
		// manage name wise posts
		if( !empty($user) ) {

			$args['meta_query'] = array(
			array(
					'key'     => '_wpjdsp_portfolio_user',
					'value'   => $user,
					'compare' => '='
				)
			);
		}

		$portfolio_ids = get_posts($args);
		$terms_list = $this->model->wp_jds_get_terms_by_post_ids($portfolio_ids);

		$column			= !empty($wp_jds_options['column']) ? $wp_jds_options['column'] : 'col-md-4';
		$width			= !empty($wp_jds_options['width']) ? $wp_jds_options['width'] : '100%';
		$height			= !empty($wp_jds_options['height']) ? $wp_jds_options['height'] : 'auto';
		$animation		= !empty($wp_jds_options['animation']) ? $wp_jds_options['animation'] : 'slide';
		$layer_bg_color	= !empty($wp_jds_options['layer_bg_color']) ? $wp_jds_options['layer_bg_color'] : 'purpal';

		ob_start(); ?>

		<div class="wp_jds_portfolio">
	
		    <div class="wp_jds_category">
				<button class="filter" data-filter="all">All</button>
		        <?php 
		        foreach ($terms_list as $key => $value) { ?>
		        	<button class="filter" data-filter=".<?php echo $key; ?>"><?php echo $value; ?></button>
		        <?php }  ?>
			</div><!-- JDs category -->
    
		    <div id="wp_jds_portfolio_container" class="row">
		    	<?php 
				foreach ($portfolio_ids as $portfolio_id) { 

					$classes_str = $this->model->wp_jds_get_portfolio_classes($portfolio_id); 

					$project_url = get_post_meta( $portfolio_id, '_wpjdsp_portfolio_link', true ); 

					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($portfolio_id), 'full' );

					//$image_url = $image_url['0'];
					?>
		        
		        	<div class="<?php echo $column ?> mix <?php echo $classes_str; ?>" >
		        		<div class="wp_jds_portfolio_item">
		                	<img class="wp_jds_portfolio_item_img" src="<?php echo $image_url[0] ;?>" 
		                    style="width: <?php echo $width; ?>; 
		                    height: <?php echo $height; ?>;" alt="JDs Portfolio Image" />
		                
		                	<div class="wp_jds_portfolio_overlay <?php echo $layer_bg_color ." ".$animation; ?>">
		                		<div class="wp_jds_portfolio_overlay_link">
		                        	<div class="wp_jds_portfolio_overlay_info">
		                            	<h5><?php echo get_the_title($portfolio_id); ?></h5>
		                    			<a href="<?php echo $image_url[0] ;?>" rel="prettyPhoto">
		                            		<i class="fa fa-search"></i></a>

		                            		<?php
		                            		echo !empty($project_url) ? '<a href="'.$project_url.'"><i class="fa fa-link"></i></a>' : ''; ?>
		                            </div>
		                    	</div>
		                	</div>
		                </div>
		       		</div><!-- JDs Portfolio Item -->
		        
				<?php } ?>
				
		    </div><!-- row -->    
		</div><!-- JDs Portfolio -->
		<div class="clear"></div>
		
		<?php 
		$content .= ob_get_clean();
		return $content;
	}

	/**
	 * Adding Hooks
	 *
	 * Adding hooks for calling shortcodes.
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 **/
	public function add_hooks() {

		// Add shortcode for manege portfolio
		add_shortcode( 'JDs_portfolio', array($this,'wp_jds_portfolio_shortcode') );
	}
}