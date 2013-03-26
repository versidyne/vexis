<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	// Retreive Variables
	$pvar = $member->profile($member->lookup($credentials['email']));

	// Check if form has been submitted

	if ($_POST['submit'] == "true") {

		// Update profile
		$database->query("UPDATE `profiles` SET `birthday` = '{$_POST['birthday_input']}', `homepage` = '{$_POST['homepage_input']}', `aim` = '{$_POST['aim_input']}', `msn` = '{$_POST['msn_input']}', `yahoo` = '{$_POST['yahoo_input']}', `biography` = '{$_POST['biography_input']}', `location` = '{$_POST['location_input']}', `interests` = '{$_POST['interests_input']}', `occupation` = '{$_POST['occupation_input']}' WHERE `id` ='{$pvar['id']}' LIMIT 1");

		// Retreive New Variables
		$pvar = $member->profile($member->lookup($credentials['email']));

		// Show that the settings were saved
		$form_message = "Settings saved successfully.<br><br>";

	}

	// Create tags & values

	$custom_tags = array("<birthday>", "<homepage>", "<aim>", "<msn>", "<yahoo>", "<biography>", "<location>", "<interests>", "<occupation>");
	$custom_values = array($pvar['birthday'], $pvar['homepage'], $pvar['aim'], $pvar['msn'], $pvar['yahoo'], $pvar['biography'], $pvar['location'], $pvar['interests'], $pvar['occupation']);

?>
