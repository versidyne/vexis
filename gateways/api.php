<?php
	
	// declare protocol constants
	$markup = "xml";
	$column = "<|(column)|>";
	$row = "<|(row)|>";
	$cell = "<|(cell)|>";
	
	if ($_GET['session']) {
		$member = new member($database);
		$device = new device($database);
		$credentials = $authentication->retreive_credentials($_GET['session']);
		$auth_login = $authentication->authenticate_login($credentials['identifier'], $credentials['key']);
		$auth_device = $authentication->authenticate_device($credentials['identifier'], $credentials['key']);
		if ( $auth_login || $auth_device ) {
			
			// login only functions
			if ($auth_login) {
				// gather member id
				$member_id = $member->lookup($credentials['identifier']);
				if ($_GET['meid'] && $_GET['sim']) {
					// make sure row doesn't exist
					$device = $database->create_row("devices");
					$database->query("UPDATE `devices` SET `owner` = '{$member_id}', `meid` = '{$_GET['meid']}', `sim` = '{$_GET['sim']}' WHERE `id` = '{$device}'");
					$output = 1;
				}
			}
			
			// device only functions
			if ($auth_device) {
				// gather device owner and device id
				$device_id = $device->lookup($credentials['identifier']);
				$device = $device->vars($device_id);
				$member_id = $device['owner'];
				if ($_GET['meid'] && $_GET['sim']) { $output = 2; }
				if ($_GET['latitude'] && $_GET['longitude']) {
					// make sure row doesn't exist
					$coo_entry = $database->create_row("coordinates");
					$timestamp = time();
					$database->query("UPDATE `coordinates` SET `device` = '{$device_id}', `timestamp` = '{$timestamp}', `units` = 'imperial', `accuracy` = '{$_GET['accuracy']}', `altitude` = '{$_GET['altitude']}', `bearing` = '{$_GET['bearing']}', `latitude` = '{$_GET['latitude']}', `longitude` = '{$_GET['longitude']}', `speed` = '{$_GET['speed']}' WHERE `id` = '{$coo_entry}'");
					$output = 1;
				}
			}
			
			// common functions
			if ($_GET['info']) {
				if ($_GET['info'] == "contacts") {
					$output = "{$row}{$cell}User 1{$cell}online";
					$output .= "{$row}{$cell}User 2{$cell}offline";
					$output .= "{$row}{$cell}User 3{$cell}online";
				}
				elseif ($_GET['info'] == "encpass") { $output = "IneEedDBetteERSECUurity!@##$%!()"; }
				elseif ($_GET['info'] == "profile") {
					$mvar = $member->vars($member->lookup($credentials['email']));
					$output = "{$cell}" + $mvar["group"] + "{$cell}" + $mvar["nickname"] + "{$cell}";
				}
				elseif ($_GET['info'] == "serverlocation") {
					$ip = "12.227.124.171";
					$port = "7900";
					$output = $ip.":".$port;
				}
				elseif ($_GET['info'] == "serveronline") { $output = 1; }
				elseif ($_GET['info'] == "applist") {
					$output = "{$row}{$cell}Instant Messenger{$cell}0.0.2.0{$cell}http://www.versidyne.com/?act=download&product_name=Client&version=0.0.2.0\n";
					$output .= "{$row}{$cell}Framework{$cell}0.0.3.0{$cell}http://www.versidyne.com/?act=download&product_name=ShadowAir&version=0.0.3.0\n";
					$output .= "{$row}{$cell}Updater{$cell}0.0.1.0{$cell}http://www.versidyne.com/?act=download&product_name=ShadoWorld&version=0.0.1.0\n";
				}
				elseif ($_GET['info'] == "channels") {
					$output = "{$row}{$cell}Main{$cell}public";
					$output .= "{$row}{$cell}Programming{$cell}private";
					$output .= "{$row}{$cell}>Personal{$cell}public";
				}
			}
			
			//if ($directory) {
				// Retreive File Array
				// Check for indexes by priority
				// Include php or html file
			//}
			
		}
	}
	else {
		if ($_GET['login']) {
			if ($authentication->authenticate_login($_GET['login'], md5($_GET['pass']))) { $output = $authentication->create_session($_GET['login'], md5($_GET['pass'])); }
		}
		if ($_GET['meid']) {
			if ($authentication->authenticate_device($_GET['meid'], $_GET['sim'])) { $output = $authentication->create_session($_GET['meid'], $_GET['sim']); }
		}
	}
	
	if ($_GET['info']) {
		$info = new info();
		if ($_GET['info'] == "ip") { $output = $_SERVER['REMOTE_ADDR']; }
		elseif ($_GET['info'] == "port") { $output = $_SERVER['REMOTE_PORT']; }
		elseif ($_GET['info'] == "hostname") { $output = gethostbyaddr($_SERVER['REMOTE_ADDR']); }
		elseif ($_GET['info'] == "servername") { $output = gethostname(); }
		elseif ($_GET['info'] == "uastring") { $output = $_SERVER['HTTP_USER_AGENT']; }
		elseif ($_GET['info'] == "browser") { $output = $info->browser(); }
		elseif ($_GET['info'] == "system") { $output = $info->system(); }
	}
	
	if (!$output) { $output = 0; }
	
	echo $output;
	exit;
	
?>
