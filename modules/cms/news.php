<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	if ($_GET['output']) {
		
		if ($_GET['output'] == "atom") {
			// nothing yet
		}
		else {
			
			// Load Classes
			$feed = new markup("xml");
			
			// Create Feed Page
			$rss_title = "{$settings['company']} - News";
			$rss_link = "{$settings['website']}?page=news&amp;output=rss";
			$news_link = "{$settings['website']}?page=news";
			$rss_description = "News related to our company and its assets.";
			$rss_category = "News";
			$rss_image = false;
			$rss_image_title = "Test";
			$rss_image_url = "Test";
			$rss_image_link = "Test";
			$rss_image_width = "Test";
			$rss_image_height = "Test";
			
			$mvar = $member->vars($member->lookup($settings['admin_email']));
			$webmaster = "{$mvar['email']} ({$mvar['nickname']})";
			
			// Display feed
			$feed->header();
			echo $feed->details($rss_title, $rss_link, $rss_description, $settings['language'], $settings['copyright'], $webmaster, $rss_category, $rss_image, $rss_image_title, $rss_image_url, $rss_image_link, $rss_image_width, $rss_image_height);
			
			// Display items
			$result = $database->query ("SELECT * FROM content WHERE `type` = 'news' ORDER BY `timestamp` DESC");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$mvar = $member->vars($row['author']);
				//$gmt_date = gmdate("D, d M Y H:i:s", $row['timestamp'])." GMT";
				$gmt_date = gmdate("D, d M Y H:i:s", $row['timestamp'])." +0000";
				$description = $row['body'];
				$description = str_replace("<", "&lt;", $description);
				$description = str_replace(">", "&gt;", $description);
				echo $feed->item($gmt_date, $row['title'], $description, "{$news_link}&amp;post={$row['id']}", "{$mvar['email']} ({$mvar['nickname']})", "{$news_link}&amp;post={$row['id']}");
			}
			mysql_free_result($result);
			
			// Display footer
			echo $feed->footer();
			//$raw_data = "true";
			exit;
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
