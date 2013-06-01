<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Default tab
	$curtab = $tab["content"];
	
	// Grab request
	$content = $_GET["content"];
	$highlight = $content;
	
	// Generate type settings
	if ($content == "articles") {
		$table = "content";
		$sundries = "WHERE `type` = 'article'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "blogs") {
		$table = "content";
		$sundries = "WHERE `type` = 'blog'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "categories") {
		$table = "content";
		$sundries = "WHERE `type` = 'category'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "comments") {
		//$curtab = $tab["customer"];
		$table = "comments";
		$order = "timestamp";
		$action = "comment-edit";
	} elseif ($content == "errors") {
		$table = "content";
		$sundries = "WHERE `type` = 'error'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "forms") {
		$table = "content";
		$sundries = "WHERE `type` = 'form'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "galleries") {
		$table = "content";
		$sundries = "WHERE `type` = 'gallery'";
		$order = "title";
		$action = "gallery";
	} elseif ($content == "groups") {
		$curtab = $tab["members"];
		$table = "groups";
		$order = "name";
		$action = "group-edit";
	} elseif ($content == "media") {
		$table = "files";
		$order = "name";
		$action = "media-edit";
	} elseif ($content == "members") {
		$curtab = $tab["members"];
		$table = "members";
		$order = "nickname";
		$action = "member-edit";
	} elseif ($content == "news") {
		$table = "content";
		$sundries = "WHERE `type` = 'news'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "pages") {
		$table = "content";
		$sundries = "WHERE `type` = 'page'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "products") {
		$table = "content";
		$sundries = "WHERE `type` = 'product'";
		$order = "title";
		$action = "content-edit";
	} elseif ($content == "settings") {
		$curtab = $tab["customer"];
		$table = "settings";
		$order = "description";
		$action = "settings";
	} else {
		$unknown = true;
		//$table = "content";
		//$order = "id";
		//$action = "content-edit";
	}
	
	// Run query
	if (!$unknown) { $result = $database->query("SELECT * FROM `{$table}` {$sundries} ORDER BY `{$order}` ASC"); }
	
	// Begin Viewer
	$body .= "<table class=\"table table-bordered table-striped table-hover viewer\">";
	
	// Build Tables
	if ($table == "comments") {
		$body .= "<thead>
			<th>Type</th>
			<th>Date</th>
			<th>Author</th>
			<th>Parent</th>
			<th>Body</th>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td>";
			// Type Column
			if ($row['type'] != NULL) { $body .= "{$row['type']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Date Column
			if ($row['timestamp'] != NULL && $row['timestamp'] > 0) {
				$body .= gmdate("D, d M Y H:i:s", $row['timestamp'])." GMT";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Author Column
			if ($row['author'] != NULL && $row['author'] > 0) {
				$mvar = $member->vars($row['author']);
				$body .= "<a href=\"{$settings['website']}?page=member-list&member={$row['author']}\">{$mvar['nickname']}</a>";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Parent Column
			if ($row['parent'] != NULL && $row['parent'] > 0) { $body .= "{$row['parent']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Body Column
			if ($row['body'] != NULL) { $body .= "{$row['body']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";
		}
		$body .= "</tbody>";
	} elseif ($table == "content") {
		$body .= "<thead>
			<tr>
				<th>Title</th>
				<th>Author</th>
				<th>Date</th>
				<th>Visible</th>
			</tr>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td>";
			// Title Column
			if ($row['title'] != NULL) { $body .= "<a href=\"{$settings['acp_loc']}?page=editor&act={$action}&id={$row['id']}\">{$row['title']}</a>";
			} elseif ($row['header'] != NULL) { $body .= "<a href=\"{$settings['acp_loc']}?page=editor&act={$action}&id={$row['id']}\">{$row['header']}</a>";
			} else { $body .= "<a href=\"{$settings['acp_loc']}?page=editor&act={$action}&id={$row['id']}\">Unknown</a>"; }
			$body .= "</td>
			<td>";
			// Author Column
			if ($row['author'] != NULL && $row['author'] > 0) {
				$mvar = $member->vars($row['author']);
				$body .= "<a href=\"{$settings['website']}?page=member-list&member={$row['author']}\">{$mvar['nickname']}</a>";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Date Column
			if ($row['timestamp'] != NULL && $row['timestamp'] > 0) {
				$body .= gmdate("D, d M Y H:i:s", $row['timestamp'])." GMT";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Visible Column
			if ($row['enabled'] != NULL) {
				if ($row['enabled'] == "1") { $checked = "checked"; } else { $checked = ""; }
				//if ($row['enabled'] == "1") { $body .= "Yes"; } else { $body .= "No"; }
				$body .= "<input type=\"checkbox\" name=\"enabled\" value=\"true\" {$checked} />";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";
		}
		$body .= "</tbody>";
	} elseif ($table == "files") {
		$body .= "<thead>
			<th>Name</th>
			<th>Mime</th>
			<th>Date</th>
			<th>Node</th>
			<th>Visible</th>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td>";
			// Name Column
			if ($row['name'] != NULL) { $body .= "{$row['name']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Mime Column
			if ($row['mime'] != NULL) { $body .= "{$row['mime']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Date Column
			if ($row['timestamp'] != NULL && $row['timestamp'] > 0) {
				$body .= gmdate("D, d M Y H:i:s", $row['timestamp'])." GMT";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Node Column
			if ($row['node'] != NULL) { $body .= "{$row['node']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Visible Column
			if ($row['enabled'] != NULL) { $body .= "{$row['enabled']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";
		}
		$body .= "</tbody>";
	} elseif ($table == "groups") {
		$body .= "<thead>
			<th>Name</th>
			<th>Allowed</th>
			<th>Restricted</th>
			<th>Special</th>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td>";
			// Name Column
			if ($row['name'] != NULL) { $body .= "{$row['name']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Allowed Column
			if ($row['allowed'] != NULL) { $body .= "{$row['allowed']}";
			} else { $body .= "None"; }
			$body .= "</td>
			<td>";
			// Restricted Column
			if ($row['restricted'] != NULL) { $body .= "{$row['restricted']}";
			} else { $body .= "None"; }
			$body .= "</td>
			<td>";
			// Special Column
			if ($row['special'] != NULL) { $body .= "{$row['special']}";
			} else { $body .= "None"; }
			$body .= "</td>
			</tr>";
		}
		$body .= "</tbody>";
	} elseif ($table == "members") {
		$body .= "<thead>
			<th>Group</th>
			<th>Email</th>
			<th>Nickname</th>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td>";
			// Group Column
			if ($row['group'] != NULL) { $body .= "{$row['group']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Email Column
			if ($row['email'] != NULL) { $body .= "{$row['email']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Nickname Column
			if ($row['nickname'] != NULL) { $body .= "{$row['nickname']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";
		}
		$body .= "</tbody>";
	} elseif ($table == "settings") {
		$body .= "<thead>
			<th>Variable</th>
			<th>Value</th>
		</thead>
		<tbody>";
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$body .= "<tr>
			<td class=\"{$row['priority']}\">";
			// Variable Column
			if ($row['variable'] != NULL) {
				if ($row['description'] != NULL) { $body .= "<a href=\"{$settings['acp_loc']}?page=editor&act=settings&variable={$row['variable']}\">{$row['description']}</a>";
				} else { $body .= "<a href=\"{$settings['acp_loc']}?page=editor&act=settings&variable={$row['variable']}\">{$row['variable']}</a>"; }
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Value Column
			if ($row['value'] != NULL) { $body .= "{$row['value']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";
			/*$body .= "</td>
			<td>";
			// Type Column
			if ($row['type'] != NULL) { $body .= "{$row['type']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			<td>";
			// Category Column
			if ($row['category'] != NULL) { $body .= "{$row['category']}";
			} else { $body .= "Unknown"; }
			$body .= "</td>
			</tr>";*/
		}
		$body .= "</tbody>";
	} else {
		$body .= "<thead>
			<th>Request</th>
		</thead>
		<tbody>
			<tr>
				<td>Unknown</td>
			</tr>
		</tbody>";
	}
	
	// End Viewer
	$body .= "</table>";
	
?>
