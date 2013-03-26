<?php
	
	class device {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Profile Variables
		function devices($id) {
			$output = array();
			$result = $this->database->query("SELECT * FROM `devices` WHERE `owner` ='{$id}'");
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$output[$row['id']] = $row;
			}
			mysql_free_result($result);
			return $output;
		}
		
		// Retreive Member ID
		public function lookup($meid) {
			$result = $this->database->query("SELECT * FROM `devices` WHERE `meid` = '{$meid}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if ($row) { $variable = $row['id']; }
			else { $variable = "error"; }
			mysql_free_result($result);
			return $variable;
		}
		
		// Member Variables
		public function vars($id) {
			$result = $this->database->query ("SELECT * FROM `devices` WHERE `id` ='{$id}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$output = $row;
			mysql_free_result($result);
			return $output;
		}
		
	}
	
?>
