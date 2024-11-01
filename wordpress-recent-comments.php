<?php
/*
Plugin Name: Wordpress-Recent-Comments
Plugin URI: http://111waystomakemoney.com/wordpress-recent-comments/
Plugin Description: For using the plugin, read the <a href="http://111waystomakemoney.com/wordpress-recent-comments/" title="Wordpress Recent comments">Wordpress Recent comments Instruction Page</a> .Show the recent comments in your WordPress sidebar.
Version: 4.15.01
Author: Bharath
Author URI: http://111waystomakemoney.com/
*/

/* core functions */
/* ------------------------------------------------------------ */
include ('core.php');
/* ------------------------------------------------------------ */
/* core functions */

/* l10n */
/* ------------------------------------------------------------ */
load_plugin_textdomain('Wordpress-Recent-Comments', '/wp-content/plugins/Wordpress-Recent-Comments/languages/');
/* ------------------------------------------------------------ */
/* l10n */

/* widget */
/* ------------------------------------------------------------ */
/**
 * Display the wrap of recent comment list.
 */
function wp_recentcomments() {
	echo get_wp_recentcomments();
}

/**
 * Retrieve the wrap of recent comment list.
 */
function get_wp_recentcomments() {
	$loading_text = __('Loading', 'Wordpress-Recent-Comments');
	$html = '<li class="rc-navi rc-clearfix"><span class="rc-loading">' . __('Loading', 'Wordpress-Recent-Comments') . '...</span></li>';
	$html .= '<li id="rc-comment-temp" class="rc-item rc-comment rc-clearfix"><div class="rc-info"></div><div><div class="rc-excerpt"></div></div></li>';
	$html .= '<li id="rc-ping-temp" class="rc-item rc-ping rc-clearfix"><span class="rc-label"></span></li>';

	return $html;
}

/**
 * Define widget.
 */
function wp_widget_recentcomments($args) {
	if ( '%BEG_OF_TITLE%' != $args['before_title'] ) {
		if ( $output = wp_cache_get('widget_recentcomments', 'widget') ) {
			return print($output);
		}
		ob_start();
	}

	extract($args);
	$options = get_option('widget_recentcomments');
	$title = empty($options['title']) ? __('Recent Comments', 'Wordpress-Recent-Comments') : $options['title'];

	echo $before_widget;
	echo $before_title . $title . $after_title;
	echo '<ul>';
	wp_recentcomments();
	echo '</ul>';
	echo $after_widget;

	if ( '%BEG_OF_TITLE%' != $args['before_title'] ) {
		wp_cache_add('widget_recentcomments', ob_get_flush(), 'widget');
	}
}

/**
 * Clear cache.
 */
function wp_delete_recentcomments_cache() {
	wp_cache_delete( 'widget_recentcomments', 'widget' );
}
add_action( 'comment_post', 'wp_delete_recentcomments_cache' );
add_action( 'wp_set_comment_status', 'wp_delete_recentcomments_cache' );

/**
 * Widget options.
 */
function wp_widget_recentcomments_control() {

	// Retrieve the options.
	$options = $newOptions = get_option('widget_recentcomments');

	// Default options.
	if (!is_array($options)) {
		$options['title'] = '';
	}

	// Override the defaults.
	if ( $_POST["recentcomments-submit"] ) {
		$newOptions['title'] = strip_tags(stripslashes($_POST["recentcomments-title"]));

		$options = $newOptions;
		update_option('widget_recentcomments', $options);
		wp_delete_recentcomments_cache();
	}

	// Final options.
	$title = attribute_escape($options['title']);

	// Display on WordPress Widgets page.
?>
	<p>
		<label for="recentcomments-title">
			<?php _e('Title: ', 'Wordpress-Recent-Comments'); ?>
			<input class="widefat" id="recentcomments-title" name="recentcomments-title" type="text" value="<?php echo $title; ?>" />
		</label>
	</p>

	<input type="hidden" id="recentcomments-submit" name="recentcomments-submit" value="1" />
<?php
}

/**
 * Widget initialization.
 */
function wp_widgets_recentcomments_init() {
	if ( !is_blog_installed() ) {
		return;
	}

	$widget_ops = array('classname' => 'widget_recentcomments', 'description' => __("The most recent comments", 'Wordpress-Recent-Comments') );
	wp_register_sidebar_widget('recentcomments', __('Wordpress-Recent-Comments', 'Wordpress-Recent-Comments'), 'wp_widget_recentcomments', $widget_ops);
	wp_register_widget_control('recentcomments', __('Wordpress-Recent-Comments', 'Wordpress-Recent-Comments'), 'wp_widget_recentcomments_control' );
}
add_action('widgets_init', 'wp_widgets_recentcomments_init');
/* ------------------------------------------------------------ */
/* widget */

/* options */
/* ------------------------------------------------------------ */
class WPRecentCommentsOptions {

	function getOptions() {
		$options = get_option('wp_recentcomments_options');
		if (!is_array($options)) {
			$options['use_css']			= true;
			$options['js_type']			= 'normal';
			$options['jquery_url']		= '';

			$options['limit']			= 5;
			$options['length']			= 50;
			$options['post']			= true;
			$options['ping']			= true;
			$options['avatar']			= true;
			$options['avatar_size']		= 32;
			$options['avatar_position']	= 'left';
			$options['navi']			= true;
			$options['admin']			= true;
			$options['smilies']			= true;
			$options['content']			= true;
			$options['external']			= true;

			update_option('wp_recentcomments_options', $options);
		}
		return $options;
	}

	function add() {
		if(isset($_POST['wp_recentcomments_save'])) {
			$options = WPRecentCommentsOptions::getOptions();

			// use_css
			if(!$_POST['use_css']) {
				$options['use_css'] = (bool)false;
			} else {
				$options['use_css'] = (bool)true;
			}

			// js_type
			$options['js_type'] = $_POST['js_type'];

			// jquery_url
			$options['jquery_url'] = stripslashes($_POST['jquery_url']);

			// limit (1-20)
			$options['limit'] = (int)$_POST['limit'];
			if($options['limit'] < 1) {
				$options['limit'] = 1;
			} else if($options['limit'] > 20) {
				$options['limit'] = 20;
			}

			// length (10-200)
			$options['length'] = (int)$_POST['length'];
			if($options['length'] < 10) {
				$options['length'] = 10;
			} else if($options['length'] > 200) {
				$options['length'] = 200;
			}

			// post
			if(!$_POST['post']) {
				$options['post'] = (bool)false;
			} else {
				$options['post'] = (bool)true;
			}

			// ping
			if(!$_POST['ping']) {
				$options['ping'] = (bool)false;
			} else {
				$options['ping'] = (bool)true;
			}

			// avatar
			if(!$_POST['avatar']) {
				$options['avatar'] = (bool)false;
			} else {
				$options['avatar'] = (bool)true;
			}

			// avatar_size
			$options['avatar_size'] = (int)$_POST['avatar_size'];

			// avatar_position
			$options['avatar_position'] = $_POST['avatar_position'];

			// navi
			if(!$_POST['navi']) {
				$options['navi'] = (bool)false;
			} else {
				$options['navi'] = (bool)true;
			}

			// admin
			if(!$_POST['admin']) {
				$options['admin'] = (bool)false;
			} else {
				$options['admin'] = (bool)true;
			}

			// smilies
			if(!$_POST['smilies']) {
				$options['smilies'] = (bool)false;
			} else {
				$options['smilies'] = (bool)true;
			}

			// content
			if(!$_POST['content']) {
				$options['content'] = (bool)false;
			} else {
				$options['content'] = (bool)true;
			}

			// external
			if(!$_POST['external']) {
				$options['external'] = (bool)false;
			} else {
				$options['external'] = (bool)true;
			}

			update_option('wp_recentcomments_options', $options);

		} else {
			WPRecentCommentsOptions::getOptions();
		}

		add_options_page(__('Wordpress-Recent-Comments', 'Wordpress-Recent-Comments'), __('Wordpress-Recent-Comments', 'Wordpress-Recent-Comments'), 10, basename(__FILE__), array('WPRecentCommentsOptions', 'display'));
	}

	function display() {
		$options = WPRecentCommentsOptions::getOptions();
?>

<form action="#" method="POST" enctype="multipart/form-data" name="wp_recentcomments_form">
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br /></div>
		<h2><?php _e('Wordpress-Recent-Comments Options', 'Wordpress-Recent-Comments'); ?></h2>
	
<h1 style="text-align: left">For Instructions Visit:<a href="http://111waystomakemoney.com/wordpress-recent-comments/" target="_blank">Plugin Page</a></h1>

		<table class="form-table">
			<tbody>

				<tr valign="top">
					<th scope="row"><?php _e('CSS', 'Wordpress-Recent-Comments'); ?></th>
					<td>
						<label>
							<input name="use_css" type="checkbox" <?php if($options['use_css']) echo 'checked="checked"'; ?> />
							 <?php _e('Use Wordpress-Recent-Comments.css.', 'Wordpress-Recent-Comments'); ?>
						</label>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('JavaScript Library', 'Wordpress-Recent-Comments'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="js_type" type="radio" value="normal" <?php if($options['js_type'] != 'custom_jquery' && $options['js_type'] != 'wp_jquery') echo "checked='checked'"; ?> />
							 <?php _e('Use normal JavaScript library that is supported by this plugin.', 'Wordpress-Recent-Comments'); ?>
						</label>
						<br />
						<label>
							<input name="js_type" type="radio" value="wp_jquery" <?php if($options['js_type'] == 'wp_jquery') echo "checked='checked'"; ?> />
							 <?php _e('Use jQuery library that is supported by WordPress.', 'Wordpress-Recent-Comments'); ?>
						</label>
						<br />
						<label>
							<input name="js_type" type="radio" value="custom_jquery" <?php if($options['js_type'] == 'custom_jquery') echo "checked='checked'"; ?> />
							 <?php _e('Custom jQuery.', 'Wordpress-Recent-Comments'); ?>
						</label>
						 <label>
							<?php _e('Please input the URL of jQuery:', 'Wordpress-Recent-Comments'); ?>
							 <input type="text" name="jquery_url" class="regular-text code" value="<?php echo($options['jquery_url']); ?>" />
						</label>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('Comment List', 'Wordpress-Recent-Comments'); ?></th>
					<td>
						<input type="text" name="limit" class="small-text" value="<?php echo($options['limit']); ?>">
						 <?php _e('comments per page.', 'Wordpress-Recent-Comments'); ?>

						 <br />
						<label>
							<input name="admin" type="checkbox" <?php if($options['admin']) echo 'checked="checked"'; ?> />
							 <?php _e('Show the comments from administrators.', 'Wordpress-Recent-Comments'); ?>
						</label>

						 <br />
						<label>
							<input name="ping" type="checkbox" <?php if($options['ping']) echo 'checked="checked"'; ?> />
							 <?php _e('Show pingback and trackback comments.', 'Wordpress-Recent-Comments'); ?>
						</label>

						 <br />
						<label>
							<input name="navi" type="checkbox" <?php if($options['navi']) echo 'checked="checked"'; ?> />
							 <?php _e('Show navigation bar.', 'Wordpress-Recent-Comments'); ?>
						</label>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><?php _e('Comment Items', 'Wordpress-Recent-Comments'); ?></th>
					<td>
						<input type="text" name="length" class="small-text" value="<?php echo($options['length']); ?>">
						 <?php _e('characters per comment.', 'Wordpress-Recent-Comments'); ?>

						 <br />
						<label>
							<input name="post" type="checkbox" <?php if($options['post']) echo 'checked="checked"'; ?> />
							 <?php _e('Show post titles.', 'Wordpress-Recent-Comments'); ?>
						</label>

						 <br />
						<label>
							<input name="content" type="checkbox" <?php if($options['content']) echo 'checked="checked"'; ?> />
							 <?php _e('Show the expand button when mouse over excerpts.', 'Wordpress-Recent-Comments'); ?>
						</label>

						 <br />
						<label>
							<input name="external" type="checkbox" <?php if($options['external']) echo 'checked="checked"'; ?> />
							 <?php _e('Open external pages in a new tab/window.', 'Wordpress-Recent-Comments'); ?>
						</label>

						<br />
						<label>
							<input name="avatar" type="checkbox" <?php if($options['avatar']) echo 'checked="checked"'; ?> />
							 <?php _e('Show avatars on', 'Wordpress-Recent-Comments'); ?>
						</label>
						 <select name="avatar_position" size="1">
							<option value="left" <?php if($options['avatar_position'] != right) echo ' selected '; ?>><?php _e('left', 'blocks'); ?></option>
							<option value="right" <?php if($options['avatar_position'] == right) echo ' selected '; ?>><?php _e('right', 'blocks'); ?></option>
						</select>
						 <?php _e(', size is', 'Wordpress-Recent-Comments'); ?>
						 <input type="text" name="avatar_size" class="small-text" value="<?php echo($options['avatar_size']); ?>">
						 <?php _e('pixels', 'Wordpress-Recent-Comments'); ?>

						<br />
						<label>
							<input name="smilies" type="checkbox" <?php if($options['smilies']) echo 'checked="checked"'; ?> />
							 <?php _e('Show smilies as graphic icons.', 'Wordpress-Recent-Comments'); ?>
						</label>
					</td>
				</tr>

			</tbody>
		</table>

		<p class="submit">
			<input class="button-primary" type="submit" name="wp_recentcomments_save" value="<?php _e('Save Changes', 'Wordpress-Recent-Comments'); ?>" />
		</p>
	</div>
</form>


</form>
<h2 style="text-align: left">If u like the plugin please Donate:<a href="http://111waystomakemoney.com/donate/" target="_blank">Plugin Donation Page</a></h2>

<?php
	}
}

add_action('admin_menu', array('WPRecentCommentsOptions', 'add'));
/* ------------------------------------------------------------ */
/* options */

/* style & script */
/* ------------------------------------------------------------ */
function rc_footer() {
	$options = get_option('wp_recentcomments_options');
?>
<script type="text/javascript">
//<![CDATA[
var rcGlobal = {
	serverUrl		:'<?php bloginfo('url'); ?>',
	infoTemp		:'<?php _e('%REVIEWER% on %POST%', 'Wordpress-Recent-Comments'); ?>',
	loadingText		:'<?php _e('Loading', 'Wordpress-Recent-Comments'); ?>',
	noCommentsText	:'<?php _e('No comments', 'Wordpress-Recent-Comments'); ?>',
	newestText		:'<?php _e('&laquo; Newest', 'Wordpress-Recent-Comments'); ?>',
	newerText		:'<?php _e('&laquo; Newer', 'Wordpress-Recent-Comments'); ?>',
	olderText		:'<?php _e('Older &raquo;', 'Wordpress-Recent-Comments'); ?>',
	showContent		:'<?php echo $options['content']; ?>',
	external		:'<?php echo $options['external']; ?>',
	avatarSize		:'<?php echo $options['avatar_size']; ?>',
	avatarPosition	:'<?php echo $options['avatar_position']; ?>',
	anonymous		:'<?php _e('Anonymous', 'Wordpress-Recent-Comments'); ?>',
	initJson		:<?php echo rc_get_json(1); ?>
};
//]]>
</script>
<?php
}
add_action('wp_footer', 'rc_footer');

function load_static() {
	$options = get_option('wp_recentcomments_options');
	$plugins_version = '4.15.01';
	$plugins_url = plugins_url('Wordpress-Recent-Comments');
	$plugins_css_url = $plugins_url . '/css';
	$plugins_css_media = 'screen';
	$plugins_js_url = $plugins_url . '/js';

	// CSS
	if($options['use_css']) {
		if(file_exists(TEMPLATEPATH . '/Wordpress-Recent-Comments.css')){
			wp_enqueue_style('Wordpress-Recent-Comments-custom', get_bloginfo('template_url') . '/Wordpress-Recent-Comments.css', array(), $plugins_version, $plugins_css_media);
		} else {
			wp_enqueue_style('Wordpress-Recent-Comments', $plugins_css_url . '/Wordpress-Recent-Comments.css', array(), $plugins_version, $plugins_css_media);
		}
	}

	// JavaScript
	if($options['js_type'] == 'normal') {
		wp_enqueue_script('Wordpress-Recent-Comments', $plugins_js_url . '/Wordpress-Recent-Comments.js', array(), $plugins_version, true);

	} else {
		if($options['js_type'] == 'custom_jquery') {
			if($options['jquery_url'] != '') {
				wp_enqueue_script('Wordpress-Recent-Comments-lib', $options['jquery_url'], array(), $plugins_version, true);
			}
			wp_enqueue_script('Wordpress-Recent-Comments-jquery', $plugins_js_url . '/Wordpress-Recent-Comments-jquery.js', array(), $plugins_version, true);
		} else {
			wp_enqueue_script('Wordpress-Recent-Comments-jquery-with-lib', $plugins_js_url . '/Wordpress-Recent-Comments-jquery.js', array('jquery'), $plugins_version, true);
		}
	}
}
add_action('template_redirect', 'load_static');
/* ------------------------------------------------------------ */
/* style & script */
?>
