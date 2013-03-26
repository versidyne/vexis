<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	//Send some headers to keep the user's browser from caching the response.
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/xml; charset=utf-8");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>\n";
	
	///Make sure that a value was sent.
	if (isset($_GET['query']) && $_GET['query'] != '') {
		
		//$search = addslashes($_GET['search']);
		//$_GET['query'] = strtolower($_GET['query']);
		
		// Category beginning
		echo "<pages style=\"MEDIUM\">\n";
		
		// Display Pages
		$result = $database->query ("SELECT * FROM `content` WHERE `title` LIKE '%{$_GET['query']}%'");
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "<page>\n";
			echo "<title>{$row['title']}</title>\n";
			//echo "<description>{$row['description']}</description>";
			echo "</page>\n";
		}
		
		// Display Biographies
		/*$result = $database->query ("SELECT * FROM `biographies` WHERE `stage` LIKE '%{$_GET['query']}%'");
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "<page>\n";
			echo "<title>{$row['stage']}</title>\n";
			//echo "<description>{$row['description']}</description>";
			echo "</page>\n";
		}
		
		// End categories
		echo "</pages>\n";*/
		
		// Gather suggestions
		/*$result = $database->query ("SELECT * FROM `search` WHERE `value` LIKE '%{$_GET['query']}%'");
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) { echo $row['value'] . "\n"; }*/
		
	}
	// Discontinue
	exit;
	
?>
