<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Lookup
	$mvar = $member->vars($member->lookup($credentials['email']));
	$hash = md5(strtolower(trim($credentials['email'])));
	//$notifications = $database->count("notifications");
	$comments = $database->count("comments");
	$tickets = $database->count("tickets");
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
	
	/*<nav id=\"admin-bar\">
		<ul>
			<li class=\"avatar\"><a href=\"#\" style=\"background: url(http://www.gravatar.com/avatar/{$hash}?s=30)\"></a></li>
			<li class=\"welcome\">Welcome, {$mvar['nickname']}! <a href=\"{$settings['acp_loc']}?page=logout\">logout</a></li>
		</ul>
		<ul class=\"controls\">
			<li class=\"icon\"><a href=\"{$settings['acp_loc']}?page=viewer&content=comments\" title=\"Comments\">d<span class=\"priority notice\">{$comments}</span></a></li>
			<!--<li><a href=\"#\">Notifications<span class=\"priority notice\">{$notifications}</span></a></li>-->
			<li><a href=\"{$settings['acp_loc']}?page=viewer&content=tickets\">Tickets<span class=\"priority notice\">{$tickets}</span></a></li>
			<li><a href=\"{$settings['acp_loc']}?page=dashboard\">Dashboard</a></li>
			<!--<li><a href=\"#\">Profile</a></li>-->
			<li class=\"more\"><a href=\"#\">New</a>
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
			<li class=\"icon\"><a href=\"{$settings['website']}?page=member\" class=\"priority\" title=\"Return to Website\">X</a></li>
		</ul>
		<ul class=\"search\">
			<li>
				<form action=\"#\" method=\"post\">
					<input type=\"search\" placeholder=\"Search...\" name=\"search\" />
					<button>L</button>
				</form>
			</li>
		</ul>
	</nav>*/
	
?>

