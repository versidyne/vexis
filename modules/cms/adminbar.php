<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Lookup
	$mvar = $member->vars($member->lookup($credentials['email']));
	$hash = md5(strtolower(trim($credentials['email'])));
	$notifications = $database->count("notifications");
	$comments = $database->count("comments");
	
	// Display toolbar
	$sundries = "class=\"logged-in\"";
	$adminbar = "<nav id=\"admin-bar\">
		<ul>
			<li class=\"avatar\"><a href=\"#\" style=\"background: url(http://www.gravatar.com/avatar/{$hash}?s=30)\"></a></li>
			<li class=\"welcome\">Welcome, {$mvar['nickname']}! <a href=\"{$settings['website']}?page=logout\">logout</a></li>
		</ul>
		<ul class=\"controls\">
			<li class=\"icon\"><a href=\"{$settings['acp_loc']}?page=viewer&content=comments\" title=\"Comments\">d<span class=\"priority notice\">{$comments}</span></a></li>
			<li><a href=\"{$settings['acp_loc']}\">Notifications<span class=\"priority notice\">{$notifications}</span></a></li>
			<!--<li><a href=\"{$settings['acp_loc']}\">Messages<span class=\"priority notice\">{$messages}</span></a></li>-->
			<li><a href=\"{$settings['acp_loc']}?page=dashboard\">Dashboard</a></li>
			<!--<li><a href=\"#\">Profile</a></li>-->
			<li class=\"subcontrols\"><a href=\"#\">New</a>
				<ul>
					<!--<li><a href=\"#\">Error Page</a></li>-->
					<li><a href=\"{$settings['acp_loc']}?page=editor&act=form\">Form</a></li>
					<!--<li><a href=\"{$settings['acp_loc']}?page=editor&act=gallery\">Gallery</a></li>-->
					<!--<li><a href=\"#\">Media</a></li>-->
					<li><a href=\"{$settings['acp_loc']}?page=editor&act=page\">Page</a></li>
					<!--<li><a href=\"#\">Product</a></li>-->
					<li><a href=\"{$settings['acp_loc']}?page=editor&act=news\">News Post</a></li>
				</ul>
			</li>
			<!--<li><a href=\"#\">Settings</a></li>-->
		</ul>
		<ul class=\"controls\">
			<li class=\"icon\"><a href=\"{$settings['acp_loc']}\" class=\"priority\" title=\"Go to Admin Panel\">X</a></li>
		</ul>
		<ul class=\"search\">
			<li>
				<form action=\"#\" method=\"post\">
					<input type=\"search\" placeholder=\"Search...\" name=\"search\" />
					<button>L</button>
				</form>
			</li>
		</ul>
	</nav>";
	
?>

