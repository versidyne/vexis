<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Deauthenticate
	if ($authentication->delete_credentials($settings['cookie_prefix'], $settings['cookie_directory'], $settings['cookie_website']) == true) {
		$custom_header = "Logout Successful";
		$body = "You have successfully logged out of the admin panel.";
		$redir = "{$settings['admin_loc']}?page=login";
	} else {
		$custom_header = "Logout Unuccessful";
		$body = "An error occurred during logout.";
	}
	
?>
