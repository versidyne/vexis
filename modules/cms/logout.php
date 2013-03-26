<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Deauthenticate

	if ($authentication->delete_credentials($settings['cookie_prefix'], $settings['cookie_directory'], $settings['cookie_website']) == true) {
		
		$custom_title = "Logout Successful";
		$custom_header = "Logout Successful";
		$custom_body = "You have successfully logged out of this website. You may now enjoy this site as a guest.";
	}
	
	else {
	
		$custom_title = "Logout Unsuccessful";
		$custom_header = "Logout Unuccessful";
		$custom_body = "An error occurred during logout.";
	
	}

?>
