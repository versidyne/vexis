<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Redirect to admin panel gateway
	setcookie ("{$settings["cookie_prefix"]}_acp_session", $_COOKIE["{$cookie_prefix}_session"], time()+(5 * 365 * 24 * 60 * 60), $settings["cookie_directory"], $settings["acp_domain"], 0);
	header ("Location: {$settings['acp_loc']}");
	
?>
