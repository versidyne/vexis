<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	if ($_POST['submit'] == "true") {
		$subject = "{$settings['company']} Contact Form";
		$to = "{$settings['admin_email']}";
		$from = "From: {$_POST['name_input']} <{$_POST['email_input']}>\r\n";
		//$message = "{$settings['current_day']}, {$settings['current_date']}, {$settings['current_time']}\n\n{$_POST['inquiry_input']}";
		$message = "{$_POST['inquiry_input']}";
		mail ($to, $subject, $message, $from);
		$form_message = "Message sent successfully.";
	}

?>
