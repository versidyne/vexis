<?php
	
	// Layout detection
	//$layout = "mobile";
	//$layout = "tablet";
	
	// WWW Prefix Redirect
	if ($settings["www_prefix"] == "true") {
		if(!strstr($_SERVER["HTTP_HOST"], "www.")) {
			//header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://www.{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");
		}
	}
	
	// Declare classes
	$form = new form($database);
	$member = new member($database);
	
	// Retreive credentials
	$credentials = $authentication->retreive_credentials($authentication->cookie_data($settings["cookie_prefix"]));
	
	// add construction option as well
	// Check for developer cookie
	if ($settings['maintenance'] == "true") { if ($member->permissions($member->lookup($credentials["email"]), "special", "developer")) {$settings['maintenance'] = "false";} }
	
	// Display construction notification
	// Display maintenance notification
	if ($settings['maintenance'] == "true" && $_GET['page'] != "login") {
		$custom_title = "Maintenance";
		$custom_header = "Routine Maintenance";
		$custom_body = "We are currently undergoing routine maintenance on our system. Our developers are hard at work to bring you this website as soon as possible. If you have any questions or comments, please email the administrator at: <a href='mailto:{$settings['admin_email']}'>{$settings['admin_email']}</a>.";
		if (!isset($_GET['page'])) { $page = "home"; }
		else { $page = $_GET['page']; }
	}
	// Display general content
	else {
		
		// Default variables
		if (!isset($_GET['page'])) { $page = "home"; }
		else { $page = $_GET['page']; }
		
		// Find page and credentials
		$content = mysql_fetch_array($database->query("SELECT * FROM `content` WHERE `shortname` = '{$page}' LIMIT 1"), MYSQL_ASSOC);
		
		if (isset($content['module']) && $content['module'] != NULL) {
			$module_name = "modules/{$gateway}/{$content['module']}.php";
		} else { $module_name = "modules/{$gateway}/{$page}.php"; }
		
		// Build content pages
		if (isset($content['enabled']) && $content['enabled'] != NULL) {
			// Restrict pages
			if ($member->permissions($member->lookup($credentials["email"]), "restricted", "{$content['shortname']}")) { $login_form = true; }
			else {
				// Include modules
				// Soon to be added to an if statment verifying database block "module"
				if (file_exists($module_name)) { include $module_name; }
				// Build forms
				if ($content['type'] == 'form') {
					// Generate form
					if (isset($form_message)) { $form_array = $form->parse($page, $form_message); }
					else { $form_array = $form->parse($page); }
					// Set headers (messages)
					if ($hide_form_headers == false) {
						$custom_title = $form_array['title'];
						$custom_header = $form_array['header'];
					}
					// Set body (messages)
					if ($hide_form == false) { $custom_body = $form_array['body']; }
					else { $custom_body = $form_message; }
				}
				// Build error messages
				elseif ($content['type'] == 'error') {
					// Notify Administration
					$subject = "Error report for {$settings['company']}";
					$to = "{$settings['admin_email']}";
					$headers = 'From: noreply@versidyne.com\r\nReply-To: noreply@versidyne.com\r\nX-Mailer: PHP/'.phpversion();
					// replace _GETs
					$message = "On {$settings['current_date']} at {$settings['current_time']}, an error occurred on the {$settings['company']} website. \n\nThe incident report is as follows. \n\nError: {$_GET['error']} \n\nIp: {$_GET['ip']} \nReferer: {$_GET['referer']} \nUrl: {$settings['url']} \n\nThis is a notification to ensure the best quality experience. \n\nIf you need help with this error, please speak with our support team at: http://www.versidyne.com/ \n\nSincerely, \nVersidyne LLC";
					// Send Email
					$success = mail ($to, $subject, $message, $headers);
					//if (!$success) { echo "Email failed."; }
					//else { echo "Email succeeded."; }
				}
				// General page types
				else { /* Do nothing */ }
			}
		}
		// Module loading
		/*elseif (file_exists($module_name)) {
			if ($authentication->authenticate($settings[cookie_prefix]) == true) {
				// Retreive Credentials
				$credentials = retreive_credentials(cookie_data($settings[cookie_prefix]));
				// Retreive Member Variables
				$mvar = member_vars(lookup_member_id($credentials[email]));
				// Retreive Group Variables
				$gvar = group_vars($mvar[group_id]);
				// Create array for Allowed
				$allowed = explode(", ", $gvar["allowed"]);
				// Show admin panel if your group allows it
				if (in_array("admincp", $allowed)) {
					$admincp = true;
					include $admincp_module_name;
				}
				// Show member panel if you are logged in
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
		
	// Show Login Form if Set
	if (isset($login_form) && $login_form == true) {
		// Parse Login Form
		$login_form_array = $form->parse("login", "You have either not logged in correctly or your session has expired. Please log in. <br><br>");
		// Add Form To Page
		$custom_title = "Unauthorized Access";
		$custom_header = "Unauthorized Access";
		$custom_body = $login_form_array['body'];
	}
	
	// Evaluate Title
	if (isset($custom_title)) { $title = $settings['company']." - ".$custom_title; }
	elseif (isset($content['title']) && $content['title'] != NULL) { $title = $settings['company']." - ".$content['title']; }
	else { $title = $settings['company']; }
	
	// Evaluate Header
	if (isset($custom_header)) { $header = $custom_header; }
	elseif (isset($content['header']) && $content['header'] != NULL) { $header = $content['header']; }
	else { $header = $settings['company']; }
	
	// Evaluate Body
	if (isset($custom_body)) { $body = $custom_body; }
	elseif (isset($content['body']) && $content['body'] != NULL) { $body = $content['body']; }
	else { $body = "We apologize, but that page could not be displayed."; }
	
	// Add Custom Layout
	if (isset($content['layout']) && $content['layout'] != NULL) { $layout = $content['layout']; }
	if (isset($custom_layout) && $custom_layout != NULL) { $layout = $custom_layout; }
	
	// Redirect page before the body is displayed (if feature is enabled).
	if (isset($content['redir']) && $content['redir'] != NULL) {
		header ("Location: {$content['redir']}");
	}
	
	// Check for authentication if necessary
	/*if ($authentication->authenticate($settings[cookie_prefix]) == true) { include $module_name; }
	else {
		// Hide Form & Form Headers
		$hide_form = true;
		$hide_form_headers = true;
		// Show Login Form
		$login_form = true;
	}*/
	
	// Get directory of layout
	if (isset($raw_data) && $raw_data == true) {
		$page_name = $body;
	}
	else {
		if (isset($layout) == false) { $layout = "default"; }
		$page_name = "skins/{$settings['skin']}/layouts/{$layout}.html";
		if (file_exists($page_name) == false) { $page_name = "skins/{$settings['skin']}/layouts/default.html"; }
	}
	
	// Set Data for Navbar
	if (isset($custom_name)) {$page = $custom_name;}
	
	// Inject sitebar
	if ($member->permissions($member->lookup($credentials["email"]), "allowed", "admin") && $_GET['page'] != "logout") { include "modules/cms/adminbar.php"; }
	
?>
