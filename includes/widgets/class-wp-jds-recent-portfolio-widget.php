<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Recent Portfolio Widget
 *
 * @package JDs Portfolio
 * @since 2.1
 */
class Wp_Jds_Recent_Portfolio extends WP_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		
		WP_Widget::__construct( 'wp_jds_recent_portfolio_widget', __( 'JDs - Recent Portfolio', 'wpjdsp' ),
								array( 'description' =>__( 'Display a list of your most recent portfolios on your site.', 'wpjdsp' ) ) );
	}

	/**
	 * widget function.
	 */
	 public function widget( $args, $instance ) {
		
	 	// Get instance
		$title	= !empty( $instance['title'] ) ? $instance['title'] : __('Recent Portfolios', 'wpjdsp');
		$number	= !empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;

		$post_args = array(
						'post_type' => WP_JDS_POST_TYPE,
						'posts_per_page' => $number,
					);

		$portfolios = get_posts($post_args);

		ob_start();
		
		echo $args['before_widget'];

		if ( !empty($title) ) {
			echo $args['before_title'] . apply_filters('wp_jds_widget_recent_portfolio_title', $title). $args['after_title'];
		} ?>
		
		<div class="wp_jds_widget_containet">
			<ul class="wp_jds_recent_portfolio_list">
				<?php foreach ($portfolios as $key => $value) { ?>
					<li>
						<?php echo get_the_post_thumbnail( $value->ID, 'thumbnail' ); ?>
						<h3><?php echo $value->post_title; ?></h3>

						<?php 
						$excerpt = substr( wp_trim_words(strip_shortcodes($value->post_content, 5)), 0, 45 );
						echo '<p>'.$excerpt.'...</p>'; ?>
					</li>
				<?php } ?>
			</ul><!-- End of .wp_jds_recent_portfolio_list -->
		</div><!-- End of .wp_jds_widget_containet -->
		
		<?php
		echo $args['after_widget'];
		
		$content = ob_get_clean();

		echo $content;
	}

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		// Get instance
		$title	= !empty( $instance['title'] ) ? $instance['title'] : __('Recent Portfolios', 'wpjdsp');
		$number	= !empty( $instance['number'] ) ? absint( $instance['number'] ) : 3; ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Portfolios:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" min="1" max="" value="<?php echo esc_attr( $number ); ?>">
		</p>

		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title']	= ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number']	= ( !empty( $new_instance['number'] ) ) ? $new_instance['number'] : '';
		
		return $instance;
	}
}