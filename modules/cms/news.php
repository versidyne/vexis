<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// TODO: Gather News template from Skin Table
	
	if ($_GET['output']) {
		
		if ($_GET['output'] == "atom") {
			
			// Load Classes
			$feed = new markup("atom");
			
		} elseif ($_GET['output'] == "rss") {
			
			// Load Classes
			$feed = new markup("rss");
			
			// Load Variables
			$mvar = $member->vars($member->lookup($settings['admin_email']));
			
			// Gather Information
			$info["category"] = "News";
			$info["copyright"] = $settings['copyright'];
			$info["description"] = "News related to our company and its assets.";
			//$info["feed_link"] = "{$settings['website']}?page=news&amp;output=rss";
			$info["image"] = false;
			$info["image_title"] = "Test";
			$info["image_url"] = "Test";
			$info["image_link"] = "Test";
			$info["image_width"] = "Test";
			$info["image_height"] = "Test";
			$info["language"] = $settings['language'];
			$info["link"] = "{$settings['website']}?page=news";
			$info["title"] = "{$settings['brand']} - News";
			$info["webmaster"] = "{$mvar['email']} ({$mvar['nickname']})";
			
			// Generate Feed
			$feed->header();
			$feed->details($info);
			$result = $database->query ("SELECT * FROM content WHERE `type` = 'news' ORDER BY `timestamp` DESC");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$mvar = $member->vars($row['author']);
				//$gmt_date = gmdate("D, d M Y H:i:s", $row['timestamp'])." GMT";
				$gmt_date = gmdate("D, d M Y H:i:s", $row['timestamp'])." +0000";
				$description = $row['body'];
				$description = str_replace("<", "&lt;", $description);
				$description = str_replace(">", "&gt;", $description);
				$feed->item($gmt_date, $row['title'], $description, "{$info['link']}&amp;post={$row['id']}", "{$mvar['email']} ({$mvar['nickname']})", "{$info['link']}&amp;post={$row['id']}");
			}
			mysql_free_result($result);
			$feed->footer();
			
			// Display Feed
			echo $feed->export();
			exit;
			//$raw_data = "true";
			
		}
	}
	
	else {
		
		if ($_GET['post']) {
			$news = $database->query("SELECT * FROM `content` WHERE `type` = 'news' AND `id` = '{$_GET['post']}'");
		}
		else {
			// Find the last page id in the database.
			/*$last_id = $database->last_tid("content", "news");
			if ($last_id > 10) { $start_id = bcadd($last_id, -3); }
			elseif ($last_id < 3) { $nolimit = true; }
			elseif ($last_id == 3) { $start_id = bcadd($last_id, -2); }
			$end_id = $last_id;*/
			
			// Retrieve News List
			//if ($nolimit == true) { $news = $database->query("SELECT * FROM `content` WHERE `type` = 'news'"); }
			//else {
				$sort = "`timestamp`";
				$order = "DESC";
				$limit = 10;
				$offset = 0;
				if ($limit > 0) { $params = "LIMIT {$offset},{$limit}"; }
				$news = $database->query("SELECT * FROM `content` WHERE `type` = 'news' ORDER BY {$sort} {$order} {$params}");
			//}
		}
		
		while ($article = mysql_fetch_array($news, MYSQL_ASSOC)) {
			$mvar = $member->vars($article["author"]);
			$gmt_date = gmdate("D, d M Y H:i:s", $article["timestamp"]);
			//$list .= "<h3><a href=\"{$settings['website']}?page=news&post={$article["id"]}\">{$article["title"]}</a></h3>
			//<p>{$article["body"]}</p>
			//<p>Posted on: <i>{$gmt_date} GMT </i> by <i><a href='{$settings['website']}?page=member-list&member={$mvar["id"]}'>{$mvar["nickname"]}</a></i></p>";
			$list .= "<a href=\"{$settings['website']}?page=news&post={$article["id"]}\">{$article["title"]}</a><br>
			{$article["body"]}<br>
			Posted on: <i>{$gmt_date} GMT </i> by <i><a href='{$settings['website']}?page=member-list&member={$mvar["id"]}'>{$mvar["nickname"]}</a></i><br>";
		}
		
		mysql_free_result($result_news);
		
		// Create News Page
		$custom_title = "News";
		$custom_body = "{$list}";
		$raw = true;
		//$layout = "news";
		
	}
	
?>
