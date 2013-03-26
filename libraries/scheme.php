<?php

	// Class Declaration
	class scheme {
		
		private $database = false;
		private $scheme = false;
		public function __construct($database) { $this->database = $database; }
		
		// Build Array
		public function build($table) {
			$scheme = array();
			$result = $this->database->query("SELECT * FROM `schemes` WHERE `table`='{$table}'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if (!$row['data']) { $scheme[$row['attribute']]; }
				else { $scheme[$row['attribute']] = explode(",", $row['data']); }
			}
			$this->scheme = $scheme;
			return true;
		}
		
		// Translate Numerical Data
		public function translate($attribute, $value) {
			if ($this->scheme[$attribute][$value] ==  NULL) { return $value; }
			else { return $this->scheme[$attribute][$value]; }
		}

	}
	
?>
