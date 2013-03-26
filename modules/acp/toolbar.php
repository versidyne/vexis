<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Lookup
	$mvar = $member->vars($member->lookup($credentials['email']));
	$hash = md5(strtolower(trim($credentials['email'])));
	//$notifications = $database->count("notifications");
	$comments = $database->count("comments");
	$messages = 0;
	
	// Display toolbar
	$sundries = "class=\"toolbar\"";
	$toolbar = "<div id=\"toolbar\">
		<div id=\"logo\"></div>
		<div id=\"user-nav\">
			<ul class=\"nav\">
				<li class=\"dropdown\" id=\"profile-messages\" ><a title=\"\" href=\"#\" data-toggle=\"dropdown\" data-target=\"#profile-messages\" class=\"dropdown-toggle\">
					<i class=\"icon icon-user\"></i><span class=\"text\">Welcome {$mvar['nickname']}</span><b class=\"caret\"></b></a>
					<ul class=\"dropdown-menu\">
						<li><a href=\"#\"><i class=\"icon-user\"></i> My Profile</a></li>
						<li class=\"divider\"></li>
						<li><a href=\"#\"><i class=\"icon-check\"></i> My Tasks</a></li>
						<li class=\"divider\"></li>
						<li><a href=\"login.html\"><i class=\"icon-key\"></i> Log Out</a></li>
					</ul>
				</li>
				<li class=\"dropdown\" id=\"menu-messages\"><a href=\"#\" data-toggle=\"dropdown\" data-target=\"#menu-messages\" class=\"dropdown-toggle\">
					<i class=\"icon icon-envelope\"></i> <span class=\"text\">Messages</span> <span class=\"label label-important\">{$messages}</span><b class=\"caret\"></b></a>
					<ul class=\"dropdown-menu\">
						<li><a class=\"sAdd\" title=\"\" href=\"#\"><i class=\"icon-plus\"></i> new message</a></li>
						<li class=\"divider\"></li>
						<li><a class=\"sInbox\" title=\"\" href=\"#\"><i class=\"icon-envelope\"></i> inbox</a></li>
						<li class=\"divider\"></li>
						<li><a class=\"sOutbox\" title=\"\" href=\"#\"><i class=\"icon-arrow-up\"></i> outbox</a></li>
						<li class=\"divider\"></li>
					<li><a class=\"sTrash\" title=\"\" href=\"#\"><i class=\"icon-trash\"></i> trash</a></li>
					</ul>
				</li>
				<li class=\"\"><a title=\"\" href=\"#\"><i class=\"icon icon-cog\"></i> <span class=\"text\">Settings</span></a></li>
				<li class=\"\"><a title=\"\" href=\"{$settings['acp_loc']}?page=logout\"><i class=\"icon icon-share-alt\"></i> <span class=\"text\">Logout</span></a></li>
			</ul>
		</div>
		<!--<div id=\"search\">
			<input type=\"text\" placeholder=\"Search here...\"/>
			<button type=\"submit\" class=\"tip-bottom\" title=\"Search\"><i class=\"icon-search icon-white\"></i></button>
		</div>-->
	</div>";
	
?>

