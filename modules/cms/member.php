<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// file info block
	// if info = true return data then exit
	// array( name = Member Control Panel, version = 1, timestamp = 000
	
	// Declare classes
	$data = new data();
	$info = new info();
	
	// Retreive credentials
	$credentials = $authentication->retreive_credentials($authentication->cookie_data($settings["cookie_prefix"]));
	$mvar = $member->vars($member->lookup($credentials["email"]));
	$gvar = $member->group($mvar["group"]);
	$allowed = explode(",", $gvar["allowed"]);
	
	// Retreive info
	$browser = $info->browser();
	//$system = $info->system();
	$extensions = "";
	
	foreach ($allowed as &$name) {
		if ($name != "member") {
			$extension = mysql_fetch_array($database->query("SELECT * FROM `content` WHERE `shortname` = '{$name}' LIMIT 1"), MYSQL_ASSOC);
			$extensions .= "<li><a href='?page={$extension['shortname']}'>{$extension['title']}</a></li>";
		}
	}
	
	$custom_tags = array ("<message>" => $settings['member_message'], "<notice>" => $settings['member_notice'], "<nickname>" => $mvar['nickname'], "<browser>" => $browser['upper'], "<version>" => $browser['version'], "<extensions>" => $extensions);
	
?>
