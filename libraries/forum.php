<?php

	// Class Declaration
	class forum {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Display Forum Contents
		public function contents() {
			$result = $this->database->query("SELECT * FROM `content` WHERE `type`='forum' AND `shortname`='{$shortname}'");
			return "Contents will be displayed here.<br>\n";
		}
		
		// Display Forum
		public function display($shortname) {
			$result = $this->database->query("SELECT * FROM `content` WHERE `type`='forum' AND `shortname`='{$shortname}'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row["id"]) { $existence = array ("existence" => false); }
			else { $existence = array ("existence" => true); }
			return array_merge($row, $existence);
		}
		
		// Display Forum Menu
		public function menu() {
			$categories = $this->database->query("SELECT * FROM `content` WHERE `type` = 'category'");
			
			// Scroll through categories
			while($category = mysql_fetch_array($categories, MYSQL_ASSOC)) {
				
				// Gather Forums
				$forums = $this->database->query("SELECT * FROM `content` WHERE `type` = 'forum' AND `category` = '{$category["category"]}'");
				
				// Retreive Forum
				while($forum = mysql_fetch_array($forums, MYSQL_ASSOC)) {
					
					// Set if nonexistant
					if (!isset($list)) { $list = ""; }
					
					// Lookup last post
					
					// Lookup author info
					
					// Add all forums to list
					$list .= "<tr class=\"light\">
					<td><a href='?page=forums&forum={$forum['shortname']}'>{$forum['title']}</a></td>
					<td>&nbsp;Threads: {$forum['threads']}&nbsp;</td>
					<td>&nbsp;{$post['title']}&nbsp;</td>
					</tr>
					
					<tr class=\"dark\">
					<td>{$forum['description']}</td>
					<td>&nbsp;Posts: {$forum['posts']}&nbsp;</td>
					<td>&nbsp;by {$post['author']}&nbsp;</td>
					</tr> \n";
					
				}
				
				// Set if nonexistant
				if (!isset($menu)) { $menu = ""; }
				
				// Add full category to menu
				$menu .= "<thead>
					<tr>
						<th>{$category["title"]}</th>
						<th>Stats</th>
						<th>Last Post</th>
					</tr>
				</thead>
				<tbody>
					{$list}
				</tbody>";
				
				// Clear list before next category
				$list = "";
				
			}
			
			// Put data into tabular format
			$menu = "<table summary=\"Forum Menu\" cellpadding=\"0\" cellspacing=\"0\"> {$menu} </table> \n";
			
			// Return Menu
			return $menu;
		 
		}

	}
	
?>
