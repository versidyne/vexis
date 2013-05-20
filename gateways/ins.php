<?php
	
	// This is meant to be the gateway of the installation process
	// This file will access modules and install various aspects of the system, much like the admin gateway
	
	// Vexis Tools:
	
	// Contains a shell script or batch script, possibly executable to guide initial
	// setup for those who don't have HTTP, MySQL, FTP, etc, installed on their server
	// This will be a pre-hook for those who are quite out in the cold
	
	// Downloader:
	
	// Contains a single file to judge a system and act as a hook.
	// This hook will then verify requirements and download the file
	// Once the file has been downloaded, it will extract to the requested location
	// From there it will switch to the installer file
	
	// This will import the template file into the database
	$template = 'includes/template.sql';
	$templine = '';
	$lines = file($template);
	foreach ($lines as $line) {
		if (substr($line, 0, 2) == '--' || $line == '') { continue; }
		$templine .= $line;
		if (substr(trim($line), -1, 1) == ';') {
			$database->query($templine);
			$templine = '';
		}
	}
	
?>
