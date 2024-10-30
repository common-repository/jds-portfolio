<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortocde UI
 *
 * This is the code for the pop up editor.
 *
 * @package JDs Portfolio
 * @since 2.1.1
 */
?>

<div class="wp-jds-popup-content">

	<div class="wp-jds-header-popup">
		<div class="wp-jds-popup-header-title"><?php _e( 'Add a Shortcodes', 'wpjdsp' );?></div>
		<div class="wp-jds-popup-close">
			<a href="javascript:void(0);" class="wp-jds-popup-close-button">
				<img src="<?php echo WP_JDS_URL;?>/images/popup_close.png" />
			</a>
		</div>
	</div>

	<div class="wp-jds-popup-error"><?php _e( 'Select a Shortcode', 'wpjdsp' );?></div>
	<div class="wp-jds-popup-container">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label><?php _e( 'Select a Shortcode', 'wpjdsp' );?></label>		
					</th>
					<td>
						<select id="wp_jds_shortcode_select">				
							<option value=""><?php _e( '--Select Shortcode--', 'wpjdsp' );?></option>
							<option value="jds_portfolio"><?php _e( 'JDs Portfolio', 'wpjdsp' );?></option>
						</select>		
					</td>
				</tr>
			</tbody>
		</table>
	
		<div id="wp_jds_portfolio_short" class="wp-jds-shortcodes-options">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="jds_port_orderby"><?php _e( 'Order By :', 'wpjdsp' );?></label>		
						</th>
						<td>
							<select id="jds_port_orderby">
								<option value=""><?php _e('-- Select Order By --', 'wpjdsp'); ?></option>
								<option value="title"><?php _e('Title', 'wpjdsp'); ?></option>
								<option value="date"><?php _e('Date', 'wpjdsp'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="jds_port_order"><?php _e( 'Order :', 'wpjdsp' );?></label>
						</th>
						<td>
							<select id="jds_port_order">
								<option value=""><?php _e('-- Select Order --', 'wpjdsp'); ?></option>
								<option value="ASC"><?php _e('Ascending', 'wpjdsp'); ?></option>
								<option value="DESC"><?php _e('Descending', 'wpjdsp'); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div><!--.wp-jds-popup-box-type-->

		<!-- Add insert shortcode button -->
		<div id="wp_jds_insert_container">
			<input type="button" class="button-secondary" id="wp_jds_insert_shortcode" value="<?php _e( 'Insert Shortcode', 'wpjdsp' ); ?>">
		</div>
	</div>
	
</div><!--.wp-jds-popup-content-->
<div class="wp-jds-popup-overlay" ></div><!--.wp-jds-popup-overlay-->