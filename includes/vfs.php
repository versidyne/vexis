<?php
	
	// Declare array
	$vfs = array();
	
	// Evaluate Virtual File System
	if (isset($_SERVER['REQUEST_URI'])) {
		
		// Gather path data
		$vfs['path'] = $_SERVER['REQUEST_URI'];
		
		// Split by token
		$vpath = explode("/", $vfs['path']);
		
		// Build names
		$vfs['parent'] = $vpath[1];
		$vfs['name'] = $vpath[2];
		
		// Backwards Compatibility (Temporary)
		$_GET[$vfs['parent']] = $vfs['name'];
		
	} else {
		// nothing yet
	}
	
?>
