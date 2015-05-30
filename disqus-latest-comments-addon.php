<?php
/*
Plugin Name: Disqus latest comments addon
Description: Displays the latest Disqus comments for a website.
Version: 1.5
Author: Adrian Gordon
Author URI: http://www.itsupportguides.com 
License: GPLv2
*/

/** Allow shortcodes to work in widgets **/
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

if (!class_exists('ITSG_Disqus_Latest_Comments_Addon')) {
    class ITSG_Disqus_Latest_Comments_Addon
    {     
        /**
        * Construct the plugin object
        */
        
        public function __construct()
        {
            // register actions
            
            /** Back end - register menu */
            add_action('admin_menu', array(&$this,'itsg_disqus_lastest_comments_addon_admin_menu'));
            
            /** register shortcode 'disqus-latest' **/
            add_shortcode('disqus-latest', array(&$this,'itsg_disqus_lastest_comments_addon_shortcode'));

            add_action('wp_footer', array(&$this,'itsg_disqus_lastest_comments_addon_change_text_js_script'));
			
			add_action('wp_footer', array(&$this,'itsg_disqus_lastest_comments_addon_css_styles'));
            
        }
        
        /* 
        *   Front end - what is rendered when shortcode is used
        */
        public function itsg_disqus_lastest_comments_addon_shortcode()
        {
            $html = '';
            /** Set default values **/
            if (get_option('num_items')) {
                $num_items = get_option('num_items');
            } else {
                $num_items = '5';
            }
            
            if (get_option('hide_avatars')) { 
                $hide_avatars = '1';  
            } else {
                $hide_avatars = '0';
            }
            
            if (get_option('avatar_size')) {    
                $avatar_size = get_option('avatar_size');
            } else {   
                $avatar_size = '35';
            }
            
            if (get_option('excerpt_length')) {
                $excerpt_length = get_option('excerpt_length');
            } else { 
                $excerpt_length = '200'; 
            }
            
            if (get_option('bypass_cache')) {    
                $bypass_cache = true;
            } else {  
                $bypass_cache = false;  
            }
            
            /** If Disqus shortname has been configured **/
            
            if (get_option('disqus_shortname')) {
                $html .= '<script type="text/javascript" src="http://' . get_option('disqus_shortname') . '.disqus.com/recent_comments_widget.js?num_items=' . $num_items . '&hide_avatars=' . $hide_avatars . '&avatar_size=' . $avatar_size . '&excerpt_length=' . $excerpt_length . '&rand=' . mt_rand() . '"></script>';
            } else {
                
                /** If Disqus shortname has NOT been configured **/
                
                $html .= "
			<p><strong>Disqus Latest Comments - Configuration required</strong></p>
			<p>Log into the WordPress admin, open <strong>Comments - > Disqus Latest Comments</strong> and add the shortname for the websites Disqus account.</p> ";
            }
            
            return $html;
        }
        
        /** Back end - menu */
        public function itsg_disqus_lastest_comments_addon_admin_menu()
        {
            add_comments_page('Disqus Latest Comments', 'Disqus Latest Comments', 'manage_options', 'disqus-latest-comments', array(&$this,'itsg_disqus_lastest_comments_addon_options'));    
        }
        
        /** Back end - form */
        public function itsg_disqus_lastest_comments_addon_options()
        {
            if (!current_user_can('manage_options')) {      
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }
            
            if (isset($_POST['mt_submit_hidden']) && $_POST['mt_submit_hidden'] == 'Y') {   
                $disqus_shortname = $_POST['disqus_shortname'];
                update_option('disqus_shortname', $disqus_shortname);
                
                $num_items = $_POST['num_items'];
                update_option('num_items', $num_items);
                
                $hide_avatars = $_POST['hide_avatars'];
                update_option('hide_avatars', $hide_avatars);
                
                $avatar_size = $_POST['avatar_size'];
                update_option('avatar_size', $avatar_size);
                
                $excerpt_length = $_POST['excerpt_length'];
                update_option('excerpt_length', $excerpt_length);
                
                $style = $_POST['style'];
                update_option('style', $style);
                
                $bypass_cache = $_POST['bypass_cache'];
                update_option('bypass_cache', $bypass_cache);
                
                $disqus_minute_ago = $_POST['disqus_minute_ago'];
                update_option('disqus_minute_ago', $disqus_minute_ago);
                
                $disqus_minutes_ago = $_POST['disqus_minutes_ago'];
                update_option('disqus_minutes_ago', $disqus_minutes_ago);
                
                $disqus_hour_ago = $_POST['disqus_hour_ago'];
                update_option('disqus_hour_ago', $disqus_hour_ago);
                
                $disqus_hours_ago = $_POST['disqus_hours_ago'];
                update_option('disqus_hours_ago', $disqus_hours_ago);
                
                $disqus_day_ago = $_POST['disqus_day_ago'];
                update_option('disqus_day_ago', $disqus_day_ago);
                
                $disqus_days_ago = $_POST['disqus_days_ago'];
                update_option('disqus_days_ago', $disqus_days_ago);
                
                $disqus_week_ago = $_POST['disqus_week_ago'];
                update_option('disqus_week_ago', $disqus_week_ago);
                
                $disqus_weeks_ago = $_POST['disqus_weeks_ago'];
                update_option('disqus_weeks_ago', $disqus_weeks_ago);
                
                $disqus_month_ago = $_POST['disqus_month_ago'];
                update_option('disqus_month_ago', $disqus_month_ago);
                
                $disqus_months_ago = $_POST['disqus_months_ago'];
                update_option('disqus_months_ago', $disqus_months_ago);
                
                $disqus_year_ago = $_POST['disqus_year_ago'];
                update_option('disqus_year_ago', $disqus_year_ago);
                
                $disqus_years_ago = $_POST['disqus_years_ago'];
                update_option('disqus_years_ago', $disqus_years_ago);
                
                $disqus_target_blank = $_POST['disqus_target_blank'];
                update_option('disqus_target_blank', $disqus_target_blank);
				
				$disqus_custom_css = $_POST['disqus_custom_css'];
                update_option('disqus_custom_css', $disqus_custom_css);
                
            } else {
                $disqus_shortname = get_option('disqus_shortname');
                $num_items = get_option('num_items');
                $hide_avatars = get_option('hide_avatars');
                $avatar_size = get_option('avatar_size');
                $excerpt_length = get_option('excerpt_length');
                $style = get_option('style');
                $bypass_cache = get_option('bypass_cache');
                $disqus_minute_ago = get_option('disqus_minute_ago');
                $disqus_minutes_ago = get_option('disqus_minutes_ago');
                $disqus_hour_ago = get_option('disqus_hour_ago');
                $disqus_hours_ago = get_option('disqus_hours_ago');
                $disqus_week_ago = get_option('disqus_week_ago');
                $disqus_weeks_ago = get_option('disqus_weeks_ago');
                $disqus_month_ago = get_option('disqus_month_ago');
                $disqus_months_ago = get_option('disqus_months_ago');
                $disqus_year_ago = get_option('disqus_year_ago');
                $disqus_years_ago    = get_option('disqus_years_ago');
                $disqus_target_blank = get_option('disqus_target_blank');
				$disqus_custom_css = get_option('disqus_custom_css');
            }
            
            $hidden_field_name = 'mt_submit_hidden';
?>
			<div class="wrap">
				<h2><?php _e('Disqus Latest Comments - Options'); ?></h2>
				<p><?php _e('This plugin will allow you to list your websites latest comments in a page or post.'); ?></p>
				<p><?php _e('Instructions: 
					<ol>
					<li>Enter your Disqus shortname below and save the changes.</li>
					<li>Open or create the post or page you want the comments to be included in<li>enter the shortcode <strong>[disqus-latest]</strong> into the content area and save the changes.</li>
					<li>The comments will now be displayed on the post or page where the shortcode has been used.</li>
					</ol>'); ?></p>

				<form method="post">
					<table class="form-table">
						<tbody>
						<tr>
							<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
							<th scope="row"><?php _e("Disqus shortname:");?></th>
							<td><input type="text" name="disqus_shortname" value="<?php echo $disqus_shortname; ?>" size="20">
							<p class="description">The Disqus shortname can be found by logging in at <a href="http://www.disqus.com">www.disqus.com</a> opening the Admin menu -> settings then under 'Site Identity' you will see 'Shortname'.</p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Number of comments:"); ?></th>
							<td><input type="number" name="num_items" min="1" max="25" value="<?php echo $num_items; ?>" size="20"></td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Hide avatars:"); ?></th>
							<td>
							<select name='hide_avatars'>
							<option value='0' <?php if ($hide_avatars == '0') { echo 'selected'; } ?>>No</option>
							<option value='1' <?php if ($hide_avatars == '1') { echo 'selected'; } ?>>Yes</option>
							</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Avatar size:"); ?></th>
							<td>
							<select name='avatar_size'>
							<option value='35' <?php if ($avatar_size == '35') { echo 'selected'; } ?>>35px</option>
							<option value='48' <?php if ($avatar_size == '48') { echo 'selected'; } ?>>48px</option>
							<option value='92' <?php if ($avatar_size == '92') { echo 'selected'; } ?>>92px</option>
							</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Excerpt length:"); ?></th>
							<td><input type="number" name="excerpt_length" min="1" max="500" value="<?php echo $excerpt_length; ?>" size="20"></td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Style:"); ?></th>
							<td>
							<select id="disqus_style_select" onclick="ToggleDisqusStyle();" onblur="ToggleDisqusStyle();"  onchange="ResetDisqusStyle();"  name='style'>
							<option value='0' <?php if ($style == 'None') {echo 'selected'; } ?>>None</option>
							<option value='Custom' <?php if ($style == 'Custom') { echo 'selected'; } ?>>Custom</option>
							<option value='Grey' <?php if ($style == 'Grey') { echo 'selected'; } ?>>Grey</option>
							<option value='Blue' <?php if ($style == 'Blue') { echo 'selected'; } ?>>Blue</option>
							<option value='Green' <?php if ($style == 'Green') { echo 'selected'; } ?>>Green</option>
							</select>
							</td>
						</tr>
						<tr style='display:none' id="disqus_custom_css">
							<th scope="row"><?php _e("Custom CSS:"); ?></th>
							<td>
							<p>Use the box below to enter your custom CSS styles - <strong>do not include the &#60;style&#62; tags</strong>.</p>
							<p>Classes available include:</p>
							<ol>
							<li>.dsq-widget-list - the entire list</li>
							<li>.dsq-widget-item - each comment item</li>
							<li>.dsq-widget-avatar - the avatar image in each comment item</li>
							<li>.dsq-widget-user - the Disqus user name</li>
							<li>.dsq-widget-comment - the comment</li>
							<li>.dsq-widget-meta - paragraph that contains the link to the post and day</li>
							</ol>
							<p>See <a target='_blank' href='https://wordpress.org/plugins/disqus-latest-comments/faq/'>plugin frequently asked questions</a> for example style.</p>
							<textarea name='disqus_custom_css' style='width:100%;' rows="10" cols="50"><?php echo $disqus_custom_css; ?></textarea> 
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e("Bypass Cache:"); ?></th>
							<td>
							<select name='bypass_cache'>
							<option value='0' <?php if ($bypass_cache == '0') { echo 'selected'; } ?>>No</option>
							<option value='1' <?php if ($bypass_cache == '1') { echo 'selected'; } ?>>Yes</option>
							</select>
							</td>
						</tr>
						<tr>
						<th>
						<label for="disqus_target_blank">Open Disqus usernames in new window (target='_blank')</label>
						</th>
						<td>
						<input type="checkbox" id="disqus_target_blank" name="disqus_target_blank" <?php if ($disqus_target_blank) echo "checked='checked'"; ?>  >
						</td>
						</tr>
						</tbody>
					</table>
					<hr />
					<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
					</p>
					<h3>Translate options</h3>
					<p><?php _e('These options allow you to translate the time terms used by Disqus.'); ?></p>
					<table class="form-table">
						<tbody>
					<tr>
						<th scope="row"><?php _e("Minute ago:"); ?></th>
						<td><input type="text" name="disqus_minute_ago" value="<?php echo $disqus_minute_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Minutes ago:"); ?></th>
						<td><input type="text" name="disqus_minutes_ago" value="<?php echo $disqus_minutes_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Hour ago:"); ?></th>
						<td><input type="text" name="disqus_hour_ago" value="<?php echo $disqus_hour_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Hours ago:"); ?></th>
						<td><input type="text" name="disqus_hours_ago" value="<?php echo $disqus_hours_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Day ago:"); ?></th>
						<td><input type="text" name="disqus_day_ago" value="<?php echo $disqus_day_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Days ago:"); ?></th>
						<td><input type="text" name="disqus_days_ago" value="<?php echo $disqus_days_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Week ago:"); ?></th>
						<td><input type="text" name="disqus_week_ago" value="<?php echo $disqus_week_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Weeks ago:"); ?></th>
						<td><input type="text" name="disqus_weeks_ago" value="<?php echo $disqus_weeks_ago; ?>" size="20">
						</td>

					</tr>

					<tr>
						<th scope="row"><?php _e("Month ago:"); ?></th>
						<td><input type="text" name="disqus_month_ago" value="<?php echo $disqus_month_ago;?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Months ago:"); ?></th>
						<td><input type="text" name="disqus_months_ago" value="<?php echo $disqus_months_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Year ago:"); ?></th>
						<td><input type="text" name="disqus_year_ago" value="<?php echo $disqus_year_ago; ?>" size="20">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e("Years ago:"); ?></th>
						<td><input type="text" name="disqus_years_ago" value="<?php echo $disqus_years_ago; ?>" size="20">
						</td>
					</tr>
					</tbody>
					</table>
					<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
					</p>
					<hr />
				</form>
			</div>
		<script type="text/javascript">
		
		function ToggleDisqusStyle() {
					if (jQuery("#disqus_style_select > option:selected").text() == "Custom") {
						jQuery("#disqus_custom_css").show();
					} else {
						jQuery("#disqus_custom_css").hide();
					}
				}
		function ResetDisqusStyle() {
				jQuery("#disqus_style_select > option.default").prop("selected", true);
				}
		
		jQuery(document).ready(function() {
			ToggleDisqusStyle();
		});
		</script>
			<?php
        }
        
        /*
        * jQuery that changes Disqus time terms
        */
        public function itsg_disqus_lastest_comments_addon_change_text_js_script()
        {  
            $disqus_minute_ago = get_option('disqus_minute_ago');
            $disqus_minutes_ago = get_option('disqus_minutes_ago');
            $disqus_hour_ago = get_option('disqus_hour_ago');
            $disqus_hours_ago = get_option('disqus_hours_ago');
            $disqus_day_ago = get_option('disqus_day_ago');
            $disqus_days_ago = get_option('disqus_days_ago');
            $disqus_week_ago = get_option('disqus_week_ago');
            $disqus_weeks_ago = get_option('disqus_weeks_ago');
            $disqus_month_ago = get_option('disqus_month_ago');
            $disqus_months_ago = get_option('disqus_months_ago');
            $disqus_year_ago = get_option('disqus_year_ago');
            $disqus_years_ago = get_option('disqus_years_ago');
            $disqus_target_blank = get_option('disqus_target_blank');
            
            if ($disqus_target_blank) {
?>
				<script type='text/javascript'>
				(function ($) {
					'use strict';
					$('.dsq-widget-list a').each(function() {
								var href = $(this).attr("href");
								if (href) {
								if (href.indexOf(window.location.host)==-1) {
									$(this).attr('target', '_blank');
								}
								}
							});
				}(jQuery));
				</script>		
			<?php
            }
            
            if ($disqus_minute_ago || $disqus_minutes_ago || $disqus_hour_ago || $disqus_hours_ago || $disqus_day_ago || $disqus_days_ago || $disqus_week_ago || $disqus_weeks_ago || $disqus_month_ago || $disqus_months_ago || $disqus_year_ago || $disqus_years_ago) {
                
?>
				<script>
					jQuery(function ($) {
						$('.dsq-widget-list').ready(function() {
							$("ul.dsq-widget-list p.dsq-widget-meta").each(function() {
								var text = $(this).html();
								<?php if ($disqus_minute_ago) echo 'text = text.replace("minute ago", "' . $disqus_minute_ago . '");'; ?>
								<?php if ($disqus_minutes_ago) echo 'text = text.replace("minutes ago", "' . $disqus_minutes_ago . '");'; ?>
								<?php if ($disqus_hour_ago) echo 'text = text.replace("hour ago", "' . $disqus_hour_ago . '");'; ?>
								<?php if ($disqus_hours_ago) echo 'text = text.replace("hours ago", "' . $disqus_hours_ago . '");'; ?>
								<?php if ($disqus_day_ago) echo 'text = text.replace("day ago", "' . $disqus_day_ago . '");'; ?>
								<?php if ($disqus_days_ago) echo 'text = text.replace("days ago", "' . $disqus_days_ago . '");'; ?>
								<?php if ($disqus_week_ago) echo 'text = text.replace("week ago", "' . $disqus_week_ago . '");'; ?>
								<?php if ($disqus_weeks_ago) echo 'text = text.replace("weeks ago", "' . $disqus_weeks_ago . '");'; ?>
								<?php if ($disqus_month_ago) echo 'text = text.replace("month ago", "' . $disqus_month_ago . '");'; ?>
								<?php if ($disqus_months_ago) echo 'text = text.replace("months ago", "' . $disqus_months_ago . '");'; ?>
								<?php if ($disqus_year_ago) echo 'text = text.replace("year ago", "' . $disqus_year_ago . '");'; ?>
								<?php if ($disqus_years_ago) echo 'text = text.replace("years ago", "' . $disqus_years_ago . '");'; ?>
								$(this).html(text);
							});
						});
					});
				</script>
			<?php
            }
            
        } // END itsg_disqus_lastest_comments_addon_change_text_js_script
		
		/*
        * CSS Styles placed in footer
        */
        public function itsg_disqus_lastest_comments_addon_css_styles()
        {
			if (get_option('style') == "Custom") { 
			?>
			<style>
			<?php echo get_option('disqus_custom_css') ?>
			</style>
			<?php
			} else if (get_option('style') == "Grey") {
			?>
              <style>
						.dsq-widget-user{
						text-decoration:none;
						display:block;
						}

						.dsq-widget-comment{
						display:block;
						}

						.dsq-widget-meta a{
						text-decoration:none;
						}

						.dsq-widget-item{
						border-left:3px solid #a0a0a0;
						padding-left:10px;
						transition-property: background-color, color;
						transition-duration: 1s;
						transition-timing-function: ease-out;
						} 

						.dsq-widget-item p a{
						text-decoration:none;
						}

						.dsq-widget-item:hover{
						border-left:3px solid #a0a0a0;
						border-right:3px solid #a0a0a0;
						padding-left:10px;
						background-color:#eaeaea;
						}

						.dsq-widget-avatar{
						border-radius:100px;
						}

			</style> 
			<?php                
            } else if (get_option('style') == "Blue") { 
			?>
            <style>
				.dsq-widget-user{
				text-decoration:none;
				display:block;
				color:#00ABD1;
				}

				.dsq-widget-comment{
				display:block;
				}

				.dsq-widget-meta a{
				text-decoration:none;
				}

				.dsq-widget-item{
				padding:5px;
				background-color:#F0F6F7;
				} 

				.dsq-widget-item p a{
				text-decoration:none;color:#00ABD1;
				}

				.dsq-widget-item:hover{
				border:1px solid #AFD7E0;
				padding:4px;
				}

				.dsq-widget-avatar{
				border-radius:100px;
				}
			</style>
			<?php
            } else if (get_option('style') == "Green") { 
			?>
              <style>
						.dsq-widget-user{
						text-decoration:none;
						display:block;
						color:#0EAB2A;
						}

						.dsq-widget-comment{
						display:block;
						}

						.dsq-widget-meta a{
						text-decoration:none;
						}

						.dsq-widget-item{
						border-left:3px solid #16B560;
						padding-left:10px;
						transition-property: background-color, color;
						  transition-duration: 1s;
						  transition-timing-function: ease-out;
						} 

						.dsq-widget-item p a{text-decoration:none;color:#0EAB2A;}

						.dsq-widget-item:hover{
						border-left:3px solid #16B560;
						padding-left:10px;
						background-color:#EDFAF3;
						}

						.dsq-widget-avatar{
						border-radius:100px;
						}
			</style> 
			<?php                
            }
		} // END itsg_disqus_lastest_comments_addon_css_styles
    }
    $ITSG_Disqus_Latest_Comments_Addon = new ITSG_Disqus_Latest_Comments_Addon();
}