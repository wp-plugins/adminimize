<?php
/**
 * options-page in wp-admin
 */
function _mw_adminimize_options() {

	// update options
	if ( ($_POST['_mw_adminimize_action'] == '_mw_adminimize_insert') && $_POST['_mw_adminimize_save'] ) {
		
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') ) {
			check_admin_referer($_mw_adminimize_nonce);

			_mw_adminimize_update();
			
		} else {
			$myErrors = new _mw_adminimize_message_class();
			$myErrors = '<div id="message" class="error"><p>' . $myErrors->get_error('_mw_adminimize_access_denied') . '</p></div>';
			wp_die($myErrors);
		}
	}

	// deinstall options
	if ( ($_POST['_mw_adminimize_action'] == '_mw_adminimize_deinstall') &&  ($_POST['_mw_adminimize_deinstall_yes'] != '_mw_adminimize_deinstall') ) {
			$myErrors = new _mw_adminimize_message_class();
			$myErrors = '<div id="message" class="error"><p>' . $myErrors->get_error('_mw_adminimize_deinstall_yes') . '</p></div>';
			wp_die($myErrors);
	}
	
	if ( ($_POST['_mw_adminimize_action'] == '_mw_adminimize_deinstall') && $_POST['_mw_adminimize_deinstall'] && ($_POST['_mw_adminimize_deinstall_yes'] == '_mw_adminimize_deinstall') ) {

		if ( function_exists('current_user_can') && current_user_can('edit_plugins') ) {
			check_admin_referer($_mw_adminimize_nonce);
			
			_mw_adminimize_deinstall();
			
			$myErrors = new _mw_adminimize_message_class();
			$myErrors = '<div id="message" class="updated fade"><p>' . $myErrors->get_error('_mw_adminimize_deinstall') . '</p></div>';
			echo $myErrors;
		} else {
			$myErrors = new _mw_adminimize_message_class();
			$myErrors = '<div id="message" class="error"><p>' . $myErrors->get_error('_mw_adminimize_access_denied') . '</p></div>';
			wp_die($myErrors);
		}
	}
?>
	<div class="wrap">
		<h2><?php _e('Adminimize', 'adminimize'); ?></h2>
		<form name="backend_option" method="post" id="_mw_adminimize_options" action="<?php echo $location; ?>" >
			<?php _mw_adminimize_nonce_field($_mw_adminimize_nonce); ?>
			<p class="tablenav" id="submitbutton">
				<input class="button" type="submit" name="_mw_adminimize_save" value="<?php _e('Einstellungen aktualisieren', 'adminimize'); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" />
			</p>
			<br class="clear" />
			<table summary="config" class="widefat">
				<thead>
					<tr>
						<th><?php _e('Backend Einstellungen', 'adminimize'); ?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr valign="top">
						<td><?php _e('Sidebar Width', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_sidebar_wight = get_option('_mw_adminimize_sidebar_wight'); ?>
							<select name="_mw_adminimize_sidebar_wight">
								<option value="0"<?php if ($_mw_adminimize_sidebar_wight == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?></option>
								<option value="300"<?php if ($_mw_adminimize_sidebar_wight == '300') { echo ' selected="selected"'; } ?>>300px</option>
								<option value="400"<?php if ($_mw_adminimize_sidebar_wight == '400') { echo ' selected="selected"'; } ?>>400px</option>
								<option value="20"<?php if ($_mw_adminimize_sidebar_wight == '20') { echo ' selected="selected"'; } ?>>20%</option>
								<option value="30"<?php if ($_mw_adminimize_sidebar_wight == '30') { echo ' selected="selected"'; } ?>>30%</option>
							</select> <?php _e('Der Sidebar am rechten Rand des Bereich <em>Schreiben</em> kann konfiguriert werden. Standard sind 200 Pixel im WordPress Theme <em>Classic</em> und <em>Fresh</em>', 'adminimize'); ?>
						</td>
					</tr>
					<tr valign="top">
						<td><?php _e('User Info', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_user_info = get_option('_mw_adminimize_user_info'); ?>
							<select name="_mw_adminimize_user_info">
								<option value="0"<?php if ($_mw_adminimize_user_info == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?></option>
								<option value="1"<?php if ($_mw_adminimize_user_info == '1') { echo ' selected="selected"'; } ?>><?php _e('Ausblenden', 'adminimize'); ?></option>
								<option value="2"<?php if ($_mw_adminimize_user_info == '2') { echo ' selected="selected"'; } ?>><?php _e('nur Logout', 'adminimize'); ?></option>
								</select> <?php _e('Der User-Info-Bereich ist im oberen rechten Bereich zu finden und kann ausgeblendet oder reduziert dargestellt werden.', 'adminimize'); ?>
						</td>
					</tr>
					<tr valign="top">
						<td><?php _e('Footer', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_footer = get_option('_mw_adminimize_footer'); ?>
							<select name="_mw_adminimize_footer">
								<option value="0"<?php if ($_mw_adminimize_footer == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?></option>
								<option value="1"<?php if ($_mw_adminimize_footer == '1') { echo ' selected="selected"'; } ?>><?php _e('Ausblenden', 'adminimize'); ?></option>
								</select> <?php _e('Der Footer-Bereich kann deaktiviert werden, inklusive aller Links und Hinweise.', 'adminimize'); ?>
						</td>
					</tr>
					<tr valign="top">
						<td><?php _e('WriteScroll', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_writescroll = get_option('_mw_adminimize_writescroll'); ?>
							<select name="_mw_adminimize_writescroll">
								<option value="0"<?php if ($_mw_adminimize_writescroll == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?></option>
								<option value="1"<?php if ($_mw_adminimize_writescroll == '1') { echo ' selected="selected"'; } ?>><?php _e('Aktiv', 'adminimize'); ?></option>
								</select> <?php _e('Automatisches Scrollen zum Editor beim Aufruf der Seite Schreiben in Beitr&auml;ge und Seite.', 'adminimize'); ?>
						</td>
					</tr>
					<tr valign="top">
						<td><?php _e('Thickbox FullScreen', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_tb_window = get_option('_mw_adminimize_tb_window'); ?>
							<select name="_mw_adminimize_tb_window">
								<option value="0"<?php if ($_mw_adminimize_tb_window == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?></option>
								<option value="1"<?php if ($_mw_adminimize_tb_window == '1') { echo ' selected="selected"'; } ?>><?php _e('Aktiv', 'adminimize'); ?></option>
								</select> <?php _e('Alle Thickbox-Funktionen werden nutzen den kompletten Raum des Browsers, zum Beispiel beim uploaden von Bildern.', 'adminimize'); ?>
						</td>
					</tr>
					<?php
					// when remove dashboard
					$disabled_menu        = get_option('mw_adminimize_disabled_menu');
					$disabled_submenu     = get_option('mw_adminimize_disabled_submenu');
					$disabled_menu_adm    = get_option('mw_adminimize_disabled_menu_adm');
					$disabled_submenu_adm = get_option('mw_adminimize_disabled_submenu_adm');

					if ($disabled_menu != '') {
						if ( in_array('index.php', $disabled_menu) ||
								 in_array('index.php', $disabled_submenu) ||
								 in_array('index.php', $disabled_menu_adm) ||
								 in_array('index.php', $disabled_submenu_adm)
							 ) {
					?>
					<tr valign="top">
						<td><?php _e('Dashboard inaktiv, Weiterleitung nach', 'adminimize'); ?></td>
						<td>
							<?php $_mw_adminimize_db_redirect = get_option('_mw_adminimize_db_redirect'); ?>
							<select name="_mw_adminimize_db_redirect">
								<option value="0"<?php if ($_mw_adminimize_db_redirect == '0') { echo ' selected="selected"'; } ?>><?php _e('Standard', 'adminimize'); ?> (profile.php)</option>
								<option value="1"<?php if ($_mw_adminimize_db_redirect == '1') { echo ' selected="selected"'; } ?>><?php _e('Verwalten Beitr&auml;ge', 'adminimize'); ?> (edit.php)</option>
								<option value="2"<?php if ($_mw_adminimize_db_redirect == '2') { echo ' selected="selected"'; } ?>><?php _e('Verwalten Seiten', 'adminimize'); ?> (edit-pages.php)</option>
								<option value="3"<?php if ($_mw_adminimize_db_redirect == '3') { echo ' selected="selected"'; } ?>><?php _e('Schreiben Beitrag', 'adminimize'); ?> (post-new.php)</option>
								<option value="4"<?php if ($_mw_adminimize_db_redirect == '4') { echo ' selected="selected"'; } ?>><?php _e('Schreiben Seite', 'adminimize'); ?> (page-new.php)</option>
								<option value="5"<?php if ($_mw_adminimize_db_redirect == '5') { echo ' selected="selected"'; } ?>><?php _e('Kommentare', 'adminimize'); ?> (edit-comments.php)</option>
								</select> <?php _e('Du hast das Dashboard deaktivert, wohin soll der Nutzer weitergeleitet werden?', 'adminimize'); ?>
						</td>
					</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
			
			<br style="clear: both;" />

			<table summary="config_menu" class="widefat">
				<thead>
					<tr>
						<th><?php _e('Menu Einstellungen - Menu, <span style="font-weight: 400;">Submenu</span>', 'adminimize'); ?></th>
						<th><?php _e('Deaktivieren &lt; User Level 10 (Admin)', 'adminimize'); ?></th>
						<th><?php _e('Deaktivieren f&uuml;r Admin\'s', 'adminimize'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$menu                 = get_option('mw_adminimize_default_menu');
					$submenu              = get_option('mw_adminimize_default_submenu');
					$disabled_menu        = get_option('mw_adminimize_disabled_menu');
					$disabled_submenu     = get_option('mw_adminimize_disabled_submenu');
					$disabled_menu_adm    = get_option('mw_adminimize_disabled_menu_adm');
					$disabled_submenu_adm = get_option('mw_adminimize_disabled_submenu_adm');
					
					$disabled_metaboxes_post = get_option('mw_adminimize_disabled_metaboxes_post');
					$disabled_metaboxes_page = get_option('mw_adminimize_disabled_metaboxes_page');
					$disabled_metaboxes_post_adm = get_option('mw_adminimize_disabled_metaboxes_post_adm');
					$disabled_metaboxes_page_adm = get_option('mw_adminimize_disabled_metaboxes_page_adm');
					
					$metaboxes = array(
						'#pageslugdiv',
						'#tagsdiv,#tagsdivsb',
						'#categorydiv,#categorydivsb',
						'#postexcerpt',
						'#trackbacksdiv',
						'#postcustom',
						'#commentstatusdiv',
						'#passworddiv',
						'#authordiv',
						'#revisionsdiv',
						'.side-info',
						'#notice',
						'#post-body h2',
						'media_buttons'
					);
					
					if (class_exists('SimpleTagsAdmin'))
						array_push($metaboxes, '#suggestedtags');
					if (function_exists('tc_post'))
						array_push($metaboxes, '#textcontroldiv');
					
					$metaboxes_names = array(
						__('Permalink', 'adminimize'),
						__('Tags', 'adminimize'),
						__('Kategorien', 'adminimize'),
						__('Auszug', 'adminimize'),
						__('Trackbacks', 'adminimize'),
						__('Benutzerdefinierte Felder', 'adminimize'),
						__('Kommentare & Pings', 'adminimize'),
						__('Diesen Artikel durch ein Passwort sch&uuml;tzen', 'adminimize'),
						__('Autor', 'adminimize'),
						__('Post Revisions', 'adminimize'),
						__('Siehe auch', 'adminimize'),
						__('Mitteilungen', 'adminimize'),
						__('h2: Erweiterte Einstellungen', 'adminimize'),
						__('Media Buttons (alle)', 'adminimize')
					);
					
					if (class_exists('SimpleTagsAdmin'))
						array_push($metaboxes_names, __('Suggested tags from', 'adminimize'));
					if (function_exists('tc_post'))
						array_push($metaboxes_names, __('Text Control', 'adminimize'));

					$metaboxes_page = array(
						'#pageslugdiv',
						'#pagecustomdiv',
						'#pagecommentstatusdiv',
						'#pagepassworddiv',
						'#pageparentdiv',
						'#pagetemplatediv',
						'#pageorderdiv',
						'#pageauthordiv',
						'#revisionsdiv',
						'.side-info',
						'#notice',
						'#post-body h2',
						'media_buttons'
					);
					
					if (class_exists('SimpleTagsAdmin'))
						array_push($metaboxes_page, '#suggestedtags');
					
					$metaboxes_names_page = array(
						__('Permalink', 'adminimize'),
						__('Benutzerdefinierte Felder', 'adminimize'),
						__('Kommentare &amp; Pings', 'adminimize'),
						__('Diese Seite mit einem Passwort versehen', 'adminimize'),
						__('&Uuml;bergeordnete Seite', 'adminimize'),
						__('Seiten-Template', 'adminimize'),
						__('Reihenfolge', 'adminimize'),
						__('Seitenautor', 'adminimize'),
						__('Page Revisions', 'adminimize'),
						__('Siehe auch', 'adminimize'),
						__('Mitteilungen', 'adminimize'),
						__('h2: Erweiterte Einstellungen', 'adminimize'),
						__('Media Buttons (alle)', 'adminimize')
					);

					if (class_exists('SimpleTagsAdmin'))
						array_push($metaboxes_names_page, __('Suggested tags from', 'adminimize'));
					
					// print menu, submenu
					if ($menu != '') {
						
						$i = 0;
						foreach ($menu as $item) {
						
							// menu items
							// items disabled for user
							if ($item[2] == 'post-new.php' || $item[2] == 'edit.php') {
								$disabled_item = ' disabled="disabled"';
							} else {
								$disabled_item = '';
							}
							
							// checkbox checked
							if ( in_array($item[2], $disabled_menu) ) {
								$checked = ' checked="checked"';
							} else {
								$checked = '';
							}

							// checkbox checked for admin
							if ( in_array($item[2], $disabled_menu_adm) ) {
								$checked_adm = ' checked="checked"';
							} else {
								$checked_adm = '';
							}
							
							echo '<tr class="form-invalid">' . "\n";
							echo '<th>' . $item[0] . ' <span style="color:#ccc; font-weight: 400;">(' . $item[2] . ')</span> </th>';
							echo '<td><input type="checkbox"' . $disabled_item . $checked . ' name="mw_adminimize_disabled_menu_items[]" value="' . $item[2] . '"/></td>' . "\n";
							echo '<td><input type="checkbox"' . $disabled_item . $checked_adm . ' name="mw_adminimize_disabled_menu_adm_items[]" value="' . $item[2] . '"/></td>' . "\n";
							echo '</tr>';
							
							if ( !isset($submenu[$item[2]]) )
								continue;
						
							// submenu items
							foreach ($submenu[ $item[2] ] as $subitem) {
							
								// submenu items
								// items disabled for adm
								if ($subitem[2] == 'adminimize/adminimize.php') {
									$disabled_subitem_adm = ' disabled="disabled"';
								} else {
									$disabled_subitem_adm = '';
								}
								
								echo '<tr>' . "\n";
								
								$checked     = (in_array($subitem[2], $disabled_submenu)) ? ' checked="checked"' : '';
								$checked_adm = (in_array($subitem[2], $disabled_submenu_adm)) ? ' checked="checked"' : '';
								
								echo '<td> &mdash; ' . $subitem[0] . ' <span style="color:#ccc; font-weight: 400;">(' . $subitem[2] . ')</span> </td>' . "\n";
								echo '<td><input type="checkbox"' . $checked . ' name="mw_adminimize_disabled_submenu_items[]" value="' . $subitem[2] . '" /></td>' . "\n";
								echo '<td><input type="checkbox"' . $disabled_subitem_adm . $checked_adm . ' name="mw_adminimize_disabled_submenu_adm_items[]" value="' . $subitem[2] . '" /></td>' . "\n";
								echo '</tr>' . "\n";
							}
						
							$i++;
						}
						
					} else {
						$myErrors = new _mw_adminimize_message_class();
						$myErrors = '<tr><td style="color: red;">' . $myErrors->get_error('_mw_adminimize_get_option') . '</td></tr>';
						echo $myErrors;
					} ?>
				</tbody>
			</table>

			<br style="clear: both;" />

			<table summary="config_edit" class="widefat">
				<thead>
					<tr>
						<th><?php _e('Schreiben Einstellungen - Beitr&auml;ge', 'adminimize'); ?></th>
						<th><?php _e('Schreiben Einstellungen - Seiten', 'adminimize'); ?></th>
					</tr>
				</thead>
				
				<tbody>
					<tr valign="top">
						<td>
							<table summary="config_edit_post" class="widefat">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th><?php _e('&lt; Admin (Level 10)', 'adminimize'); ?></th>
										<th><?php _e('Admin (Level 10)', 'adminimize'); ?></th>
									</tr>
								</thead>
								
								<tbody>
								<?php
									foreach ($metaboxes as $index => $metabox) {
										$checked = (in_array($metabox, $disabled_metaboxes_post)) ? ' checked="checked"' : '';
										$checked_adm = (in_array($metabox, $disabled_metaboxes_post_adm)) ? ' checked="checked"' : '';
										
										echo '<tr>' . "\n";
										echo '<td>' . $metaboxes_names[$index] . ' <span style="color:#ccc; font-weight: 400;">(' . $metabox . ')</span> </td>' . "\n";
										echo '<td><input type="checkbox"' . $checked . ' name="mw_adminimize_disabled_metaboxes_post_items[]" value="' . $metabox . '" /></td>' . "\n";
										echo '<td><input type="checkbox"' . $checked_adm . ' name="mw_adminimize_disabled_metaboxes_post_adm_items[]" value="' . $metabox . '" /></td>' . "\n";
										echo '</tr>' . "\n";
									}
								?>
								</tbody>
							</table>
						</td>
						<td>
							<table summary="config_edit_page" class="widefat">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th><?php _e('&lt; Admin (Level 10)', 'adminimize'); ?></th>
										<th><?php _e('Admin (Level 10)', 'adminimize'); ?></th>
									</tr>
								</thead>
								
								<tbody>
								<?php
									foreach ($metaboxes_page as $index => $metabox) {
										$checked = (in_array($metabox, $disabled_metaboxes_page)) ? ' checked="checked"' : '';
										$checked_adm = (in_array($metabox, $disabled_metaboxes_page_adm)) ? ' checked="checked"' : '';
										
										echo '<tr>' . "\n";
										echo '<td>' . $metaboxes_names_page[$index] . ' <span style="color:#ccc; font-weight: 400;">(' . $metabox . ')</span> </td>' . "\n";
										echo '<td><input type="checkbox"' . $checked . ' name="mw_adminimize_disabled_metaboxes_page_items[]" value="' . $metabox . '" /></td>' . "\n";
										echo '<td><input type="checkbox"' . $checked_adm . ' name="mw_adminimize_disabled_metaboxes_page_adm_items[]" value="' . $metabox . '" /></td>' . "\n";
										echo '</tr>' . "\n";
									}
								?>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			
			<p class="tablenav" id="submitbutton">
				<input type="hidden" name="_mw_adminimize_action" value="_mw_adminimize_insert" />
				<input class="button" type="submit" name="_mw_adminimize_save" value="<?php _e('Einstellungen aktualisieren', 'adminimize'); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" />
			</p>
		</form>

		<br style="clear: both;" />
		
		<h3><?php _e('Deinstallation der Einstellungen', 'adminimize') ?></h3>
		<p><?php _e('Nutze diese Option, um die Datenbank von den Eintr&auml;gen des Plugins zu entfernen. Das Plugin entfernt die Eintr&auml;ge auch, wenn es deaktiviert wird!', 'adminimize'); ?></p>
		<form name="form2" method="post" id="_mw_adminimize_options_deinstall" action="<?php echo $location; ?>">
			<?php _mw_adminimize_nonce_field($_mw_adminimize_nonce); ?>
			<p class="tablenav">
				<input type="hidden" name="_mw_adminimize_action" value="_mw_adminimize_deinstall" />
				<input class="button-secondary" type="submit" name="_mw_adminimize_deinstall" value="<?php _e('Einstellungen l&ouml;schen', 'adminimize'); ?> &raquo;" /> 
				<input name="_mw_adminimize_deinstall_yes" value="_mw_adminimize_deinstall" type="checkbox" />
			</p>
		</form>

		<br style="clear: both;" />

		<p><small><?php _e('Weitere Information: Besuche die <a href=\'http://bueltge.de/wordpress-admin-theme-adminimize/674/\'>Plugin Webseite</a> f&uuml;r weitere Informationen oder hole die aktuelle Version des Plugins.', 'adminimize'); ?><br />&copy; Copyright 2008 - <?php echo date("Y"); ?> <a href="http://bueltge.de">Frank B&uuml;ltge</a> | <?php _e('Du willst Danke sagen? Besuche meine <a href=\'http://bueltge.de/wunschliste/\'>Wunschliste</a>.', 'adminimize'); ?></small></p>

	</div>
<?php
}
?>