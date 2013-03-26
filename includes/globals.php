<?php
	
	// Ensure Global Variables are Registered
	/*if (!ini_get('register_globals')) {
	    $superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
	    if (isset($_SESSION)) { array_unshift($superglobals, $_SESSION); }
	    foreach ($superglobals as $superglobal) { extract($superglobal, EXTR_SKIP); }
	}*/
	
	$_SGET = array();
	$_SPOST = array();
	
	foreach ($_GET as $getkey => $getvalue) {
		//echo "Key: $getkey; Value: $getvalue<br />\n";
		$_SGET[$getkey] = stripslashes($getvalue);
		//echo "Key: $getkey; Slash Value: $_GET[$getkey]<br />\n";
		$_SGET[$getkey] = mysql_real_escape_string($getvalue);
		//echo "Key: $getkey; Escape Value: $_GET[$getkey]<br />\n";
	}
	
	foreach ($_POST as $postkey => $postvalue) {
		//echo "Key: $postkey; Value: $postvalue<br />\n";
		if (!is_array($postvalue)) {
			$_SPOST[$postkey] = stripslashes($postvalue);
			//echo "Key: $postkey; Slash Value: $_POST[$postkey]<br />\n";
			$_SPOST[$postkey] = mysql_real_escape_string($postvalue);
			//echo "Key: $postkey; Escape Value: $_POST[$postkey]<br />\n";
		}
	}
	
?>
