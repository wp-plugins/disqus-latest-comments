<?php
/*
Plugin Name: Disqus latest comments addon
Description: Displays the latest Disqus comments for a website.
Version: 1.0
Author: Adrian Gordon
Author URI: http://www.itsupportguides.com 
License: GPLv2
*/

/** register shortcode 'disqus-latest' **/
add_shortcode('disqus-latest', 'disquslastestcomments');

/** Front end - what is rendered when shortcode is used*/
function disquslastestcomments() {

/** Set default values **/
if (get_option('num_items')) {
    $num_items = get_option('num_items');
	}
else {
    $num_items = '5';
	}
	
if (get_option('hide_avatars')) {
    $hide_avatars = get_option('hide_avatars');
	}
else {
    $hide_avatars = '0';
	}
	
if (get_option('avatar_size')) {
    $avatar_size = get_option('avatar_size');
	}
else {
    $avatar_size = '40';
	}
	
if (get_option('excerpt_length')) {
    $excerpt_length = get_option('excerpt_length');
	}
else {
    $excerpt_length = '200';
	}
	
/** Styles **/
if (get_option('style') == "Grey") { 

?>		<style>
				.dsq-widget-user{
				text-decoration:none;
				display:block;
				font-family:'Trebuchet MS',Helvetica,sans-serif;
				}
				.dsq-widget-comment{
				font-family:'Trebuchet MS',Helvetica,sans-serif;
				display:block;
				}
				.dsq-widget-meta a{
				text-decoration:none;
				font-family:'Trebuchet MS',Helvetica,sans-serif;
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
				h3{
					font-family:'Trebuchet MS',Helvetica,sans-serif;
				}
	</style>
	<?php  }
if (get_option('style') == "Blue") { 
?> <style>
		.dsq-widget-user{
		text-decoration:none;
		display:block;
		font-family:calibri;
		color:#00ABD1;
		}
		.dsq-widget-comment{
		font-family:calibri;
		display:block;
		}
		.dsq-widget-meta a{
		text-decoration:none;
		font-family:calibri;
		}
		.dsq-widget-item{
		padding:5px;
		background-color:#F0F6F7;
		} 
		.dsq-widget-item p a{
		text-decoration:none;color:#00ABD1;
		}
		h3{
		font-family:'Trebuchet MS',Helvetica,sans-serif;
		}
		.dsq-widget-item:hover{
		border:1px solid #AFD7E0;
		padding:4px;
		}
		.dsq-widget-avatar{
		border-radius:100px;
		}
	</style>
<?php  }	
	if (get_option('style') == "Green") { 
?>
<style>
				.dsq-widget-user{
				text-decoration:none;
				display:block;
				font-family:calibri;
				color:#0EAB2A;
				}
				.dsq-widget-comment{
				font-family:calibri;
				display:block;
				}
				.dsq-widget-meta a{
				text-decoration:none;
				font-family:calibri;

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
				h3{
					font-family:'Trebuchet MS',Helvetica,sans-serif;
				}
				.dsq-widget-avatar{
				border-radius:100px;
				}

	</style>
<?php }
/** If Disqus shortname has been configured **/
if (get_option('disqus_shortname')) { ?>  
<script type="text/javascript" src="http://<?php echo get_option('disqus_shortname'); ?>.disqus.com/recent_comments_widget.js?num_items=<?php echo $num_items ?>&hide_avatars=<?php echo $hide_avatars ?>&avatar_size=<?php $avatar_size ?>&excerpt_length=<?php $excerpt_length?>"></script>
<?php
} else 
/** If Disqus shortname has NOT been configured **/
{ ?>
<p><strong>Disqus Latest Comments - Configuration required</strong></p>
<p>Log into the WordPress admin, open <strong>Comments - > Disqus Latest Comments</strong> and add the shortname for the websites Disqus account.</p>
<?php
}
}


/** Back end - register menu */
add_action( 'admin_menu', 'disqus_latest' );

/** Back end - menu */
function disqus_latest() {
	add_comments_page( 'Disqus Latest Comments', 'Disqus Latest Comments', 'manage_options', 'disqus-latest-comments', 'disqus_latest_comments_options' );
}

/** Back end - form */
function disqus_latest_comments_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

    if( isset($_POST['mt_submit_hidden']) && $_POST['mt_submit_hidden'] == 'Y' ) {

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

    } else {

        $disqus_shortname = get_option('disqus_shortname');

		$num_items = get_option('num_items');

        $hide_avatars = get_option('hide_avatars');

		$avatar_size = get_option('avatar_size');

		$excerpt_length = get_option('excerpt_length');
		
		$style = get_option('style');
		
    }

    $hidden_field_name = 'mt_submit_hidden';

	?>
<div class="wrap">
<h2><?php _e('Disqus Latest Comments - Options'); ?></h2>
<p><?php _e('This plugin will allow you to list your websites latest comments in a page or post.'); ?></p>
<p><?php _e('Instructions: <ol><li>Enter your Disqus shortname below and save the changes.<li>Open or create the post or page you want the comments to be included in<li>enter the shortcode <strong>[disqus-latest]</strong> into the content area and save the changes<li>The comments will now be displayed on the post or page where the shortcode has been used</ol>'); ?></p>
<form method="post">
<table class="form-table">
<tbody>
<tr>
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<th scope="row"><?php _e("Disqus shortname:" ); ?></th>
<td><input type="text" name="disqus_shortname" value="<?php echo $disqus_shortname; ?>" size="20">
<p class="description">The Disqus shortname can be found by logging in at <a href="http://www.disqus.com">www.disqus.com</a> opening the Admin menu -> settings then under 'Site Identity' you will see 'Shortname'.</p>
</td>
</tr>
<tr>
<th scope="row"><?php _e("Number of comments:" ); ?></th>
<td><input type="number" name="num_items" min="1" max="25" value="<?php echo $num_items; ?>" size="20"></td>
</tr>
<tr>
<th scope="row"><?php _e("Hide avatars:" ); ?></th>
<td><select name='hide_avatars'><option value='0' <?php if($hide_avatars=='0'){echo 'selected';}?>>No</option><option value='1' <?php if($hide_avatars=='1'){echo 'selected';}?>>Yes</option></select></td>
</tr>
<tr>
<th scope="row"><?php _e("Avatar size:" ); ?></th>
<td><input type="number" name="avatar_size" min="1" max="200" value="<?php echo $avatar_size; ?>" size="20"></td>
</tr>
<tr>
<th scope="row"><?php _e("Excerpt length:" ); ?></th>
<td><input type="number" name="excerpt_length" min="1" max="500" value="<?php echo $excerpt_length; ?>" size="20"></td>
</tr>
<tr>
<th scope="row"><?php _e("Style:" ); ?></th>
<td><select name='style'><option value='0' <?php if($style=='None'){echo 'selected';}?>>None</option><option value='Grey' <?php if($style=='Grey'){echo 'selected';}?>>Grey</option><option value='Blue' <?php if($style=='Blue'){echo 'selected';}?>>Blue</option><option value='Green' <?php if($style=='Green'){echo 'selected';}?>>Green</option></select></td>
</tr>
</tbody>
</table>

<hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>

</div>
<?php
}


?>