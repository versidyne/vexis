<?php
	
	class form {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Parse Forms
		public function parse($shortname, $form_message = "") {
			$result = $this->database->query("SELECT * FROM `content` WHERE `type`='form' AND `shortname`='{$shortname}' LIMIT 1");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row["id"]) { $existence = array ("existence" => false); }
			else {
				$row['body'] = "<form {$row['sundries']}>
				$form_message 
				{$row['body']}
				</form>";
				$existence = array ("existence" => true);
			}
			return array_merge($row, $existence);
		}
		
	}
	
?>
