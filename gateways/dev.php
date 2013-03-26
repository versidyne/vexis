<?php
	
	// Instead of changing skins, styles will be all that is altered
	// jquery skin, css style, that is all
	
	// Requested page
	if (!isset($_GET['page'])) { $page = "dashboard"; }
	else { $page = $_GET['page']; }
	
	// Cookie defaults
	$settings["cookie_prefix"] = "{$settings["cookie_prefix"]}_acp";
	$settings["cookie_website"] = $settings["acp_domain"];
	
	// Verify credentials
	$member = new member($database);
	$credentials = $authentication->retreive_credentials($authentication->cookie_data($settings["cookie_prefix"]));
	if ($member->permissions($member->lookup($credentials["email"]), "restricted", "admin")) {
		//header ("Location: {$settings["website"]}?page=member");
		//if ($page != "login") { header ("Location: {$settings["acp_loc"]}?page=login"); }
		$page = "login";
	}
	
	// Module information
	$module = array();
	$module["loc"]  = "modules/{$gateway}/{$page}.php";
	$module["name"] = "{$page}";
	
	// Include module
	if (file_exists($module["loc"])) {
		include $module["loc"];
	} else {
		$custom_header = "Nonexistant";
		$body = "We apologize, but this page does not exist.";
	}
	
	//if ($body) { $raw = true; $custom_body = "<div class='editor'>".$body."</div>"; }
	//if ($row) { $row = ""; }
	//$custom_body = "<div class='editor'>".$body."</div>";
	//$raw = true;
	
	if (!isset($continue) || !$continue) {
		if ($page != "login") {
			include "modules/{$gateway}/toolbar.php";
			include "modules/{$gateway}/menu.php";
		} else {
			//
		}
		// Display page
		echo "<html>
			<head>
				<title>Control Panel</title>
				<link rel=\"icon\" type=\"\" href=\"styles/icons/{$settings['favicon']}\" /> 
				<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"styles/icons/{$settings['favicon']}\" /> 
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admin/default.css\" />
				<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400italic' rel='stylesheet' type='text/css'>
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admin/toolbars/default.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/filedrop/default.css\" /> 
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/jquery/{$settings['acp_jquery_skin']}\" />
				<script type=\"text/javascript\">{$script_data}</script>
				<script type=\"text/javascript\" src=\"scripts/jquery.min.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.ui.min.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.ui.initiate.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.filedrop.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.filedrop.initiate.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.schemes.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/tiny_mce/tiny_mce_dev.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/tinymce.init.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/fix.js\"></script>
				<!--[if IE]>
					<script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>
				<![endif]-->
			</head>
			<body {$sundries}>
				{$toolbar}
				<div class=\"flexbox\">
					<div class=\"menu\">
						<div class=\"shadow\"></div>
						{$menu}
					</div>
					<div class=\"body\">
						<!--<h2 id=\"header\">{$header}</h2>-->
						{$body}
					</div>
				</div>
			</body>
		</html>";
		exit;
	}
	
	if (isset($continue) || $continue) {
		$title = "Control Panel";
		if (!isset($header) && isset($custom_header)) { $header = $custom_header; }
	}
	
?>
