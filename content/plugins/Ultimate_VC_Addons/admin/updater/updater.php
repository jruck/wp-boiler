<div class="wrap">
	<h2><?php echo __("Ultimate Auto-update Settings","ultimate"); ?></h2>
    <?php
	$ultimate_keys = get_option('ultimate_keys');
	$envato_username = isset($ultimate_keys['envato_username']) ? $ultimate_keys['envato_username'] : '';
	$envato_api_key = isset($ultimate_keys['envato_api_key']) ? $ultimate_keys['envato_api_key'] : '';
	$purchase_code = isset($ultimate_keys['ultimate_purchase_code']) ? $ultimate_keys['ultimate_purchase_code'] : '';
	if($purchase_code !== ''){
		$url = 'http://marketplace.envato.com/api/edge/brainstormforce/c66htms66ggewajihfm6eco85kqd5cw4/verify-purchase:'.$purchase_code.'.json';
		$json = wp_remote_get($url);
		$result = json_decode($json['body'], true);
		if(isset($result['verify-purchase']['buyer']) && $result['verify-purchase']['buyer'] == $envato_username){
			echo '<div id="msg"><div class="updated"><p>Licence verified!</p></div></div>';
		} else {
			echo '<div id="msg"><div class="error"><p>Credentials are not valid. Please try again with valid credentials.</p></div></div>';
		}
	} else {
		echo '<div id="msg"></div>';
	}
	?>
    <form method="post" id="ultimate_updater">
    	<input type="hidden" name="action" value="update_ultimate_keys" />
    	<table class="form-table">
        	<tbody>
            	<tr valign="top">
                	<th scope="row"><?php echo __("Envato Username","ultimate"); ?></th>
                    <td> <input type="text" id="envato_username" value="<?php echo $envato_username; ?>" name="envato_username" />
						 <label for="envato_username"><?php echo __("Enter your envato username","ultimate"); ?></label>
					</td>
                </tr>
            	<tr valign="top">
                	<th scope="row"><?php echo __("API Key","ultimate"); ?></th>
                    <td> <input type="text" id="envato_api_key" value="<?php echo $envato_api_key; ?>" name="envato_api_key" />
						 <label for="envato_api_key"><?php echo __("Enter your envato API Key","ultimate"); ?></label>
					</td>
                </tr>
            	<tr valign="top">
                	<th scope="row"><?php echo __("Purchase Code","ultimate"); ?></th>
                    <td> <input type="text" id="ultimate_purchase_code" value="<?php echo $purchase_code; ?>" name="ultimate_purchase_code" />
						 <label for="ultimate_purchase_code"><?php echo __("Enter your purchase key for Ultimate Addons for Visual Composer","ultimate"); ?></label>
					</td>
                </tr>
            </tbody>
        </table>
    </form>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __("Save Changes","ultimate");?>"></p>
</div>
<script type="text/javascript">
var submit_btn = jQuery("#submit");
submit_btn.bind('click',function(e){
	e.preventDefault();
	var data = jQuery("#ultimate_updater").serialize();
	jQuery.ajax({
		url: ajaxurl,
		data: data,
		dataType: 'html',
		type: 'post',
		success: function(result){
			if(result == "success"){
				jQuery("#msg").html('<div class="updated"><p>Settings updated successfully. Licence Verified!</p></div>');
			} else if(result == "failed") {
				jQuery("#msg").html('<div class="error"><p>No settings were updated.</p></div>');
			} else if(result == "credentials") {
				jQuery(".updated").remove();
				jQuery("#msg").html('<div class="error"><p>Credentials are not valid. No settings were updated!</p></div>');
			}
		}
	});
});
</script>