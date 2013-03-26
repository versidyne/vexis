<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	$_POST['email_input'] = strtolower($_POST['email_input']);
	
	if (isset($_POST['submit'])) {
		// Check if Email Exists (Account Identifier)
		if (isset($_POST['email_input']) && $_POST['email_input'] != NULL) {
			$result = $database->query ("SELECT * FROM `members` WHERE `email` = '{$_POST['email_input']}' LIMIT 1");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			mysql_free_result($result);
		}
		// Check Results
		if ($row != false) { $form_message = "The email address you entered is currently in use by another account.<br><br>"; }
		else {
			if (isset($_POST['email_input']) && $_POST['email_input'] != NULL) {
				if(isset($_POST['password_input']) && $_POST['password_input'] != NULL) {
					if ($_POST['password_input'] == $_POST['pass_confirm_input']) {
						if($_POST['nickname_input']) {
							// Retreive Last ID
							$last_id = $database->last_row("members");
							// Create New ID
							$new_user_id = bcadd($last_id, 1);
							// Encrypt password
							$_POST['password_input'] = md5($_POST['password_input']);
							// Create Account
							$database->query("INSERT INTO `members` (`id`, `email`, `password`, `group`, `nickname`, `associates`) VALUES ('{$new_user_id}', '{$_POST['email_input']}', '{$_POST['password_input']}', '5', '{$_POST['nickname_input']}', '1')");
							// Create Confirmation Email
							$subject = "{$settings['company']} registration";
							$to = "{$_POST['email_input']}";
							$from = "From: {$settings['admin_email']}\r\n";
							$message = "Thank you for registering with the {$settings['company']} website.\nIf you have any questions, please refer to the forums, search engine, or contact form.\n\nThank you,\n{$settings['company']}";
							// Send Confirmation Email
							mail ($to, $subject, $message, $from);
							// Display Success Page
							$hide_form = "true";
							$form_message = "You have successfully registered with the site. You may now log in with your new account.";
						} else { $form_message = "You did not enter a nickname.<br><br>"; }
					} else { $form_message = "The passwords you entered did not match. Please go back and try again.<br><br>"; }
				} else { $form_message = "You did not enter a password.<br><br>"; }
			} else { $form_message = "You did not enter an email address.<br><br>"; }
		}
	}
	
?>
