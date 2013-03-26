<?php
	
	if ($_GET['file']) {
		$result = $database->query("SELECT * FROM `files` WHERE `enabled`='1' AND `name`='{$_GET['file']}' LIMIT 1");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		if (!$row["enabled"]) {
			echo 0;
		}
		elseif ($row["node"] > 0) {
			$node = new node($row["node"]);
			header ("Location: http://{$node['hostname']}/files/{$row["type"]}/{$row["src"]}");
		}
		else {
			header ("content-type: {$row["mime"]}");
			echo file_get_contents("files/{$row["type"]}/{$row["src"]}");
		}
	}
	else {
		echo 0;
	}
	exit;
	
?>
