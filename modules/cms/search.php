<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	if (isset($_GET['query'])) {
		
		// Variables
		$counter = 0;
		$search = array();
		
		// Search Database
		$search['title'] = $database->search("content", "title", $_GET['query']);
		$search['body'] = $database->search("content", "body", $_GET['query']);
		//$search['bios'] = $database->search("biographies", "stage", $_GET['query']);
		
		// Title Results
		while ($result = mysql_fetch_array($search['title'])) {
			$counter = bcadd($counter, 1);
			if ($result['title'] == "") { if ($result['header'] != "") { $result['title'] = $result['header']; } else { $result['title'] = "Unknown Title"; } }
			if ($result['shortname'] == "" && $result['type'] == 'news') { $result['shortname'] = "news"; }
			$result_desc = substr($result['body'],0,$settings['search_desc_length']);
			$result_desc = htmlentities($result_desc);
			$results .= "<a href='{$settings['website']}?page={$result['shortname']}'><b>{$result['title']}</b></a><br>{$result_desc}...<br><br>";
		}
		
		// Content Results
		while ($result = mysql_fetch_array($search['body'])) {
			$counter = bcadd($counter, 1);
			if (is_null($result['title'])) { $result['title'] = "Unknown Title"; }
			$result_desc = substr($result['body'],0,$settings['search_desc_length']);
			$result_desc = htmlentities($result_desc);
			$results .= "<a href='{$settings['website']}?page={$result['shortname']}'><b>{$result['title']}</b></a><br>{$result_desc}...<br><br>";
		}
		
		// Biography Results
		/*while ($result = mysql_fetch_array($search['bios'])) {
			$counter = bcadd($counter, 1);
			if (is_null($result['stage'])) { $result['stage'] = "Unknown Name"; }
			$result_desc = substr($result['description-long'],0,$settings['search_desc_length']);
			$result_desc = htmlentities($result_desc);
			$results .= "<a href='{$settings['website']}?page=biographies&'><b>{$result['title']}</b></a><br>{$result_desc}...<br><br>";
		}*/
		
		// Generate return
		$stcounter = strval((int)$counter);
		$totals = "Your search returned {$stcounter} results. <br><br>";
		$custom_tags = array("<query>" => $_GET['query'], "<totals>" => $totals, "<results>" => $results);
		
	}
	else { $custom_tags = array("<query>" => $_GET['query']); }
	
?>
