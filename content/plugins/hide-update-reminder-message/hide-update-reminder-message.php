<?php
/*
Plugin Name: Hide Update Reminder Message
Plugin URI: http://sumitbansal.com/wordpress-plugin/hide-update-reminder-message/
Description: Allows you to remove the upgrade Nag screen from the wordpress adminstrator or other users
Author: Sumit Bansal
Version: 1.0
Author URI: http://www.sumitbansal.com/
*/
if ( is_admin() ){
	add_action('admin_menu', 'add_custom_link');
	function add_custom_link() {
		add_options_page('Hide Update Reminder', 'Hide Update Reminder', 'administrator', 'update-reminder', 'hide_reminder_setting');
	}
	
	function hide_reminder_setting(){
		if($_POST['option_hide'] == 'Y') {  
			$users = $_POST['sumit_users'];  
			update_option('sumit_users', $users);
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php 
		}  
			?>
			<div class="wrap">  
				<?php    echo "<h2>" . __( 'Hide Update Reminder', 'sumit_bansal' ) . "</h2>"; ?>  
          
                <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
                    <input type="hidden" name="option_hide" value="Y">  
                    <?php    echo "<h4>" . __( 'Hide Reminder Setting', 'sumit_bansal' ) . "</h4>"; ?>  
                    <p><?php _e("Select Option: " ); ?><select name="sumit_users"><option value="users"<?php if(get_option('sumit_users')=='users') echo 'selected="selected"'; ?>>Only Users</option><option value="ausers" <?php if(get_option('sumit_users')=='ausers') echo 'selected="selected"'; ?>>Users + Admin</option></select></p>  
                    <p class="submit">  
                    <input type="submit" name="Submit" value="<?php _e('Update Options', 'sumit_bansal' ) ?>" />  
                    </p>  
                </form>  
			</div>
			<?php
	}
}
add_action('admin_init', 'hide_message');

function hide_message($matches) {
	global $userdata;
	if(get_option('sumit_users')=='users'):
		if (!current_user_can('update_plugins')):
			remove_action('admin_notices', 'update_nag', 3);
		endif;
	elseif(get_option('sumit_users')=='ausers'):
			remove_action('admin_notices', 'update_nag', 3);
	else:
		if (!current_user_can('update_plugins')):
			remove_action('admin_notices', 'update_nag', 3);
		endif;
	endif;
}
?>