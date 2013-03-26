<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	/*$script_data = "var curtab = \"#navigation\";";
	$header = "<h2>General Help</h2>";
	$body = "This feature is under construction.  Information on each feature will be here soon.";
	$body .= "<div id=\"dialog\" title=\"Under Construction\">
		<p>This feature is currently undergoing construction.  We appreciate your cooperation with this matter and look forward to any feedback.<br>
		<br>
		Thank You,<br>
		Administration</p>
	</div>";*/
	
	$topic = $_GET["topic"];
	
	if ($topic == "1") {
		echo "Settings in this category alter the Look and Feel of this Admin Panel and the main Website.";
	} elseif ($topic == "2") {
		echo "Options in this category alter the main content within the website.";
	} elseif ($topic == "3") {
		echo "Options in this category ease interfacing between the Administration and the End Users.";
	} elseif ($topic == "4") {
		echo "Settings in this category work to perform much needed maintenance to the website's database.<br><br>Note: Prior to performing maintenance, locking the website is highly recommended to avoid errors.";
	} elseif ($topic == "5") {
		echo "Options in this category alter members and their permissions.";
	} elseif ($topic == "6") {
		echo "Settings in this category alter how Search Engines view the main Website.";
	} elseif ($topic == "7") {
		echo "Settings in this category alter various portions of the website."; 	
	} else {
		echo "The requested topic does not exist.  We apologize for this inconvenience.";
	}
	
	exit;
	
?>
