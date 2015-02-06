<?php
	
	$vfs = array();
	
	if (isset($_SERVER['REQUEST_URI'])) {
		
		$vfs['path'] = $_SERVER['REQUEST_URI'];
		$vpath = explode("/", $vfs['path']);
		
		$vfs['parent'] = $vpath[1];
		$vfs['name'] = $vpath[2];
		
		// Backwards Compatibility (Temporary)
		$_GET[$vfs['parent']] = $vfs['name'];
		
	} else {
		// nothing yet
	}
	
?>
