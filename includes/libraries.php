<?php
	
	function __autoload($class) {
		$library = "libraries/{$class}.php";
		if (file_exists($library)) {
			include_once $library;
		} else {
			echo "Unable to load library: {$class}"; exit;
		}
	}
	
	$config['security']['validator'] = md5($config['security']['key']);
	
	// Legacy Validation Variable
	$validator = array("key" => $config['security']['key'], "code" => md5($config['security']['key']));
	
?>
