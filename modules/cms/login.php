<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	/*$appid = "e98fb2c1a18b32caf9e2bbc250c82e58";
	$appsec = "4301b45c926060188ebe58aa8709dfeb";
	$facebook = new Facebook(array('appId' => $appid, 'secret' => $appsec, 'cookie' => true));
	//Show if the user is logged in.
	$fb_info = array();
	if ($facebook->getSession()) {
		//$fb_info["fb_url"] = $facebook->getLogoutUrl();
		$fb_info["fb_login"] = true;
		//$fb_info["fb_text"] = "Logout with Facebook";
	}
	else {
		//$fb_info["fb_url"] = $facebook->getLoginUrl();
		$fb_info["fb_login"] = false;
		//$fb_info["fb_text"] = "Login with Facebook";
	}
	$fb_info["fb_url"] = $facebook->getLoginUrl();
	$fb_info["fb_text"] = "Login with Facebook";
	$fb_cstr = array();
	$fb_cstr["button"] = '<input type="submit" class="fb_button" value="' . $fb_info["fb_text"] . '" />';
	$fb_cstr["form"] = '<form action="' . $fb_info["fb_url"] . '" method="post" enctype = "" name="" onsubmit="">'. $fb_cstr["button"] . '</form>';
	$custom_tags = array("", "<fb_button>", "<fb_form>");
	$custom_values = array("", $fb_cstr["button"], $fb_cstr["form"]);*/
	
	// Declarations
	$data = new data();
	$_POST['email_input'] = strtolower($_POST['email_input']);
	
	// Check for form submission
	if (isset($_POST['submit'])) {
		// Save the email address for future use
		if (isset($_POST['remember'])) { $data->save_cookie($settings, "email", "86400", $_POST['email_input']); }
		$custom_tags = array("<email>" => $_POST['email_input'], "{fb_form}" => "");
		// Check if the user is logged in
		if ($authentication->authenticate($settings['cookie_prefix']) == true) { $form_message = "You are already logged in.<br><br>"; }
		else {
			// Encrypt password
			$_POST['password_input'] = md5($_POST['password_input']);
			// Run Authentication Method
			if ($authentication->authenticate_login($_POST['email_input'], $_POST['password_input']) == true) {
				$authentication->save_credentials($settings, $_POST['email_input'], $_POST['password_input'], false);
				header ("Location: {$settings['website']}?page=member");
			}
			// Display unsuccessful login message
			else {
				$authentication->save_credentials($settings, $_POST['email_input'], $_POST['password_input'], false);
				$form_message = "The system was unable to log you in because the email address you entered is not registered to an account or the password is incorrect.<br><br>";
			}
		}
	}
	else { $custom_tags = array("{email}" => $data->retreive_cookie($settings, "email"), "{fb_form}" => ""); }
	
?>

