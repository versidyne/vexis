<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Retreive Variables
	$mvar = $member->profile($member->lookup($credentials['email']));
	
	// Check if profile row exists, otherwise force creation
	
	// Check if form has been submitted
	if ($_POST['submit'] == "true") {
		$database->query("UPDATE `profiles` SET `birthday` = '{$_POST['birthday_input']}', `homepage` = '{$_POST['homepage_input']}', `aim` = '{$_POST['aim_input']}', `msn` = '{$_POST['msn_input']}', `yahoo` = '{$_POST['yahoo_input']}', `biography` = '{$_POST['biography_input']}', `location` = '{$_POST['location_input']}', `interests` = '{$_POST['interests_input']}', `occupation` = '{$_POST['occupation_input']}' WHERE `id` ='{$pvar['id']}' LIMIT 1");
		$mvar = $member->profile($member->lookup($credentials['email']));
		$form_message = "Settings saved successfully.<br><br>";
	}
	
	// Create profile
	if ($_GET['act'] == "create") {
		// Check for row before creation
		$database->create_row("member_profiles", $mvar['id']);
		$form_message = "You may now access your profile from the Member Control Panel.";
	}
	
	// Create tags & values
	$custom_tags = array("<birthday>", "<homepage>", "<aim>", "<msn>", "<yahoo>", "<biography>", "<location>", "<interests>", "<occupation>");
	$custom_values = array($pvar['birthday'], $pvar['homepage'], $pvar['aim'], $pvar['msn'], $pvar['yahoo'], $pvar['biography'], $pvar['location'], $pvar['interests'], $pvar['occupation']);
	
?>
