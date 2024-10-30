<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 *
 * The code for the plugins settings page
 *
 * @package JDs Portfolio
 * @since 2.0.0
 */

global $wp_jds_options
?>

<div class="wrap">
	<br>
	<h2><?php _e( 'JDs Portfolio - Settings', 'wpjdsp' ); ?></h2>

	<!-- beginning of the settings meta box -->
	<div id="wp-jds-settings" class="post-box-container">
		<div class="metabox-holder">
			<div class="meta-box-sortables ui-sortable">
				<div id="options" class="postbox">	
					<div class="handlediv" title="<?php _e( 'Click to toggle', 'wpjdsp' ); ?>"><br /></div>

					<!-- settings box title -->
					<h3 class="hndle">
						<span style='vertical-align: top;'><?php _e( 'JDs Portfolio Settings', 'wpjdsp' ); ?></span>
					</h3>

					<div class="inside">
						<form action="options.php" method="post">
							<?php settings_fields( 'wp_jds_options_settings' ); ?>
						
							<table class="form-table">
								<tbody>
							
									<!-- <tr>
										<td colspan="2">
											<?php
											echo apply_filters ( 'wp_jds_settings_submit_button', '<input class="button-primary wp-jds-save-btn" type="submit" name="wp-jds-set-submit" value="'.__( 'Save Changes','jdswp' ).'" />' );
											?>
										</td>
									</tr> -->
								
									<?php
									// do action for add setting before settings
									do_action( 'wp_jds_before_setting', $wp_jds_options );
									?>

									<tr>
						    			<th>
						    				<label for="wp_jds_set_column"><?php echo __('Enable Bootstrap', 'wpjds'); ?></label>
						    			</th>
						            	<td>
								            <?php $bootstrap = !empty($wp_jds_options['bootstrap']) ? $wp_jds_options['bootstrap'] : ''; ?>
								            <input type="checkbox" name="wp_jds_options[bootstrap]" value="1" <?php checked($bootstrap, '1'); ?> />
						            	</td>
						    		</tr>
								
									<tr>
						    			<th>
						    				<label for="wp_jds_set_column"><?php echo __('Portfolio Columns', 'wpjds'); ?></label>
						    			</th>
						            	<td>
								            <select id="wp_jds_set_column" class="regular-select" name="wp_jds_options[column]">
								                <option <?php selected('col-md-6', $wp_jds_options['column']); ?> value='col-md-6'><?php echo __('2 Columns', 'wpjds'); ?></option>
								                <option <?php selected('col-md-4', $wp_jds_options['column']); ?> value='col-md-4'><?php echo __('3 Columns', 'wpjds'); ?></option>
								                <option <?php selected('col-md-3', $wp_jds_options['column']); ?> value='col-md-3'><?php echo __('4 Columns', 'wpjds'); ?></option>
								            </select>
						            	</td>
						    		</tr>
						    
						        	<tr>
						    			<th>
						    				<label for="wp_jds_set_width"><?php echo __('Image Height/Width', 'wpjds'); ?></label>
						    			</th>
						            	<td>
						            		<input type="number" id="wp_jds_set_width" class="small-text" name="wp_jds_options[width]" value="<?php echo $wp_jds_options['width']; ?>" />
						            		X
						           			<input type="number" id="wp_jds_set_height" class="small-text" name="wp_jds_options[height]" value="<?php echo $wp_jds_options['height']; ?>"/><br>
						           			<span class="description"><?php echo __('Add height width (w x h) in px, leave it empty for default.', 'wpjds'); ?></span>
						            	</td>
						    		</tr>
						        
						        	<tr>
						    			<th>
						    				<label for="wp_jds_set_animation"><?php echo __('Portfolio Animatiom', 'wpjds'); ?></label>
						    			</th>
						            	<td>
							            	<select id='wp_jds_set_animation' name="wp_jds_options[animation]">
							            		<option <?php selected('fade', $wp_jds_options['animation']) ?> value="fade"><?php echo __('Fade', 'wpjds'); ?></option>
							                	<option <?php selected('slide', $wp_jds_options['animation']) ?> value="slide"><?php echo __('Slide', 'wpjds'); ?></option>
							            	</select>
						            	</td>
						    		</tr>
						        
						        	<tr>
						    			<th>
						    				<label for='wp_jds_set_bg'><?php echo __('Hover Background Color', 'wpjds'); ?></label>
						    			</th>
						            	<td>
						            		<select id='wp_jds_set_bg' name='wp_jds_options[layer_bg_color]'>
						            			<option <?php selected('grey', $wp_jds_options['layer_bg_color']); ?> value="grey"><?php echo __('Grey', 'wpjds'); ?></option>
						                		<option <?php selected('blue', $wp_jds_options['layer_bg_color']); ?> value="blue"><?php echo __('Blue', 'wpjds'); ?></option>
						                		<option <?php selected('green', $wp_jds_options['layer_bg_color']); ?> value="green"><?php echo __('Green', 'wpjds'); ?></option>
						                		<option <?php selected('red', $wp_jds_options['layer_bg_color']); ?> value="red"><?php echo __('Red','wpjds'); ?></option>
						                		<option <?php selected('purple', $wp_jds_options['layer_bg_color']); ?> value="purple"><?php echo __('Purple', 'wpjds'); ?></option>
						            		</select>
						            	</td>
						    		</tr>

									<?php
									// do action for add setting after settings
									do_action( 'wp_jds_after_setting', $wp_jds_options );
									?>
								
									<tr>
										<td colspan="2">
											<?php echo apply_filters ( 'wp_jds_settings_submit_button', '<input class="button-primary wp-jds-save-btn" type="submit" name="wp-jds-set-submit" value="'.__( 'Save Changes','wpjds' ).'" />' ); ?>
										</td>
									</tr>
								</tbody>
							</table>
						</form>				 
					</div><!-- .inside -->
				</div><!-- #options -->
			</div><!-- .meta-box-sortables ui-sortable -->
		</div><!-- .metabox-holder -->
	</div><!-- #wp-jds-settings -->

</div> <!-- .wrap -->