<?php

	// Class Declaration
	class limbo {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Display Biography Contents
		public function contents() {
			$result = $this->database->query("SELECT * FROM `biographies` WHERE `first`='{$first}'");
			return "Contents will be displayed here.<br>\n";
		}
		
		// Display Biography
		public function display($first) {
			$result = $this->database->query("SELECT * FROM `biographies` WHERE `first`='{$first}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row["id"]) { $existence = array ("existence" => false); }
			else { $existence = array ("existence" => true); }
			return array_merge($row, $existence);
		}
		
		// Display Forum Menu
		public function menu() {
			
			// Gather Forums
			$biographies = $this->database->query("SELECT * FROM `biographies`");
			
			// Retreive Forum
			while($biography = mysql_fetch_array($biographies, MYSQL_ASSOC)) {
				
				// Set if nonexistant
				if (!isset($list)) { $list = ""; }
				
				// Lookup last post
				
				// Lookup author info
				
				// Add all forums to list
				$list .= "<tr class=\"light\">
				<td><a href='?page=biographies&biography={$biography['first']}'>{$biography['first']}</a></td>
				<td>&nbsp;Views: {$biography['views']}&nbsp;</td>
				</tr>
				
				<tr class=\"dark\">
				<td>{$biography['description']}</td>
				<td>&nbsp;Rating: {$biography['rating']}&nbsp;</td>
				</tr> \n";
				
			}
			
			// Set if nonexistant
			if (!isset($menu)) { $menu = ""; }
			
			// Add full category to menu
			$menu .= "<thead>
				<tr>
					<th>Name</th>
					<th>Stats</th>
				</tr>
			</thead>
			<tbody>
				{$list}
			</tbody>";
			
			// Put data into tabular format
			$menu = "<table summary=\"Biography Menu\" cellpadding=\"0\" cellspacing=\"0\"> {$menu} </table> \n";
			
			// Return Menu
			return $menu;
		 
		}
		
		// Translate Numerical Data
		public function translate($type, $value) {
			$result = $this->database->query("SELECT * FROM `biographies_scheme` WHERE `first`='{$first}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row["id"]) { $existence = array ("existence" => false); }
			else { $existence = array ("existence" => true); }
			return array_merge($row, $existence);
		}

	}
	
?>
