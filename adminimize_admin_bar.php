<?php
/**
 * setup admin bar
 */

// test
function _fb_filter_admin_bar() {
	global $wp_admin_bar;
	
	//get array with userroles
	$user_roles             = get_all_user_roles();
	$user_roles_names       = get_all_user_roles_names();
	$disabled_item_adm      = '';
	$disabled_item_adm_hint = '';
	
	foreach ($user_roles as $role) {
		$disabled_menu_[$role]    = _mw_adminimize_getOptionValue('mw_adminimize_disabled_menu_'. $role .'_items');
		$disabled_submenu_[$role] = _mw_adminimize_getOptionValue('mw_adminimize_disabled_submenu_'. $role .'_items');
	}
	?>
	<div id="poststuff" class="ui-sortable meta-box-sortables">
		<div class="postbox">
			<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
			<h3 class="hndle" id="config_menu"><?php _e('WP Admin Bar Options', FB_ADMINIMIZE_TEXTDOMAIN ); ?></h3>
			<div class="inside">
				<br class="clear" />
				
				<table summary="config_menu" class="widefat">
					<thead>
						<tr>
							<th><?php _e('Admin Bar options - Menu, <span style=\"font-weight: 400;\">Submenu</span>', FB_ADMINIMIZE_TEXTDOMAIN ); ?></th>
							<?php foreach ($user_roles_names as $role_name) { ?>
								<th><?php _e('Deactivate for', FB_ADMINIMIZE_TEXTDOMAIN ); echo '<br/>' . $role_name; ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
				<?php
				foreach ($wp_admin_bar->menu as $menu_item_id => $item) {
					if ( isset($item) && $item != '' ) {
						
						$x = 0;
						$class = '';
						
						foreach($user_roles as $role) {
							// checkbox checked
							if ( isset( $disabled_menu_[$role]) && in_array($menu_item_id, $disabled_menu_[$role]) ) {
								$checked_user_role_[$role] = ' checked="checked"';
							} else {
								$checked_user_role_[$role] = '';
							}
						}
						
						echo '<tr class="form-invalid">' . "\n";
						echo "\t" . '<th>' . $item['title'] . ' <span style="color:#ccc; font-weight:400;">(' . $menu_item_id . ')</span> </th>';
						foreach ($user_roles as $role) {
							echo "\t" . '<td class="num">' . 
								'<input id="check_menu'. $role . $x .'" type="checkbox"' . $checked_user_role_[$role] . ' name="mw_adminimize_disabled_menu_'. $role .'_items[]" value="' . $item['title'] . '" />' 
								 . '</td>' . "\n";
						}
						echo '</tr>';
						
						if ( !isset($item['children']) )
							continue;
						
						// submenu items
						foreach ( $item['children'] as $subitem ) {
							$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';
							echo '<tr' . $class . '>' . "\n";
							foreach ($user_roles as $role) {
								if ( isset($disabled_submenu_[$role]) )
									$checked_user_role_[$role]  = ( in_array($subitem['id'], $disabled_submenu_[$role] ) ) ? ' checked="checked"' : '';
							}
							echo '<td> &mdash; ' . $subitem['title'] . ' <span style="color:#ccc; font-weight: 400;">(' . $subitem['id'] . ')</span> </td>' . "\n";
							foreach ($user_roles as $role) {
								echo '<td class="num">
									<input id="check_menu'. $role.$x .'" type="checkbox"' . $checked_user_role_[$role] . ' name="mw_adminimize_disabled_submenu_'. $role .'_items[]" value="' . $subitem['id'] . '" />' . 
									'</td>' . "\n";
							}
							echo '</tr>' . "\n";
							$x++;
						}
						$x++;
					}
				}
				?>
					</tbody>
				</table>
				
					<p id="submitbutton">
						<input class="button button-primary" type="submit" name="_mw_adminimize_save" value="<?php _e('Update Options', FB_ADMINIMIZE_TEXTDOMAIN ); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" />
					</p>
					<p><a class="alignright button" href="javascript:void(0);" onclick="window.scrollTo(0,0);" style="margin:3px 0 0 30px;"><?php _e('scroll to top', FB_ADMINIMIZE_TEXTDOMAIN); ?></a><br class="clear" /></p>
				
				</div>
			</div>
		</div>
	
	<?php
	//$wp_admin_bar->remove_menu('edit-my-profile');
}
add_action( 'wp_before_admin_bar_render', '_fb_filter_admin_bar' );

