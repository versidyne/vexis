<?php
	
	// Declare array
	$vfs = array();
	
	// Evaluate Virtual File System
	if (isset($_GET['vfs'])) {
		
		// Gather path data
		$vfs['path'] = $_GET['vfs'];
		
		// Split by token
		$vpath = explode("/", $vfs['path']);
		
		// Build names
		$vfs['parent'] = $vpath[0];
		$vfs['name'] = $vpath[1];
		
		// Backwards Compatibility
		if ($data->starts($vpath[0], "?")) {
			// possible alternative to keep away from data class: substr($vpath[0],0,1) == '?')
			// due to the url rewrite feature in lighttpd, only the first variable needs analysis
			// otherwise, ampersands would need to be handled in a multi-dimensional array
			$variable = explode("=", substr($vpath[0], 1));
			$_GET[$variable[0]] = $variable[1];
		} elseif ($vpath[0] == "pages") {
			$_GET['page'] = $vpath[1];
		} elseif ($vpath[0] == "products") {
			$_GET['product'] = $vpath[1];
		} else {
			// nothing yet
		}
	} else {
		// nothing yet
	}
	
?>
