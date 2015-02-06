<?php
	
	// Instead of changing skins, css styles will be all that is altered
	
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
		/*header ("Location: {$settings["website"]}?page=member");
		if ($page != "login") { header ("Location: {$settings["acp_loc"]}?page=login"); }*/
		$page = "login";
	}
	
	$tab = array();
	$tab["appearance"] = 0;
	$tab["content"] = 1;
	$tab["customer"] = 2;
	$tab["maintenance"] = 3;
	$tab["members"] = 4;
	$tab["seo-tools"] = 5;
	$tab["settings"] = 6;
	
	$module = array();
	$module["loc"]  = "modules/{$gateway}/{$page}.php";
	$module["name"] = "{$page}";
	if (file_exists($module["loc"])) {
		include $module["loc"];
	} else {
		$custom_header = "Nonexistent";
		$body = "We apologize, but this page does not exist.";
	}
	
	/*if ($body) { $raw = true; $custom_body = "<div class='editor'>".$body."</div>"; }
	if ($row) { $row = ""; }
	$custom_body = "<div class='editor'>".$body."</div>";
	$raw = true;*/
	
	if (!isset($continue) || !$continue) {
		if ($page != "login") {
			include "modules/{$gateway}/toolbar.php";
			include "modules/{$gateway}/menu.php";
		}
		if (isset($redir)) {
			header("Location: {$redir}");
		}
		echo "<html>
			<head>
				<title>Control Panel</title>
				<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
				<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400italic' rel='stylesheet' type='text/css'>
				<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
				<link rel=\"icon\" type=\"\" href=\"styles/icons/{$settings['favicon']}\" /> 
				<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"styles/icons/{$settings['favicon']}\" /> 
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admin/toolbars/default.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admin/sidebars/default.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/admin/default.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/font-awesome/font-awesome.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/bootstrap/bootstrap.css\" media=\"screen\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/jquery/core.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/jquery/{$settings['acp_jquery_skin']}/jquery-ui.min.css\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/filedrop/default.css\" /> 
				<script type=\"text/javascript\">{$script_data}</script>
				<script type=\"text/javascript\" src=\"scripts/bootstrap.min.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.min.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.ui.min.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.ui.initiate.js\"></script>
				<script type=\"text/javascript\" src=\"styles/admin/scripts/sidebar.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.filedrop.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.filedrop.initiate.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/jquery.schemes.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/tiny_mce/tiny_mce_dev.js\"></script>
				<script type=\"text/javascript\" src=\"scripts/tinymce.init.js\"></script>
				<!--<script type=\"text/javascript\" src=\"scripts/fix.js\"></script>-->
				<!--[if IE]>
					<script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>
				<![endif]-->
			</head>
			<body {$sundries}>
				{$toolbar}
				<div class=\"flexbox\">
					{$menu}
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
