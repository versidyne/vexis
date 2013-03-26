<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	if ($_GET['member']) {
		// Verify member
		$vars = $member->vars($_GET['member']);
		if (!$vars) {
			$custom_title = "Member's Profile";
			$custom_header = "Member's Profile";
			$custom_body = "This profile does not exist.";
		}
		else {
			// Retreive Information
			$group = $member->group($_GET['member']);
			$profile = $member->profile($_GET['member']);
			
			// Generate hash
			$hash = md5(strtolower(trim($vars['email'])));
			
			$custom_title = "Member's Profile ({$vars["nickname"]})";
			$custom_header = "{$vars["nickname"]}'s Profile";
			$custom_body = "<img src=\"http://www.gravatar.com/avatar/{$hash}?s=160\"><br><br>
			Group: {$group['name']} <br>";
			
			if ($profile['id']) {
				$custom_body .= "Name: {$profile['first_name']} {$profile['last_name']} <br>
				Birthday: {$profile['birthday']} <br>
				Homepage: <a href='{$profile['homepage']}' target='_blank'>{$profile['homepage']}</a> <br>
				Aim Screen Name: <a href='aim:GoIM?ScreenName={$profile['aim']}'>{$profile['aim']}</a> <br>
				MSN Screen Name: <a href='msnim:chat?contact={$profile['msn']}'>{$profile['msn']}</a> <br>
				Yahoo Screen Name: <a href='ymsgr:sendIM?{$profile['yahoo']}'>{$profile['yahoo']}</a> <br>
				Biography: {$profile['biography']} <br>
				Location: {$profile['location']} <br>
				Interests: {$profile['interests']} <br>
				Occupation: {$profile['occupation']}";
			}
			
		}

	}
	
	else {
		// Retrieve Member List
		$members = $database->query ("SELECT * FROM members");
		while ($member = mysql_fetch_array($members, MYSQL_ASSOC)) { $list .= " \n <li><a href='?page=member-list&member=".$member['id']."'>".$member['nickname']."</li>"; }
		mysql_free_result($members);
		
		// Display Member List
		$custom_title = "Member List";
		$custom_header = "Member List";
		$custom_body = "Click on a user below to view their profile.<br> \n <ul> {$list} \n </ul> \n";
	}
	
?>
