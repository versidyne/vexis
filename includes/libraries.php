<?php
	
	// Load Packages
	function __autoload($class) {
		$library = "libraries/{$class}.php";
		if (file_exists($library)) {
			include_once $library;
		} else {
			echo "Unable to load library: {$class}"; exit;
		}
	}
	
	// Set Validation Variable
	$config['security']['validator'] = md5($config['security']['key']);
	
	// Legacy Validation Variable
	$validator = array("key" => $config['security']['key'], "code" => md5($config['security']['key']));
	
	// Legacy Library Loader
	/*$libdir = opendir("libraries");
	while ($fn = readdir($libdir)) { if (substr($fn, -4, 4) == ".php") { require "libraries" . "/" . $fn; } }
	closedir($libdir);*/
	
?>
