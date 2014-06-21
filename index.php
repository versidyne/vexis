<?php
	
	// Handle Microseconds
	function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	// Gather start time
	$time = array();
	$time["start"] = microtime_float();
	
	// Include core files
	$config = array();
	require "includes/config.php";
	require "includes/libraries.php";
	$time["includes"] = microtime_float();
	
	// Declare Classes
	$data = new data();
	$time["classes"] = microtime_float();
	
	// Connect and Select Database
	$database = new database($config['developer']['debug'], $config['database']['type']);
	$database->connect($config['database']['host'], $config['database']['user'], $config['database']['pass']);
	$database->select($config['database']['name']);
	$time["database"] = microtime_float();
	
	// Handle children
	$child = $database->child($_SERVER['HTTP_HOST']);
	if ($child != false) {
		if ($child["redir"] != NULL) { header("Location: ".$child["redir"].$settings["args"]); }
		if ($child["username"] != NULL) { $database->connect($config['database']['host'], $child["username"], $child["password"]); }
		//else { $database->connect($host, $user, $pass); }
		if ($child["database"] != $database) { $database->select($child["database"]); }
		$gateway = $child["type"];
	}
	$time["children"] = microtime_float();
	
	// Decrypt virtual directories
	require "includes/vfs.php";
	$time["vfs"] = microtime_float();
	
	// Secure Global Variables
	require "includes/globals.php";
	$time["globals"] = microtime_float();
	
	// Generate Settings
	$settemp  = new settings($database);
	$settings = $settemp->generate();
	$time["settings"] = microtime_float();
	
	// Use HTTP Authentication if enabled
	$authentication  = new authentication($database);
	if ($settings['http_auth'] == "true") {
		$authentication->http();
	}
	$time["authentication"] = microtime_float();
	
	// Load skins and customize
	$skin = new skin($database);
	$skin->customize($settings['skin']);
	$time["customize"] = microtime_float();

    // Retreive credentials
    $credentials = $authentication->retreive_credentials($authentication->cookie_data($settings["cookie_prefix"]));
    $time["credentials"] = microtime_float();

    // Generate Member Information
    $member = new member($database);
    $mvar = $member->vars($member->lookup($credentials["email"]));
    $gvar = $member->group($mvar["group"]);
    $pvar = $member->profile($mvar["id"]);
    $allowed = explode(",", $gvar["allowed"]);
    $time["member"] = microtime_float();
	
	// Load extensions as top level additions
	
	// Set gateway defaults
	if (!isset($gateway)) {
		if ($config['defaults']['gateway'] == NULL) { $gateway = "cms"; }
		else { $gateway = $config['defaults']['gateway']; }
	}
	
	// Include gateway
	if (file_exists("gateways/{$gateway}.php")) { require "gateways/{$gateway}.php"; }
	else { echo "The requested gateway does not exist."; exit; }
	$time["gateway"] = microtime_float();
	
	// Check for Data
	if (isset($page_name)) {
		
		// Load page as string
		if ($raw_data == true) { $template = $page_name; }
		else { $template = file_get_contents($page_name); }
		$time["template"] = microtime_float();
		
		if (!isset($raw)) { $raw = NULL; }
		if (!isset($script_data)) { $script_data = "var curtab=false;"; }
		
		// Set scroll loader variables
		$script_data .= "var page='{$page}';var load_animation='{$settings["load_animation"]}';var load_increment='{$settings["load_increment"]}';";

        // CDN Variables
		$imglink = "<img src={$settings['media_cdn']}?file=";
		$medialink = "{$settings['media_cdn']}?file=";

        // Virtual File System
        if ($settings['vfs'] == "true") { $subdir = "pages/"; } else { $subdir = "?page="; }
		
		// Create skin tags and values
		$tags = array(
			"{headers}" => $skin->headers(),
			"{clock}" => $skin->clock($settings),
			"{navbar}" => $skin->navbar($page, $settings['vfs']),
			"{navrev}" => $skin->navbar($page, $settings['vfs'], true),
			"{breadcrumbs}" => $skin->breadcrumbs($page),
			"{featured}" => $skin->featured(),
			"{login}" => $skin->login($settings, $page),
			"{newspreview}" => $skin->news(),
			"{newslist}" => $skin->newslist(),
			"{onlineusers}" => $skin->online($settings),
			"{search}" => $skin->search($settings),
			"{sponsors}" => $skin->sponsors($settings),
			"{donations}" => $settings['donations'],
			"{content}" => $skin->content($header, $body, $raw),
			"{title}" => $title,
			"{header}" => $header,
			"{body}" => $body,
			"{adminbar}" => $adminbar,
			"{sundries}" => $sundries,
			"{date}" => $settings['current_date'],
			"{footer}" => $settings['footer'],
			"{skin}" => $settings['skin'],
			"{favicon}" => $settings['favicon'],
			"{jqueryskin}" => $settings['jquery_skin'],
			"{brand}" => $settings['brand'],
			"{slogan}" => $settings['slogan'],
			"{copyright}" => $settings['copyright'],
			"{domain}" => $settings['domain'],
			"{website}" => $settings['website'],
			"{email}" => $data->retreive_cookie($settings, "email"),
			"{name}" => "{$pvar['first']} {$pvar['last']}",
			"{hash}" => md5(strtolower(trim($mvar['email']))),
            "{vfs}" => $subdir,
			"{script-data}" => $script_data,
			"{google-analytics}" => $settings['google_analytics'],
			"{image:" => $imglink,
			"{media:" => $medialink
		);
		// add <year> above
		$time["skin tags"] = microtime_float();
		
		// Construct the Custom Tag Array for older modules
		if (isset($custom_tags) && isset($custom_values) && ($custom_tags != "")) {
			foreach ($custom_tags as $key => $value) { $custom_tags_temp[$value] = $custom_values[$key]; }
			$custom_tags = $custom_tags_temp;
		}
		elseif (isset($custom_tags) && ($custom_tags != "")) { /* do nothing */ }
		else { $custom_tags = ""; }
		$time["custom tags"] = microtime_float();
		
		// Replace skin tags with the values
		$formatted = $skin->parse($tags, $custom_tags, $template);
		$time["format"] = microtime_float();
		
		// Display generated code
		echo $formatted;
		
	}
	
	// Load plugins as bottom level code
	// Needs some sort of hooks entered into various
	// parts of a skin to have output be injected into
	// based on another set of tags
	
	// Gather time difference
	$time["complete"] = microtime_float();
	
	// Display time differences
	foreach( $time as $section => $delay){
		$sdelay = substr($delay-$time["start"], 0, 7);
		echo "\n<!--{$section} generated in {$sdelay} seconds-->";
	}
	
?>
