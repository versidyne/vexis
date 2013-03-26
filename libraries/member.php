<?php

	class member {
		
		private $database = false;
		private $id = 0;
		
		public function __construct($database) { $this->database = $database; }
		
		// property twiddling
		function setid($id) { $this->id = $id; }
		
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
		
		// Group Variables
		function group($id) {
			$result = $this->database->query("SELECT * FROM `groups` WHERE `id` ='{$id}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$output = $row;
			mysql_free_result($result);
			return $output;
		}

		// Retreive Member ID
		public function lookup($email) {
			$result = $this->database->query("SELECT * FROM `members` WHERE `email` = '{$email}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if ($row) { $variable = $row['id']; }
			else { $variable = "error"; }
			mysql_free_result($result);
			return $variable;
		}

		// Profile Variables
		function profile($id) {
			$result = $this->database->query("SELECT * FROM `profiles` WHERE `id` ='{$id}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$output = $row;
			mysql_free_result($result);
			return $output;
		}
		
		// Member Variables
		public function vars($id) {
			$result = $this->database->query ("SELECT * FROM `members` WHERE `id` ='{$id}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$output = $row;
			mysql_free_result($result);
			return $output;
		}
		
		// Allowed Modules
		public function permissions($id, $type, $target) {
			if ($id == "error") { $vars = array("group" => 7); }
			else { $vars = $this->vars($id); }
			$group = $this->group($vars["group"]);
			$permissions = explode(",", $group[$type]);
			if (in_array($target, $permissions)) {$output = true;}
			else {$output = false;}
			return $output;
		}
		
	}

?>
