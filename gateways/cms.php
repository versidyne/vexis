<?php
	
	// Layout detection, through size and platform
	//$layout = "mobile";
	//$layout = "tablet";
	
	if ($settings["www_prefix"] == "true") {
		if(!strstr($_SERVER["HTTP_HOST"], "www.")) {
			//header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://www.{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");
		}
	}
	
	$form = new form($database);
	
	// Legacy credentials
	/*$member = new member($database);
	$credentials = $authentication->retreive_credentials($authentication->cookie_data($settings["cookie_prefix"]));*/
	
	// add construction option as well
	// Check for developer cookie
	if ($settings['maintenance'] == "true") { if ($member->permissions($member->lookup($credentials["email"]), "special", "developer")) {$settings['maintenance'] = "false";} }
	
	// Display construction notification
	// Display maintenance notification
	if ($settings['maintenance'] == "true" && $_GET['page'] != "login") {
		if (!isset($_GET['page'])) { $page = "home"; }
		else { $page = $_GET['page']; }
		$custom_title = "Maintenance";
		$custom_header = "Routine Maintenance";
		$custom_body = "We are currently undergoing routine maintenance on our system. Our developers are hard at work to bring you this website as soon as possible. If you have any questions or comments, please email the administrator at: <a href='mailto:{$settings['admin_email']}'>{$settings['admin_email']}</a>.";
	}
	else {
		if (!isset($_GET['page'])) { $page = "home"; }
		else { $page = $_GET['page']; }
		
		$content = mysql_fetch_array($database->query("SELECT * FROM `content` WHERE `shortname` = '{$page}' LIMIT 1"), MYSQL_ASSOC);
		
		if (isset($content['module']) && $content['module'] != NULL) { $module_name = "modules/{$gateway}/{$content['module']}.php"; }
		else { $module_name = "modules/{$gateway}/{$page}.php"; }
		
		if (isset($content['enabled']) && $content['enabled'] != NULL) {
			if ($member->permissions($member->lookup($credentials["email"]), "restricted", "{$content['shortname']}")) { $login_form = true; }
			else {
				// Include modules
				// Soon to be added to an if statment verifying database block "module"
				if (file_exists($module_name)) { include $module_name; }
				if ($content['type'] == 'form') {
					if (isset($form_message)) { $form_array = $form->parse($page, $form_message); }
					else { $form_array = $form->parse($page); }
					if ($hide_form_headers == false) {
						$custom_title = $form_array['title'];
						$custom_header = $form_array['header'];
					}
					if ($hide_form == false) { $custom_body = $form_array['body']; }
					else { $custom_body = $form_message; }
				}
				// Build admin notification messages
				elseif ($content['type'] == 'error') {
					$subject = "Error report for {$settings['brand']}";
					$to = "{$settings['admin_email']}";
					$headers = 'From: noreply@versidyne.com\r\nReply-To: noreply@versidyne.com\r\nX-Mailer: PHP/'.phpversion();
					// replace _GETs
					$message = "On {$settings['current_date']} at {$settings['current_time']}, an error occurred on the {$settings['brand']} website. \n\nThe incident report is as follows. \n\nError: {$_GET['error']} \n\nIp: {$_GET['ip']} \nReferer: {$_GET['referer']} \nUrl: {$settings['url']} \n\nThis is a notification to ensure the best quality experience. \n\nIf you need help with this error, please speak with our support team at: http://www.versidyne.com/ \n\nSincerely, \nVersidyne INC";
					$success = mail ($to, $subject, $message, $headers);
					/*if (!$success) { echo "Email failed."; }
					else { echo "Email succeeded."; }*/
				}
				// General page types
				else { /* Do nothing */ }
			}
		}
		// Legacy module loading
		/*elseif (file_exists($module_name)) {
			if ($authentication->authenticate($settings[cookie_prefix]) == true) {
				$credentials = retreive_credentials(cookie_data($settings[cookie_prefix]));
				$mvar = member_vars(lookup_member_id($credentials[email]));
				$gvar = group_vars($mvar[group_id]);
				$allowed = explode(", ", $gvar["allowed"]);
				if (in_array("admincp", $allowed)) {
					$admincp = true;
					include $admincp_module_name;
				}
				elseif (file_exists($membercp_module_name)) { include $membercp_module_name; }
				else { $login_form = true; }
			}
			else {
				if (file_exists($public_module_name)) { include $public_module_name; }
				else { $login_form = true; }
			}
		}*/
		elseif (file_exists($module_name)) { include $module_name; }
		else { /* Do nothing */ }
	}
	
	if (isset($login_form) && $login_form == true) {
		$login_form_array = $form->parse("login", "You have either not logged in correctly or your session has expired. Please log in. <br><br>");
		$custom_title = "Unauthorized Access";
		$custom_header = "Unauthorized Access";
		$custom_body = $login_form_array['body'];
	}
	
	// Evalute Content
	if (isset($custom_title)) { $title = $settings['brand']." - ".$custom_title; }
	elseif (isset($content['title']) && $content['title'] != NULL) { $title = $settings['brand']." - ".$content['title']; }
	else { $title = $settings['brand']; }
	
	if (isset($custom_header)) { $header = $custom_header; }
	elseif (isset($content['header']) && $content['header'] != NULL) { $header = $content['header']; }
	else { $header = $settings['brand']; }
	
	if (isset($custom_body)) { $body = $custom_body; }
	elseif (isset($content['body']) && $content['body'] != NULL) { $body = $content['body']; }
	else { $body = "We apologize, but that page could not be displayed."; }
	
	if (isset($content['layout']) && $content['layout'] != NULL) { $layout = $content['layout']; }
	if (isset($custom_layout) && $custom_layout != NULL) { $layout = $custom_layout; }
	
	if (isset($content['redir']) && $content['redir'] != NULL) {
		header ("Location: {$content['redir']}");
	}
	
	// Check for authentication if necessary
	/*if ($authentication->authenticate($settings[cookie_prefix]) == true) { include $module_name; }
	else {
		$hide_form = true;
		$hide_form_headers = true;
		$login_form = true;
	}*/
	
	// Set Layout Directory
	if (isset($raw_data) && $raw_data == true) {
		$page_name = $body;
	}
	else {
		if (isset($layout) == false) { $layout = "index"; }
		$page_name = "skins/{$settings['skin']}/{$layout}.html";
		if (file_exists($page_name) == false) { $page_name = "skins/{$settings['skin']}/index.html"; }
	}
	
	// Set Data for Navbar and Adminbar
	if (isset($custom_name)) {$page = $custom_name;}
	if ($settings['admin_bar'] == "true" && $member->permissions($member->lookup($credentials["email"]), "allowed", "admin") && $_GET['page'] != "logout") { include "modules/cms/adminbar.php"; }
	
?>
