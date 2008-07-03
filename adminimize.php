<?php
/*
Plugin Name: Adminimize
Plugin URI: http://bueltge.de/wordpress-admin-theme-adminimize/674/
Description: Visually compresses the administratrive header so that more admin page content can be initially seen.  Also moves 'Dashboard' onto the main administrative menu because having it sit in the tip-top black bar was ticking me off and many other changes in the edit-area. The plugin that lets you hide 'unnecessary' items from the Wordpress administration menu, with or without admins. You can also hide post meta controls on the edit-area to simplify the interface.
Author: <a href="http://bueltge.de/">Frank B&uuml;ltge</a> and <a href="http://meyerweb.com/">Eric A. Meyer</a>
Version: 0.7.8
Last Update: 03.07.2008 13:33:44
*/ 


// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );


function _mw_adminimize_textdomain() {

	if (function_exists('load_plugin_textdomain')) {
		if ( !defined('WP_PLUGIN_DIR') ) {
			load_plugin_textdomain('adminimize', str_replace( ABSPATH, '', dirname(__FILE__) ) . '/languages');
		} else {
			load_plugin_textdomain('adminimize', false, dirname(plugin_basename(__FILE__)) . '/languages');
		}
	}
}


/**
 * some basic security with nonce
 * @var $_mw_adminimize_nonce
 */
if ( !function_exists('wp_nonce_field') ) {
	function _mw_adminimize_nonce_field($action = -1) {
		return;
	}
	$_mw_adminimize_nonce = -1;
} else {
	function _mw_adminimize_nonce_field($action = -1) {
		return wp_nonce_field($action);
	}
	$_mw_adminimize_nonce = '_mw_adminimize_update_key';
}


/**
 * some basics for message
 * @var $_mw_adminimize_nonce
 */
class _mw_adminimize_message_class {
	function _mw_adminimize_message_class() {
		$this->localizionName = 'adminimize';
		$this->errors = new WP_Error();
		$this->initialize_errors();
	}
	
	/**
	get_error - Returns an error message based on the passed code
	Parameters - $code (the error code as a string)
	Returns an error message
	*/
	function get_error($code = '') {
		$errorMessage = $this->errors->get_error_message($code);
		if ($errorMessage == null) {
			return __("Unbekannter Fehler.", $this->localizionName);
		}
		return $errorMessage;
	}
	
	// Initializes all the error messages
	function initialize_errors() {
		$this->errors->add('_mw_adminimize_update', __('Die Einstellungen wurden gespeichert.', $myLocalizationName));
		$this->errors->add('_mw_adminimize_access_denied', __('Du hast nicht ausreichend Rechte um diese Aktion durchzuf&uuml;hren!', $myLocalizationName));
		$this->errors->add('_mw_adminimize_deinstall', __('Die Einstellungen wurde gel&ouml;scht!', $myLocalizationName));
		$this->errors->add('_mw_adminimize_deinstall_yes', __('Checkbox setzen, wenn wirklich deinstalliert werden soll!', $myLocalizationName));
		$this->errors->add('_mw_adminimize_get_option', __('Menu und Submenu k&ouml;nnen nicht geladen werden!', $myLocalizationName));
		$this->errors->add('_mw_adminimize_set_theme', __('Backend-Theme wurde zugewiesen!', $myLocalizationName));
	}
}


/**
 * check user-option and add new style
 * @uses $pagenow
 */
function _mw_adminimize_init() {
	global $pagenow, $menu, $submenu;

	$disabled_metaboxes_post = get_option('mw_adminimize_disabled_metaboxes_post');
	$disabled_metaboxes_page = get_option('mw_adminimize_disabled_metaboxes_page');
	$disabled_metaboxes_post_adm = get_option('mw_adminimize_disabled_metaboxes_post_adm');
	$disabled_metaboxes_page_adm = get_option('mw_adminimize_disabled_metaboxes_page_adm');

	$_mw_admin_color = get_user_option('admin_color');

	if ( ($_mw_admin_color == 'mw_fresh') ||
				($_mw_admin_color == 'mw_classic') ||
				($_mw_admin_color == 'mw_colorblind') ||
				($_mw_admin_color == 'mw_grey') ||
				($_mw_admin_color == 'mw_fresh_ozh_am') ||
				($_mw_admin_color == 'mw_classic_ozh_am') ||
				($_mw_admin_color == 'mw_fresh_lm') ||
				($_mw_admin_color == 'mw_classic_lm') ||
				($_mw_admin_color == 'mw_wp23')
		 ) {
		if ( ($_mw_admin_color == 'mw_fresh') ||
				($_mw_admin_color == 'mw_classic') ||
				($_mw_admin_color == 'mw_colorblind') ||
				($_mw_admin_color == 'mw_grey') ||
				($_mw_admin_color == 'mw_wp23')
			 ) {
			add_action('admin_head', '_mw_adminimize_adminmenu', 1);
		}

		if ( ('post-new.php' == $pagenow) || ('post.php' == $pagenow) ) {
			add_action('admin_head', '_mw_adminimize_remove_box', 99);
			add_action('admin_head', '_mw_adminimize_remove_tb_window');
			
			//add_filter('image_downsize', '_mw_adminimize_image_downsize', 1, 3);
			
			if ( !in_array('#categorydivsb', $disabled_metaboxes_post) || !in_array('#categorydivsb', $disabled_metaboxes_post_adm) )
				add_action('submitpost_box', '_mw_adminimize_sidecat_list_category_box');
			if ( !in_array('#tagsdivsb', $disabled_metaboxes_post) || !in_array('#tagsdivsb', $disabled_metaboxes_post_adm) )
				add_action('submitpost_box', '_mw_adminimize_sidecat_list_tag_box');
			if ( in_array('media_buttons', $disabled_metaboxes_post) || in_array('media_buttons', $disabled_metaboxes_post_adm) )
				remove_action('media_buttons', 'media_buttons');
		}

		if ( ('page-new.php' == $pagenow) || ('page.php' == $pagenow) ) {
			add_action('admin_head', '_mw_adminimize_remove_tb_window');
			
			//add_filter('image_downsize', '_mw_adminimize_image_downsize', 1, 3);

			if ( in_array('media_buttons', $disabled_metaboxes_page) || in_array('media_buttons', $disabled_metaboxes_page_adm) )
				remove_action('media_buttons', 'media_buttons');
		}

	}

	if ( ('post-new.php' == $pagenow) || ('page-new.php' == $pagenow) || ('page.php' == $pagenow) || ('post.php' == $pagenow) ) {
		
		$_mw_adminimize_writescroll = get_option('_mw_adminimize_writescroll');
		switch ($_mw_adminimize_writescroll) {
		case 1:
			add_action('admin_head', '_mw_adminimize_writescroll');
			break;
		}
		$_mw_adminimize_tb_window = get_option('_mw_adminimize_tb_window');
		switch ($_mw_adminimize_tb_window) {
		case 1:
			add_action('admin_head', '_mw_adminimize_tb_window');
			break;
		}
		// set user option in edit-area
		add_action('admin_head', '_mw_adminimize_set_user_option_edit');
	}	

	// set menu option
	add_action('admin_head', '_mw_adminimize_set_menu_option', 1);

	// set metabox option
	add_action('admin_head', '_mw_adminimize_set_metabox_option', 1);

	add_action('in_admin_footer', '_mw_adminimize_admin_footer');
	
	update_option('mw_adminimize_default_menu', $menu);
	update_option('mw_adminimize_default_submenu', $submenu);
}

add_action('init', '_mw_adminimize_textdomain');
add_action('admin_menu', '_mw_adminimize_add_settings_page');
add_action('admin_menu', '_mw_adminimize_remove_dashboard');
add_action('admin_init', '_mw_adminimize_init', 1);
add_action('admin_init', '_mw_adminimize_admin_styles', 1);

register_activation_hook(__FILE__, '_mw_adminimize_install');
register_deactivation_hook(__FILE__, '_mw_adminimize_deinstall');


/**
 * remove tb_window of media-uplader
 * @echo script
 */
function _mw_adminimize_remove_tb_window() {
	
	$_mw_adminimize_remove_tb_window  = "\n";
	$_mw_adminimize_remove_tb_window .= '<script type="text/javascript">' . "\n";
	$_mw_adminimize_remove_tb_window .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#TB_window\').remove(); });' . "\n";
	$_mw_adminimize_remove_tb_window .= '</script>' . "\n";
	
	print($_mw_adminimize_remove_tb_window);
}


/**
 * new tb_window of media-uplader
 */
function _mw_adminimize_tb_window() {
	
	?>
	<script type="text/javascript">
	// thickbox settings
	jQuery(function($) {
		tb_position = function() {
			var tbWindow = $('#TB_window');
			var width = $(window).width();
			var H = $(window).height();
			var W = ( 1720 < width ) ? 1720 : width;
	
			if ( tbWindow.size() ) {
				tbWindow.width( W - 50 ).height( H - 45 );
				$('#TB_iframeContent').width( W - 50 ).height( H - 75 );
				tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
				if ( ! ( $.browser.msie && $.browser.version.substr(0,1) < 7 ) )
					tbWindow.css({'top':'20px','margin-top':'0'});
				$('#TB_title').css({'background-color':'#222','color':'#cfcfcf'});
			};
	
			return $('a.thickbox').each( function() {
				var href = $(this).attr('href');
				if ( ! href ) return;
				href = href.replace(/&width=[0-9]+/g, '');
				href = href.replace(/&height=[0-9]+/g, '');
				$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 ) );
			});
		};
	
		$(window).resize( function() { tb_position() } );
	});
	</script>
	<?php
}


/**
 * Uses WordPress filter for image_downsize, kill wp-image-dimension
 * code by Andrew Rickmann
 * http://www.wp-fun.co.uk/
 * @param $value, $id, $size
 */
function _mw_adminimize_image_downsize($value = false,$id = 0, $size = "medium") {

	if ( !wp_attachment_is_image($id) )
		return false;
		
	$img_url = wp_get_attachment_url($id);
	// Mimic functionality in image_downsize function in wp-includes/media.php
	if ( $intermediate = image_get_intermediate_size($id, $size) ) {
		$img_url = str_replace(basename($img_url), $intermediate['file'], $img_url);
	}
	elseif ( $size == 'thumbnail' ) {
		// fall back to the old thumbnail
		if ( $thumb_file = wp_get_attachment_thumb_file() && $info = getimagesize($thumb_file) ) {
			$img_url = str_replace(basename($img_url), basename($thumb_file), $img_url);
		}
	}
	if ( $img_url)
		return array($img_url, 0, 0);
	return false;
}


/**
 * Automatically scroll Write pages to a good position
 * code by Dougal Campbell
 * http://dougal.gunters.org/blog/2008/06/03/writescroll
 */
function _mw_adminimize_writescroll() {
	
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		// element to scroll
		var h = jQuery('html');
		// position to scroll to
		var wraptop = jQuery('div#poststuff').offset().top;
		var speed = 250; // ms
		h.animate({scrollTop: wraptop}, speed);
	});
	</script>
	<?php
}


/**
 * list category-box in sidebar
 * @uses $post_ID
 */
function _mw_adminimize_sidecat_list_category_box() {
	global $post_ID;
	?>

	<div class="inside" id="categorydivsb">
		<p><strong><?php _e("Categories"); ?></strong></p>
		<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
		<?php wp_category_checklist($post_ID); ?>
		</ul>
	<?php if ( !defined('WP_PLUGIN_DIR') ) { // for wp <2.6 ?>
		<div id="category-adder" class="wp-hidden-children">
			<h4><a id="category-add-toggle" href="#category-add" class="hide-if-no-js" tabindex="3"><?php _e( '+ Add New Category' ); ?></a></h4>
			<p id="category-add" class="wp-hidden-child">
				<input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php _e( 'New category name' ); ?>" tabindex="3" />
				<?php wp_dropdown_categories( array( 'hide_empty' => 0, 'name' => 'newcat_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => __('Parent category'), 'tab_index' => 3 ) ); ?>
				<input type="button" id="category-add-sumbit" class="add:categorychecklist:category-add button" value="<?php _e( 'Add' ); ?>" tabindex="3" />
				<?php wp_nonce_field( 'add-category', '_ajax_nonce', false ); ?>
				<span id="category-ajax-response"></span>
			</p>
		</div>
	<?php } else { ?>
		<div id="category-adder" class="wp-hidden-children">
			<h4><a id="category-add-toggle" href="#category-add" class="hide-if-no-js" tabindex="3"><?php _e( '+ Add New Category' ); ?></a></h4>
			<p id="category-add" class="wp-hidden-child">
				<label class="hidden" for="newcat"><?php _e( 'Add New Category' ); ?></label><input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php _e( 'New category name' ); ?>" tabindex="3" aria-required="true"/>
				<br />
				<label class="hidden" for="newcat_parent"><?php _e('Parent category'); ?>:</label><?php wp_dropdown_categories( array( 'hide_empty' => 0, 'name' => 'newcat_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => __('Parent category'), 'tab_index' => 3 ) ); ?>
				<input type="button" id="category-add-sumbit" class="add:categorychecklist:category-add button" value="<?php _e( 'Add' ); ?>" tabindex="3" />
				<?php wp_nonce_field( 'add-category', '_ajax_nonce', false ); ?>
				<span id="category-ajax-response"></span>
			</p>
		</div>
	<?php } ?>
	</div>
<?php
}


/**
 * list tag-box in sidebar
 * @uses $post_ID
 */
function _mw_adminimize_sidecat_list_tag_box() {
	global $post_ID;

	if ( !class_exists('SimpleTagsAdmin') ) {
	?>
	<div class="inside" id="tagsdivsb">
		<p><strong><?php _e('Tags'); ?></strong></p>
		<p id="jaxtag"><label class="hidden" for="newtag"><?php _e('Tags'); ?></label><input type="text" name="tags_input" class="tags-input" id="tags-input" size="40" tabindex="3" value="<?php echo get_tags_to_edit($post_ID); ?>" /></p>
		<div id="tagchecklist"></div>
	</div>
	<?php
	}
}


/**
 * remove default categorydiv
 * @echo script
 */
function _mw_adminimize_remove_box() {
	
	if ( function_exists('remove_meta_box') ) {
		if ( !class_exists('SimpleTagsAdmin') )
			remove_meta_box('tagsdiv', 'post', 'normal');
		remove_meta_box('categorydiv', 'post', 'normal');
	} else {
		$_mw_adminimize_sidecat_admin_head  = "\n" . '<script type="text/javascript">' . "\n";
		$_mw_adminimize_sidecat_admin_head .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#categorydiv\').remove(); });' . "\n";
		$_mw_adminimize_sidecat_admin_head .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#tagsdiv\').remove(); });' . "\n";
		$_mw_adminimize_sidecat_admin_head .= '</script>' . "\n";

		print($_mw_adminimize_sidecat_admin_head);
	}
}


/**
 * reorder admin-menu
 * @uses $menu
 * @param $file
 */
function _mw_adminimize_adminmenu($file) {
	global $menu;
	
	$menu[7]  = $menu[5];
	$menu[5]  = $menu[0];
	$menu[32] = $menu[40];
	$menu[40] = $menu[35];
	$menu[35] = $menu[30];
	$menu[30] = $menu[15];
	unset($menu[0]);
	unset($menu[15]);
}


/**
 * add new adminstyle to usersettings
 * @param $file
 */
function _mw_adminimize_admin_styles($file) {
	
	$_mw_adminimize_path = WP_CONTENT_URL . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/css/';

	// MW Adminimize Classic
	$styleName = 'MW Adminimize:' . ' ' . __('Classic');
	wp_admin_css_color (
		'mw_classic', $styleName, $_mw_adminimize_path . 'mw_classic.css',
		array('#07273E', '#14568A', '#D54E21', '#2683AE')
	);

	// MW Adminimize Fresh
	$styleName = 'MW Adminimize:' . ' ' . __('Fresh');
	wp_admin_css_color (
		'mw_fresh', $styleName, $_mw_adminimize_path . 'mw_fresh.css',
		array('#464646', '#CEE1EF', '#D54E21', '#2683AE')
	);

	// MW Adminimize WordPress 2.3
	$styleName = 'MW Adminimize:' . ' ' . __('WordPress 2.3');
	wp_admin_css_color (
		'mw_wp23', $styleName, $_mw_adminimize_path . 'mw_wp23.css',
		array('#000000', '#14568A', '#448ABD', '#83B4D8')
	);

	// MW Adminimize Colorblind
	$styleName = 'MW Adminimize:' . ' ' . __('Maybe i\'m colorblind');
	wp_admin_css_color (
		'mw_colorblind', $styleName, $_mw_adminimize_path . 'mw_colorblind.css',
		array('#FF9419', '#F0720C', '#710001', '#550007', '#CF4529')
	);

	// MW Adminimize Grey
	$styleName = 'MW Adminimize:' . ' ' . __('Grey');
	wp_admin_css_color (
		'mw_grey', $styleName, $_mw_adminimize_path . 'mw_grey.css',
		array('#000000', '#787878', '#F0F0F0', '#D8D8D8', '#909090')
	);

	/**
	 * style and changes for plugin Admin Drop Down Menu
	 * by Ozh
	 * http://planetozh.com/blog/my-projects/wordpress-admin-menu-drop-down-css/
	 */
	if ( function_exists('wp_ozh_adminmenu') ) {
		
		// MW Adminimize Classic include ozh adminmenu
		$styleName = 'MW Adminimize inc. Admin Drop Down Menu' . ' ' . __('Classic');
		wp_admin_css_color (
			'mw_classic_ozh_am', $styleName, $_mw_adminimize_path . 'mw_classic_ozh_am.css',
			array('#07273E', '#14568A', '#D54E21', '#2683AE')
		);
	
		// MW Adminimize Fresh include ozh adminmenu
		$styleName = 'MW Adminimize inc. Admin Drop Down Menu' . ' ' . __('Fresh');
		wp_admin_css_color (
			'mw_fresh_ozh_am', $styleName, $_mw_adminimize_path . 'mw_fresh_ozh_am.css',
			array('#464646', '#CEE1EF', '#D54E21', '#2683AE')
		);
	
	}
	
	/**
	 * style and changes for plugin Lighter Menus
	 * by corpodibacco
	 * http://www.italyisfalling.com/lighter-menus
	 */
	if ( function_exists('lm_build') ) {
		
		// MW Adminimize Classic include Lighter Menus
		$styleName = 'MW Adminimize inc. Lighter Menus' . ' ' . __('Classic');
		wp_admin_css_color (
			'mw_classic_lm', $styleName, $_mw_adminimize_path . 'mw_classic_lm.css',
			array('#07273E', '#14568A', '#D54E21', '#2683AE')
		);
	
		// MW Adminimize Fresh include Lighter Menus
		$styleName = 'MW Adminimize inc. Lighter Menus' . ' ' . __('Fresh');
		wp_admin_css_color (
			'mw_fresh_lm', $styleName, $_mw_adminimize_path . 'mw_fresh_lm.css',
			array('#464646', '#CEE1EF', '#D54E21', '#2683AE')
		);
	
	}
}


/**
 * remove the dashbord
 * @author of basic Austin Matzko
 * http://www.ilfilosofo.com/blog/2006/05/24/plugin-remove-the-wordpress-dashboard/
 */
function _mw_adminimize_remove_dashboard() {
	global $menu, $submenu, $user_ID;

	$disabled_menu        = get_option('mw_adminimize_disabled_menu');
	$disabled_submenu     = get_option('mw_adminimize_disabled_submenu');
	$disabled_menu_adm    = get_option('mw_adminimize_disabled_menu_adm');
	$disabled_submenu_adm = get_option('mw_adminimize_disabled_submenu_adm');

	// remove dashboard
	if ($disabled_menu != '') {
		if ( ( in_array('index.php', $disabled_menu) && !current_user_can('level_10') ) ||
					( in_array('index.php', $disabled_submenu) && !current_user_can('level_10') ) ||
					( in_array('index.php', $disabled_menu_adm) && current_user_can('level_10') ) ||
					( in_array('index.php', $disabled_submenu_adm) && current_user_can('level_10') )
			 ) {
	
			$_mw_adminimize_db_redirect = get_option('_mw_adminimize_db_redirect');
			switch ($_mw_adminimize_db_redirect) {
			case 0:
				$_mw_adminimize_db_redirect = 'profile.php';
				break;
			case 1:
				$_mw_adminimize_db_redirect = 'edit.php';
				break;
			case 2:
				$_mw_adminimize_db_redirect = 'edit-pages.php';
				break;
			case 3:
				$_mw_adminimize_db_redirect = 'post-new.php';
				break;
			case 4:
				$_mw_adminimize_db_redirect = 'page-new.php';
				break;
			case 5:
				$_mw_adminimize_db_redirect = 'edit-comments.php';
				break;
			}

			$the_user = new WP_User($user_ID);
			reset($menu); $page = key($menu);
			
			while ( (__('Dashboard') != $menu[$page][0]) && next($menu) || (__('Dashboard') != $menu[$page][1]) && next($menu) )
				$page = key($menu);
				
			if (__('Dashboard') == $menu[$page][0] || __('Dashboard') == $menu[$page][1])
				unset($menu[$page]);
			reset($menu); $page = key($menu);
			
			while ( !$the_user->has_cap($menu[$page][1]) && next($menu) )
				$page = key($menu);
				
			if ( preg_match('#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'])) {
				if (function_exists('admin_url')) {
					wp_redirect( admin_url($_mw_adminimize_db_redirect) );
				} else {
					wp_redirect( get_option('siteurl') . '/wp-admin/' . $_mw_adminimize_db_redirect );
				}
			}
		}
	}
}


/**
 * remove the flash_uploader
 */
function _mw_adminimize_disable_flash_uploader() {
	return false;
}


/**
 * set user options from database in edit-area
 */
function _mw_adminimize_set_user_option_edit() {
	
	$_mw_adminimize_path = WP_CONTENT_URL . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/css/';
	
	$_mw_adminimize_sidecat_admin_head = '';
	$_mw_adminimize_sidebar_wight = get_option('_mw_adminimize_sidebar_wight');
	switch ($_mw_adminimize_sidebar_wight) {
	case 300:
		$_mw_adminimize_sidecat_admin_head .= '<link rel="stylesheet" href="' . "\n";
		$_mw_adminimize_sidecat_admin_head .= $_mw_adminimize_path . 'mw_300_sidebar.css';
		$_mw_adminimize_sidecat_admin_head .= '" type="text/css" media="all" />' . "\n";
		break;
	case 400:
		$_mw_adminimize_sidecat_admin_head .= '<link rel="stylesheet" href="' . "\n";
		$_mw_adminimize_sidecat_admin_head .= $_mw_adminimize_path . 'mw_400_sidebar.css';
		$_mw_adminimize_sidecat_admin_head .= '" type="text/css" media="all" />' . "\n";
		break;
	case 20:
		$_mw_adminimize_sidecat_admin_head .= '<link rel="stylesheet" href="' . "\n";
		$_mw_adminimize_sidecat_admin_head .= $_mw_adminimize_path . 'mw_20p_sidebar.css';
		$_mw_adminimize_sidecat_admin_head .= '" type="text/css" media="all" />' . "\n";
		break;
	case 30:
		$_mw_adminimize_sidecat_admin_head .= '<link rel="stylesheet" href="' . "\n";
		$_mw_adminimize_sidecat_admin_head .= $_mw_adminimize_path . 'mw_30p_sidebar.css';
		$_mw_adminimize_sidecat_admin_head .= '" type="text/css" media="all" />' . "\n";
		break;
	}

	print($_mw_adminimize_sidecat_admin_head);
}


/**
 * set menu options from database
 */
function _mw_adminimize_set_menu_option() {
	global $pagenow, $menu, $submenu;
	
	$disabled_menu        = get_option('mw_adminimize_disabled_menu');
	$disabled_submenu     = get_option('mw_adminimize_disabled_submenu');
	$disabled_menu_adm    = get_option('mw_adminimize_disabled_menu_adm');
	$disabled_submenu_adm = get_option('mw_adminimize_disabled_submenu_adm');

	$_mw_adminimize_admin_head = "\n";
	$_mw_adminimize_user_info = get_option('_mw_adminimize_user_info');
	switch ($_mw_adminimize_user_info) {
	case 1:
		$_mw_adminimize_admin_head .= '<script type="text/javascript">' . "\n";
		$_mw_adminimize_admin_head .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#user_info\').remove(); });' . "\n";
		$_mw_adminimize_admin_head .= '</script>' . "\n";
		break;
	case 2:
		$_mw_adminimize_admin_head .= '<link rel="stylesheet" href="' . get_option( 'siteurl' ) . '/' . PLUGINDIR . '/' . plugin_basename( dirname(__FILE__) ) . '/css/mw_small_user_info.css" type="text/css" />' . "\n";
		$_mw_adminimize_admin_head .= '<script type="text/javascript">' . "\n";
		$_mw_adminimize_admin_head .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#user_info\').remove();';
		$_mw_adminimize_admin_head .= 'jQuery(\'div#wpcontent\').after(\'<div id="small_user_info"><p><a href="' . get_option('siteurl') . ('/wp-login.php?action=logout') . '" title="' . __('Log Out') . '">' . __('Log Out') . '</a></p></div>\') });' . "\n";
		$_mw_adminimize_admin_head .= '</script>' . "\n";
		break;
	}

	$_mw_adminimize_footer = get_option('_mw_adminimize_footer');
	switch ($_mw_adminimize_footer) {
	case 1:
		$_mw_adminimize_admin_head .= '<script type="text/javascript">' . "\n";
		$_mw_adminimize_admin_head .= "\t" . 'jQuery(document).ready(function() { jQuery(\'#footer\').remove(); });' . "\n";
		$_mw_adminimize_admin_head .= '</script>' . "\n";
		break;
	}

	$_mw_adminimize_admin_head .= '<script type="text/javascript" src="' . WP_CONTENT_URL . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/js/adminimize.js"></script>';

	// set menu
	if ($disabled_menu != '') {
	
		// set user-menu
		if ( !current_user_can('level_10') ) {
			foreach ($menu as $index => $item) {
				if ($item == 'index.php')
					continue;
		
				if (in_array($item[2], $disabled_menu))
					unset($menu[$index]);
			
				if ( !empty($submenu[$item[2]]) ) {
					foreach ($submenu[$item[2]] as $subindex => $subitem) {
						if (in_array($subitem[2], $disabled_submenu))
							unset($submenu[$item[2]][$subindex]);
					}
				}
			}
		}
		
		// set admin-menu
		if ( current_user_can('level_10') ) {
			foreach ($menu as $index => $item) {
				if ($item == 'index.php')
					continue;
		
				if (in_array($item[2], $disabled_menu_adm))
					unset($menu[$index]);
			
				if ( !empty($submenu[$item[2]]) ) {
					foreach ($submenu[$item[2]] as $subindex => $subitem) {
						if (in_array($subitem[2], $disabled_submenu_adm))
							unset($submenu[$item[2]][$subindex]);
					}
				}
			}
		}
		
	}
	
	print($_mw_adminimize_admin_head);
}


/**
 * set metabox options from database
 */
function _mw_adminimize_set_metabox_option() {
	global $pagenow;
	
	$_mw_adminimize_admin_head = "\n";
	
	// post
	if ( ('post-new.php' == $pagenow) || ('post.php' == $pagenow) ) {
		remove_action('admin_head', 'index_js');

		$disabled_metaboxes_post = get_option('mw_adminimize_disabled_metaboxes_post');
		$disabled_metaboxes_post_adm = get_option('mw_adminimize_disabled_metaboxes_post_adm');
		
		if ( current_user_can('level_10') ) {
			$metaboxes = implode(',', $disabled_metaboxes_post_adm); // for admins
		} else {
			$metaboxes = implode(',', $disabled_metaboxes_post); // < user level 10, admin
		}
		
		$_mw_adminimize_admin_head .= '<style type="text/css">' . $metaboxes . ' {display: none !important}</style>' . "\n";
	}
	
	// page
	if ( ('page-new.php' == $pagenow) || ('page.php' == $pagenow) ) {
		remove_action('admin_head', 'index_js');
		
		$disabled_metaboxes_page = get_option('mw_adminimize_disabled_metaboxes_page');
		$disabled_metaboxes_page_adm = get_option('mw_adminimize_disabled_metaboxes_page_adm');
		
		if ( current_user_can('level_10') ) {
			$metaboxes = implode(',', $disabled_metaboxes_page_adm);
		} else {
			$metaboxes = implode(',', $disabled_metaboxes_page); // < user level 10, admin
		}
	
		$_mw_adminimize_admin_head .= '<style type="text/css">' . $metaboxes . ' {display: none !important}</style>' . "\n";
	}
	
	print($_mw_adminimize_admin_head);
}


/**
 * small user-info
 * @uses $post_ID
 */
function _mw_adminimize_small_user_info() {
?>
	<div id="small_user_info">
		<p><a href="<?php echo site_url('wp-login.php?action=logout') ?>" title="<?php _e('Log Out') ?>"><?php _e('Log Out'); ?></a></p>
	</div>
<?php
}


/**
 * include options-page in wp-admin
 */
require_once('adminimize_page.php');


/**
 * credit in wp-footer
 */
function _mw_adminimize_admin_footer() {
	if( basename($_SERVER['REQUEST_URI']) == 'adminimize.php') {
		$plugin_data = get_plugin_data( __FILE__ );
		printf('%1$s plugin | ' . __('Version') . ' %2$s | ' . __('Author') . ' %3$s<br />', $plugin_data['Title'], $plugin_data['Version'], $plugin_data['Author']);
	}
}


/**
 * Add action link(s) to plugins page
 * Thanks Dion Hulse -- http://dd32.id.au/wordpress-plugins/?configure-link
 */
function _mw_adminimize_filter_plugin_actions($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=adminimize/adminimize.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
//	$links[] = $settings_link; // ... or after other links
	}
	return $links;
}


/**
 * settings in plugin-admin-page
 */
function _mw_adminimize_add_settings_page() {
	if( current_user_can('switch_themes') ) {
		add_submenu_page('options-general.php', __('Adminimize Einstellungen', 'adminimize'), __('Adminimize', 'adminimize'), 8, __FILE__, '_mw_adminimize_options');
		add_filter('plugin_action_links', '_mw_adminimize_filter_plugin_actions', 10, 2);
	}
}


/**
 * Set theme for users y user_level 10
 */
function _mw_adminimize_set_theme() {

	if ( !current_user_can('edit_users') )
		wp_die(__('Cheatin&#8217; uh?'));

	$user_ids = $_POST[mw_adminimize_theme_items];
	$admin_color = htmlspecialchars( stripslashes( $_POST[_mw_adminimize_set_theme] ) );
	foreach( $user_ids as $user_id) {
		$user_id = (int) $user_id;
		update_usermeta($user_id, 'admin_color', $admin_color);
	}
}


/**
 * Update options in database
 */
function _mw_adminimize_update() {
	global $menu, $submenu;
	
	// for a smaller database
	function _mw_adminimize_get_update($option) {
		if ( ($_POST[$option] == '0') || $_POST[$option] == '') {
			delete_option($option);
		} else {
			update_option($option , $_POST[$option]);
		}
	}
	
	_mw_adminimize_get_update('_mw_adminimize_sidebar_wight');
	_mw_adminimize_get_update('_mw_adminimize_user_info');
	_mw_adminimize_get_update('_mw_adminimize_footer');
	_mw_adminimize_get_update('_mw_adminimize_writescroll');
	_mw_adminimize_get_update('_mw_adminimize_tb_window');
	_mw_adminimize_get_update('_mw_adminimize_db_redirect');
	
	// wp menu, submenu
	update_option('mw_adminimize_default_menu', $menu);
	update_option('mw_adminimize_default_submenu', $submenu);
	
	// disabled wp menu, submenu
	update_option('mw_adminimize_disabled_menu', 
		isset($_POST['mw_adminimize_disabled_menu_items']) ? $_POST['mw_adminimize_disabled_menu_items'] : array()
	);
	update_option('mw_adminimize_disabled_submenu', 
		isset($_POST['mw_adminimize_disabled_submenu_items']) ? $_POST['mw_adminimize_disabled_submenu_items'] : array()
	);
	update_option('mw_adminimize_disabled_menu_adm', 
		isset($_POST['mw_adminimize_disabled_menu_adm_items']) ? $_POST['mw_adminimize_disabled_menu_adm_items'] : array()
	);
	update_option('mw_adminimize_disabled_submenu_adm', 
		isset($_POST['mw_adminimize_disabled_submenu_adm_items']) ? $_POST['mw_adminimize_disabled_submenu_adm_items'] : array()
	);
	
	// disabled meta boxes post
	update_option('mw_adminimize_disabled_metaboxes_post', 
		isset($_POST['mw_adminimize_disabled_metaboxes_post_items']) ? $_POST['mw_adminimize_disabled_metaboxes_post_items'] : array()
	);
	// disabled meta boxes page
	update_option('mw_adminimize_disabled_metaboxes_page', 
		isset($_POST['mw_adminimize_disabled_metaboxes_page_items']) ? $_POST['mw_adminimize_disabled_metaboxes_page_items'] : array()
	);
	// disabled meta boxes post Admin
	update_option('mw_adminimize_disabled_metaboxes_post_adm', 
		isset($_POST['mw_adminimize_disabled_metaboxes_post_adm_items']) ? $_POST['mw_adminimize_disabled_metaboxes_post_adm_items'] : array()
	);
	// disabled meta boxes page Admin
	update_option('mw_adminimize_disabled_metaboxes_page_adm', 
		isset($_POST['mw_adminimize_disabled_metaboxes_page_adm_items']) ? $_POST['mw_adminimize_disabled_metaboxes_page_adm_items'] : array()
	);

	$myErrors = new _mw_adminimize_message_class();
	$myErrors = '<div id="message" class="updated fade"><p>' . $myErrors->get_error('_mw_adminimize_update') . '</p></div>';
	echo $myErrors;
}


/**
 * Delete options in database
 */
function _mw_adminimize_deinstall() {
	
	delete_option('_mw_adminimize_sidebar_wight');
	delete_option('_mw_adminimize_user_info');
	delete_option('_mw_adminimize_footer');
	delete_option('_mw_adminimize_writescroll');
	delete_option('_mw_adminimize_tb_window');
	delete_option('_mw_adminimize_db_redirect');
	
	delete_option('mw_adminimize_default_menu');
	delete_option('mw_adminimize_default_submenu');
	delete_option('mw_adminimize_disabled_menu');
	delete_option('mw_adminimize_disabled_submenu');
	delete_option('mw_adminimize_disabled_menu_adm');
	delete_option('mw_adminimize_disabled_submenu_adm');
	
	delete_option('mw_adminimize_default_metaboxes_post');
	delete_option('mw_adminimize_disabled_metaboxes_page-adm');
	delete_option('mw_adminimize_disabled_metaboxes_post');
	delete_option('mw_adminimize_disabled_metaboxes_page');
	delete_option('mw_adminimize_disabled_metaboxes_post_adm');
	delete_option('mw_adminimize_disabled_metaboxes_page_adm');

	delete_option('_mw_adminimize_update_key');
}


/**
 * Install options in database
 */
function _mw_adminimize_install() {

	add_option('mw_adminimize_default_menu', '', '');
	add_option('mw_adminimize_default_submenu', '', '');
	add_option('mw_adminimize_disabled_menu', array(), '');
	add_option('mw_adminimize_disabled_submenu', array(), '');
	add_option('mw_adminimize_disabled_menu_adm', array(), '');
	add_option('mw_adminimize_disabled_submenu_adm', array(), '');

	add_option('mw_adminimize_disabled_metaboxes_post', array(),'');
	add_option('mw_adminimize_disabled_metaboxes_page', array(),'');
	add_option('mw_adminimize_disabled_metaboxes_post_adm', array(),'');
	add_option('mw_adminimize_disabled_metaboxes_page_adm', array(),'');
}
?>