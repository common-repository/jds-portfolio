<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Handles all admin functionalities of plugin
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */
class Wp_Jds_Admin {

	var $model;
	function __construct () {
				
		global $wp_jds_model;
		$this->model = $wp_jds_model;
	}

	/**
	 * Manage menu/submenu page
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_add_menu_page() {

		// add submenu page for settings
		add_submenu_page( 'edit.php?post_type=jdsportfolio', __('Settings', 'wpjdsp'), __('Settings', 'wpjdsp'), 'manage_options', 'jds-settings', array($this,'wp_jds_settings_page') );
	}

	/**
	 * Include settings/options page
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_settings_page() {
		// include settings page
		include_once( WP_JDS_DIR. '/includes/admin/forms/wp-jds-settings.php' );
	}

	/**
	 * Manage register settings
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_register_settings() {
		register_setting( 'wp_jds_options_settings', 'wp_jds_options', array($this, 'wp_jds_validate_options') );
	}

	/**
	 * Validate plugin options
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_validate_options($input) {

		$input['column']			= isset($input['column']) ? trim($input['column']) : 'col-md-4';
		$input['width']				= isset($input['width']) ? trim($input['width']) : '';
		$input['height']			= isset($input['height']) ? trim($input['height']) : '';
		$input['animation']			= isset($input['animation']) ? trim($input['animation']) : 'slide';
		$input['layer_bg_color']	= isset($input['layer_bg_color']) ? trim($input['layer_bg_color']) : 'grey';

		return $input;
	}

	/**
	 * Adding portfolio meta
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_add_portfolio_meta() {

		add_meta_box( 'wp_jds_meta', __( 'JDs Portfolio Settings', 'wpjdsp' ), array($this, 'wp_jds_add_meta_fields'), 'jdsportfolio' );
	}

	/**
	 * Adding portfolio meta
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_add_meta_fields( $post ) {

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'wp_jds_save_meta_box_data', 'wp_jds_meta_box_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$pf_link = get_post_meta( $post->ID, '_wpjdsp_portfolio_link', true ); ?>

		<table class="form_table">
			<tr>
				<th scope="row">
					<label for="wpjdsp_portfolio_link"><?php echo __('Portfolio Link', 'wpjdsp'); ?></label>
				</th>
				<td>
					<input type="text" id="wpjdsp_portfolio_link" class="regular-text" name="wpjdsp_portfolio_link" value="<?php echo esc_attr($pf_link); ?>" />
				</td>
			</tr>
			<?php do_action( 'wp_jds_meta_fields_after', $post ); ?>
		</table>

	<?php	
	}

	/**
	 * Save portfolio meta options
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function wp_jds_save_portfolio_meta( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['wp_jds_meta_box_nonce'] ) ) {
			return;
		}
		
		$pf_url = isset($_POST['wpjdsp_portfolio_link']) ? sanitize_text_field(trim($_POST['wpjdsp_portfolio_link'])) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, '_wpjdsp_portfolio_link', $pf_url );
	}

	/**
	 * Replace page footer message
	 *
	 * @package JDs Portfolio
	 * @since 2.1
	 */
	public function wp_jds_admin_footer_text( $footer_text ) {

		if ( !current_user_can( 'manage_options' ) ) {
			return $footer_text;
		}

		global $current_screen;
		$screen_arr = array('jdsportfolio_page_jds-settings', 'edit-jdsportfolio', 'jdsportfolio', 'edit-jds_categories', 'jdsportfolio_page_jds-users');

		if( isset($current_screen->id) && in_array($current_screen->id, $screen_arr) ) {
			$footer_text = sprintf( __( 'If you like <strong>JDs Portfolio</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating. A huge thank you in advance!', 'wpjdsp' ), '<a href="https://wordpress.org/support/view/plugin-reviews/jds-portfolio?filter=5#postform" target="_blank" class="wp-jds-rating-link" data-rated="' . esc_attr__( 'Thanks :)', 'wpjdsp' ) . '">', '</a>' );
		}
		return $footer_text;
	}

	/**
	 * Register widgets
	 *
	 * @package JDs Portfolio
	 * @since 2.1
	 */
	public function wp_jds_register_widgets() {

		// Register widget
		register_widget( 'Wp_Jds_Recent_Portfolio' );
	}

	/**
	 * Add shortcode button
	 *
	 * @package JDs Portfolio
	 * @since 2.1.1
	 */
	public function wp_jds_shortcode_button() {

		// Check user capability
		if( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array( $this, 'wp_jds_shortcode_editor_button_script' ) );
			add_filter( 'mce_buttons', array( $this, 'wp_jds_shortcode_editor_register_button' ) );	     
		}
	}

	/**
	 * Register Buttons
	 *
	 * Register the different content locker buttons for the editor
	 *
	 * @package JDs Portfolio
	 * @since 2.1.1
	 */
	public function wp_jds_shortcode_editor_register_button( $buttons ) {	
	
	 	array_push( $buttons, "|", "wpjdsshortcodes" );
	 	return $buttons;	 	
	}

	/**
	 * Editor Pop Up Script
	 *
	 * Adding the needed script for the pop up on the editor
	 *
	 * @package JDs Portfolio
	 * @since 2.1.1
	 */
	public function wp_jds_shortcode_editor_button_script( $plugin_array ) {
	
		// Enqueue tiny mce script
		wp_enqueue_script( 'tinymce' );
		
		// Add button script
	   $plugin_array['wpjdsshortcodes'] = WP_JDS_URL . 'js/wp-jds-buttons.js';
	   
	   return $plugin_array;
	}

	/**
	 * Pop Up On Editor
	 *
	 * Includes the pop up on the WordPress editor
	 *
	 * @package JDs Portfolio
	 * @since 2.1.1
	 */
	public function wp_jds_shortcode_popup_markup() {
		include_once( WP_JDS_ADMIN_DIR . '/forms/wp-jds-popup.php' );
	}

	/**
	 * Manage portfolio post type
	 * custom columns
	 *
	 * @package JDs Portfolio
	 * @since 2.1.4
	 */
	public function wp_jds_portfolio_image_column( $columns ) {

		$new_columns = array(
			'cb' => $columns['cb'],
			'image' => esc_attr( 'Image', 'wpjdsp' ),
			'title' => $columns['title'],
			'taxonomy-jds_categories' => $columns['taxonomy-jds_categories'],
			'date' => $columns['date'],

		);

		return $new_columns;
	}

	/**
	 * Manage portfolio post type
	 * custom columns content
	 *
	 * @package JDs Portfolio
	 * @since 2.1.4
	 */
	function wp_jds_portfolio_image_column_content( $column, $post_id ) {
		switch ( $column ) {
        	case 'image':
        		echo get_the_post_thumbnail( $post_id, array('70', '70'), array('style' => 'border-radius: 4px;') );
        	break;
        }
	}

	/**
	 * Adding Hooks
	 *
	 * @package JDs Portfolio
	 * @since 2.0.0
	 */
	public function add_hooks() {

		// Add submenu page for settings
		add_action( 'admin_menu', array($this, 'wp_jds_add_menu_page') );

		// register portfolio options
		add_action( 'admin_init', array($this, 'wp_jds_register_settings') );
		
		// add metaboxes in portfolio
		add_action( 'add_meta_boxes', array($this, 'wp_jds_add_portfolio_meta') );

		// Save meta box options
		add_action( 'save_post', array($this, 'wp_jds_save_portfolio_meta') );

		// Add filter for change footer text
		add_filter( 'admin_footer_text', array($this, 'wp_jds_admin_footer_text') );

		// Add/Register Widgets
		add_action( 'widgets_init', array($this, 'wp_jds_register_widgets') );

		// Add shortcode button
		add_action( 'init', array($this, 'wp_jds_shortcode_button') );

		// mark up for popup
		add_action( 'admin_footer-post.php', array( $this, 'wp_jds_shortcode_popup_markup' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'wp_jds_shortcode_popup_markup' ) );
		add_action( 'manage_jdsportfolio_posts_columns', array($this, 'wp_jds_portfolio_image_column') );
		add_action( 'manage_jdsportfolio_posts_custom_column', array($this, 'wp_jds_portfolio_image_column_content'), 10, 2 );
	}
}