<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Declarations
	$data = new data();
	$_POST['email_input'] = strtolower($_POST['email_input']);
	$sundries = "class=\"logged-out\"";
	
	// Check for form submission
	if (isset($_POST['submit'])) {
		// Save the email address for future use
		if (isset($_POST['remember'])) { $data->save_cookie($settings, "email", "86400", $_POST['email_input']); }
		$custom_tags = array("<email>" => $_POST['email_input']);
		// Check if the user is logged in
		if ($authentication->authenticate($settings['cookie_prefix']) == true) { $form_message = "You are already logged in.<br><br>"; }
		else {
			// Encrypt password
			$_POST['password_input'] = md5($_POST['password_input']);
			// Run Authentication Method
			if ($authentication->authenticate_login($_POST['email_input'], $_POST['password_input']) == true) {
				$authentication->save_credentials($settings, $_POST['email_input'], $_POST['password_input'], false);
				header ("Location: {$settings['acp_loc']}?page=dashboard");
			}
			// Display unsuccessful login message
			else {
				$authentication->save_credentials($settings, $_POST['email_input'], $_POST['password_input'], false);
				$form_message = "The system was unable to log you in because the email address you entered is not registered to an account or the password is incorrect.<br><br>";
			}
		}
	}
	else { $custom_tags = array("<email>" => $data->retreive_cookie($settings, "email")); }
	
	$body = "<form action=\"?page=login\" method=\"post\" class=\"login\">
		<input type=\"hidden\" name=\"submit\" value=\"true\">
		<h2 class=\"login-heading\">Please sign in</h2>
		<input name=\"email_input\" type=\"text\" class=\"input-block-level\" placeholder=\"Email address\">
		<input name=\"password_input\" type=\"password\" class=\"input-block-level\" placeholder=\"Password\">
		<label class=\"checkbox\">
			<input name=\"remember\" type=\"checkbox\" value=\"true\"> Remember me
		</label>
		<button class=\"btn btn-large btn-primary\" type=\"submit\">Sign in</button>
	</form>";
	
	// value=\"{$custom_tags['<email>']}\"
	// onkeypress=\"CapsDetect(event)\"
	// checked=\"checked\"
	// <a href='?page=login'>Recover Password</a>
	
?>

