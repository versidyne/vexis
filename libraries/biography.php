<?php

	// Class Declaration
	class biography {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Display Biography
		public function display($id) {
			$result = $this->database->query("SELECT * FROM `biographies` WHERE `id`='{$id}' LIMIT 1");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row["id"]) { $existence = array ("existence" => false); }
			else { $existence = array ("existence" => true); }
			return array_merge($row, $existence);
		}
		
		// Display Biography Menu
		public function menu($order = "ASC", $sort = "`id`", $limit = 0, $offset = 0) {
			if ($limit > 0) { $params = "LIMIT {$offset},{$limit}"; }
			$result = $this->database->query("SELECT * FROM `biographies` ORDER BY {$sort} {$order} {$params}");
			return $result;
		}

	}
	
?>
