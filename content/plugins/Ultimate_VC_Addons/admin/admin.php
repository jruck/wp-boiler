<?php
if(!class_exists('Ultimate_Admin_Area')){
	class Ultimate_Admin_Area{
		function __construct(){
			/* check_for_update */
			add_action( 'plugins_loaded', array($this, 'check_for_update') );
			/* add admin menu */
			add_action( 'admin_menu', array($this,'register_brainstorm_menu'));
			add_action( 'wp_ajax_update_ultimate_options', array($this,'update_settings'));
			add_action( 'wp_ajax_update_ultimate_keys', array($this,'update_verification'));
			add_action( 'in_plugin_update_message-Ultimate_VC_Addons/Ultimate_VC_Addons.php', array($this,'addUltimateUpgradeLink'));
		}
		function register_brainstorm_menu(){
			add_menu_page( 
					'Brainstorm Force', 
					'Brainstorm', 
					'administrator',
					'bsf-dashboard', 
					array($this,'load_dashboard'), 
					plugins_url( '../assets/img/icon-16.png',__FILE__ ), 79 );
			

				add_submenu_page(
						"bsf-dashboard",
						__("Update Plugin","smile"),
						__("Auto Update","smile"),
						"administrator",
						"ultimate-updater",
						array($this,'load_updater'));
		}
		function load_dashboard(){
			require_once('dashboard.php');
		}
		function load_updater(){
			if(isset($_GET['action']) && $_GET['action']==='upgrade') {
				$this->upgradeFromMarketplace();
			}else{
				require_once('updater/updater.php');
			}
		}
		function check_for_update(){
			
			require_once('updater/update-notifier.php');
			new Ultimate_Auto_Update(ULTIMATE_VERSION, 'http://ultimate.sharkslab.com/updates/?'.time(), 'Ultimate_VC_Addons/Ultimate_VC_Addons.php');
		}
		function update_settings(){
			if(isset($_POST['ultimate_row'])){
				$ultimate_row = $_POST['ultimate_row'];
			} else {
				$ultimate_row = 'disable';
			}
			
			$result1 = update_option('ultimate_row',$ultimate_row);
			
			if($result1){
				echo 'success';
			} else {
				echo 'failed';
			}
			die();
		}
		function update_verification(){
			$envato_username = $_POST['envato_username'];
			$envato_api_key = $_POST['envato_api_key'];
			$purchase_code = $_POST['ultimate_purchase_code'];
			$url = 'http://marketplace.envato.com/api/edge/brainstormforce/c66htms66ggewajihfm6eco85kqd5cw4/verify-purchase:'.$purchase_code.'.json';
			$json = wp_remote_get($url);
			$result = json_decode($json['body'], true);
			if(isset($result['verify-purchase']['buyer']) && $result['verify-purchase']['buyer'] == $envato_username){
				$ultimate_keys = array(
					"envato_username" => $envato_username,
					"envato_api_key" => $envato_api_key,
					"ultimate_purchase_code" => $purchase_code,
				);
				$result = update_option('ultimate_keys',$ultimate_keys);
				if($result){
					echo 'success';
				} else {
					echo 'failed';
				}
			} else {
				echo 'credentials';
			}
			die();
		}
		function addUltimateUpgradeLink() {
			$ultimate_keys = get_option('ultimate_keys');
            $username = $ultimate_keys['envato_username'];
            $api_key =  $ultimate_keys['envato_api_key'];
            $purchase_code =  $ultimate_keys['ultimate_purchase_code'];

			echo '<style type="text/css" media="all">tr#ultimate-addons-for-visual-composer + tr.plugin-update-tr a.thickbox + em { display: none; }</style>';
			if(empty($username) || empty($api_key) || empty($purchase_code)) {
				echo ' <a href="http://codecanyon.net/item/ultimate-addons-for-visual-composer/6892199?ref=brainstormforce">'.__('Download new version from CodeCanyon.', 'ultimate').'</a>';
			} else {
				echo '<a href="'.wp_nonce_url( admin_url('admin.php?page=ultimate-updater&action=upgrade')).'">'.__('Update Ultimate Addons for Visual Composer.', 'ultimate').'</a>';
			}
		}
		
		/**
		 * Upgrade plugin from the Envato marketplace.
		 */
		public function upgradeFromMarketplace() {
			if ( ! current_user_can('update_plugins') )
				wp_die(__('You do not have sufficient permissions to update plugins for this site.'));
			$title = __('Update Ultimate Addons for Visual Composer Plugin', 'ultimate');
			$parent_file = 'options-general.php';
			$submenu_file = 'options-general.php';
			require_once ABSPATH . 'wp-admin/admin-header.php';
			require_once ('updater/auto-update.php');
			$upgrader = new UltAutomaticUpdater( new Plugin_Upgrader_Skin( compact('title', 'nonce', 'url', 'plugin') ) );
			$upgrader->upgradeUltimate();
			include ABSPATH . 'wp-admin/admin-footer.php';
			exit();
		}
	}
	new Ultimate_Admin_Area;
}