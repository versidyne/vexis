<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// set active tab
	if (isset($curtab)) { $script_data .= "var curtab={$curtab};"; }
	else { $script_data .= "var curtab=0;"; }
	
	// highlight the current module
	$act[$highlight] = "active";
	
	// calculate totals
	//$notifications = $database->count("notifications");
	$comments = $database->count("comments");
	$members = $database->count("members");
	
	/*$menu = "<div class=\"logo\">
		<!--<h1>Vexis</h1>-->
		<!--<h2>Admin Panel</h2>-->
		<center><img src=\"styles/admin/images/logo.png\" width=\"168\" height=\"60\"></center>
	</div>";*/
	
	$menu = "<div class=\"menu\">
		<div class=\"shadow\"></div>
		<div id=\"sidebar\">
			<ul>
				<li class=\"{$act["dashboard"]}\"><a href=\"{$settings['acp_loc']}?page=dashboard\"><i class=\"icon icon-dashboard\"></i><span>Dashboard</span></a></li>";
	
	$amount = 1; $items = "";
	$result = $database->query("SELECT * FROM `settings` WHERE `type` = 'skin' ORDER BY `description` ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if ($row['variable']) {
			$amount++;
			$items .= "<li class=\"{$act[$row['variable']]}\"><a href='{$settings['acp_loc']}?page=editor&act=settings&variable={$row['variable']}'>{$row['description']}</a></li>";
		}
	}
	$menu .= "<li class=\"submenu {$act['appearance']}\">
		<a href=\"#\"><i class=\"icon icon-tint\"></i><span>Appearance</span></a>
		<ul>
			{$items}
			<li class=\"{$act["navbar"]}\"><a href=\"{$settings['acp_loc']}?page=editor&act=navbar\">Navbar</a></li>
		</ul>
	</li>
	<li class=\"{$act["comments"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=comments\"><i class=\"icon icon-comments\"></i><span>Comments</span><span class=\"label label-important\">{$comments}</span></a></li>
	<li class=\"{$act["forms"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=forms\"><i class=\"icon icon-th-list\"></i><span>Forms</span></a></li>
	<li class=\"{$act["errors"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=errors\"><i class=\"icon icon-pencil\"></i><span>Error Pages</span></a></li>
	<li class=\"{$act["galleries"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=galleries\"><i class=\"icon icon-picture\"></i><span>Galleries</span></a></li>
	<li class=\"{$act["media"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=media\"><i class=\"icon icon-film\"></i><span>Media</span></a></li>
	<li class=\"submenu {$act['members']}\">
		<a href=\"#\"><i class=\"icon icon-user\"></i><span>Members</span><span class=\"label label-important\">{$members}</span></a>
		<ul>
			<li class=\"{$act["navbar"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=members\">Accounts</a></li>
			<li class=\"{$act["navbar"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=groups\">Group Permissions</a></li>
		</ul>
	</li>
	<li class=\"{$act["news"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=news\"><i class=\"icon icon-pencil\"></i><span>News</span></a></li>
	<li class=\"{$act["pages"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=pages\"><i class=\"icon icon-pencil\"></i><span>Pages</span></a></li>
	<li class=\"{$act["products"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=products\"><i class=\"icon icon-shopping-cart\"></i><span>Products</span></a></li>
	<li class=\"submenu {$act['seo-tools']}\">
		<a href=\"#\"><i class=\"icon icon-search\"></i><span>SEO Tools</span></a>
		<ul>
			<li class=\"\"><a href=\"#\">Coming Soon</a></li>
		</ul>
	</li>";
	
	// Maintenance Settings
	$amount = 1; $items = "";
	$result = $database->query("SELECT * FROM `settings` WHERE `variable` = 'maintenance' ORDER BY `description` ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if ($row['variable']) {
			$amount++;
			$items .= "<li class=\"{$act[$row['variable']]}\"><a href='{$settings['acp_loc']}?page=editor&act=settings&variable={$row['variable']}'>{$row['description']}</a></li>";
		}
	}
	$menu .="<li class=\"submenu {$act['maintenance']}\">
		<a href=\"#\"><i class=\"icon icon-wrench\"></i><span>Maintenance</span></a>
		<ul>
			{$items}
			<li class=\"{$act["navbar"]}\"><a href=\"{$settings['acp_loc']}?page=info\">PHP Information</a></li>
		</ul>
	</li>";
	
	// General Settings
	/*$amount = 0; $items = "";
	$result = $database->query("SELECT * FROM `settings` WHERE `type` <> 'skin' ORDER BY `description` ASC");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if ($row['variable']) {
			$amount++;
			$items .= "<li class=\"{$act[$row['variable']]}\"><a href='{$settings['acp_loc']}?page=editor&act=settings&variable={$row['variable']}'>{$row['description']}</a></li>";
		}
	}
	$menu .="<li class=\"submenu {$act['settings']}\">
		<a href=\"#\"><i class=\"icon icon-cog\"></i><span>Settings</span><span class=\"label label-important\">{$amount}</span></a>
		<ul>
			{$items}
		</ul>
	</li>";*/
	$menu .="<li class=\"{$act["settings"]}\"><a href=\"{$settings['acp_loc']}?page=viewer&content=settings\"><i class=\"icon icon-cog\"></i><span>Settings</span></a></li>";
	
	// Help Icons
	/* <div id=\"info-1\" class=\"dialog\" title=\"Help: Appearance\"></div>
	 * <a href=\"#\" id=\"help-2\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span>
	 * <div id=\"info-2\" class=\"dialog\" title=\"Help: Content\"></div>
	 * <a href=\"#\" id=\"help-3\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a>
	 * <div id=\"info-3\" class=\"dialog\" title=\"Help: Customer Service\"></div>
	 * <a href=\"#\" id=\"help-4\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a>
	 * <div id=\"info-4\" class=\"dialog\" title=\"Help: Maintenance\"></div>
	 * <a href=\"#\" id=\"help-5\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a>
	 * <div id=\"info-5\" class=\"dialog\" title=\"Help: Members\"></div>
	 * <a href=\"#\" id=\"help-6\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a>
	 * <div id=\"info-6\" class=\"dialog\" title=\"Help: SEO Tools\"></div>
	 * <a href=\"#\" id=\"help-7\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a>
	 * <div id=\"info-7\" class=\"dialog\" title=\"Help: Settings\"></div>
	 * <a href=\"#\" id=\"help-8\" class=\"menu-link\">
	 * <span class=\"menu-icon ui-icon ui-icon-info\" title=\"Click for more info\"></span></a> */
	
	$data = new data();
	$script_loc = dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/';
	$disk_total = disk_total_space($script_loc);
	$disk_free = disk_free_space($script_loc);
	$disk_used = $disk_total - $disk_free;
	$disk_usage = (int) (($disk_used / $disk_total) * 100);
	$disk_total = $data->sizeunits($disk_total);
	$disk_used = $data->sizeunits($disk_used);
	
	// Progress Bars
	$menu .= "<li class=\"content\"> <span>Disk Space</span>
      <div class=\"progress progress-mini progress-danger active progress-striped\">
        <div style=\"width: {$disk_usage}%;\" class=\"bar\"></div>
      </div>
      <span class=\"percent\">{$disk_usage}%</span>
      <div class=\"stat\">{$disk_used} / {$disk_total}</div>
    </li>
    <li class=\"content\"> <span>Progress Bar Test</span>
      <div class=\"progress progress-mini active progress-striped\">
        <div style=\"width: 10%;\" class=\"bar\"></div>
      </div>
      <span class=\"percent\">10%</span>
      <div class=\"stat\">1000.00 / 10000 MB</div>
    </li>";
	
	// End of menu
	$menu .= "</ul>
		</div>
	</div>";
	
?>
