<?php
	
	// This is meant to be the traffic cop of the installation process
	// This file will access others and install various aspects of the system
	
	// Other files:
	
	// Contains a single file to judge a system and act as a hook
	// This hook will then verify requirements, licensing, and download the file
	// Once the file has been downloaded, it will extract to a specific location
	// From there it will switch to the installer file
	
	// Contains a shell script or batch script, possibly executable to guide initial
	// setup for those who don't have HTTP, MySQL, FTP, etc, installed on their server
	// This will be a pre-hook for those who are quite out in the cold
	
?>
