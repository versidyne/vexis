<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// default variables
	$act = $_GET['act'];
	$continue = false;
	$header = "File Editor";
	$mvar = $member->vars($member->lookup($credentials['email']));
	$timestamp = time();
	$safe = array("&apos;");
	$unsafe = array("'");
	$curtab = $tab["content"];
	
	// navbutton sort
	if (isset($_POST['navsort'])) {
		$list = $_POST['navsort'];
		for ($i = 0; $i < count($list); $i++) {
			$n = $i+1;
			$database->query("UPDATE `content` SET `navbutton` = {$n} WHERE `id` = '{$list[$i]}'");
		}
		exit;
	}
	// navsub sort
	if (isset($_POST['navsubsort'])) {
		$list = $_POST['navsubsort'];
		for ($i = 0; $i < count($list); $i++) {
			$n = $i+1;
			$database->query("UPDATE `content` SET `navsub` = {$n} WHERE `id` = '{$list[$i]}'");
		}
		exit;
	}
	// remove apostrophes
	$_POST['body'] = str_replace($unsafe, $safe, $_POST['body']);
	// content control
	if ($act == "content-edit") {
		$custom_header = "Content Editor";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			if ($_POST['action'] == "code") {
				$database->query("UPDATE `content` SET `author` = '{$mvar['id']}', `timestamp` = '{$timestamp}', `title` = '{$_POST['title']}', `header` = '{$_POST['title']}', `body` = '{$_POST['body']}', `description` = '{$_POST['description']}', `redir` = '{$_POST['redir']}', `shortname` = '{$_POST['shortname']}' WHERE `id` = '{$_POST['id']}'");
			}
			elseif ($_POST['action'] == "codeform") {
				$database->query("UPDATE `content` SET `author` = '{$mvar['id']}', `timestamp` = '{$timestamp}', `title` = '{$_POST['title']}', `header` = '{$_POST['title']}', `sundries` = '{$_POST['sundries']}', `body` = '{$_POST['body']}', `description` = '{$_POST['description']}', `redir` = '{$_POST['redir']}', `shortname` = '{$_POST['shortname']}' WHERE `id` = '{$_POST['id']}'");
			}
			else {
				$raw_body = "The database action was unsuccessful.";
				$no_tabs= true;
				$continue = true;
			}
			$raw_body = "The database action was successful.";
			$no_tabs = true;
			$continue = true;
		}
		else {
			$result = $database->query("SELECT * FROM `content` WHERE `id` = '{$_GET['id']}'");
			$row = mysql_fetch_assoc($result);
			// design tab
			/*$design = "<div class=\"demo\" style=\"position:absolute; \">
			<div id=\"draggable\" class=\"ui-widget-content\" style=\"width:100px; height:100px;\"><p>Drag me to my target</p></div>
			<div id=\"droppable\" class=\"ui-widget-header\" style=\"width:150px; height:150px;\"><p>Drop here</p></div>
			</div><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<p>This is a preview of a draggable design feature.</p>";*/
			// code tab
			$design = "<form method=post action='{$settings['acp_loc']}?page=editor&act=content-edit'>
				<input type='hidden' name='submit' value='true'>";
			if ($row['type'] == "form") { $design .= "<input type='hidden' name='action' value='codeform'>"; }
			else { $design .= "<input type='hidden' name='action' value='code'>"; }
			$design .= "<input type='hidden' name='id' value='{$_GET['id']}'>
			<div class=\"table\" style=\"width:100%\">
				<div class=\"row\">
					<div class=\"cell\">
						<input style=\"width:100%\" type='text' name='title' placeholder=\"Enter title here\" value='{$row['title']}'>
					</div>
				</div>
				<div class=\"row\">
					<div class=\"cell\">{$settings['website']}pages/<input style=\"width:auto\" type='text' name='shortname' placeholder=\"Enter name here\" value='{$row['shortname']}'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><textarea style=\"width:100%\" class='user_input' name='body' rows='50'>{$row['body']}</textarea></div>
				</div>";
			// remove issue causing characters
			$row['body'] = htmlentities($row['body']);
			// main body depending on type
			if ($row['type'] == "form") {
				$design .= "<div class=\"row\">
					<div class=\"cell\"><input style=\"width:100%\" type='text' name='sundries' placeholder=\"Enter attributes here\" value='{$row['sundries']}'></div>
				</div>";
			}
			$design .= "<div class=\"row\">
					<div class=\"cell\" style=\"width:100%\"><input style=\"width:100%\" type='text' name='description' placeholder=\"Enter description here\" value='{$row['description']}'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><input style=\"width:100%\" class='user_input' type='text' name='redir' placeholder=\"Enter redirect url here\" value='{$row['redir']}'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\">
						<button class=\"btn btn-primary\" type=\"submit\" title=\"Save Changes\" name=\"save\">Save</button>
						<button class=\"btn btn-danger\" type=\"reset\" title=\"Remove Changes\" name=\"reset\">Reset</button>
					</div>
				</div>
			</div>
			</form>";
			$raw_body = $design;
			$no_tabs= true;
		}
	}
	elseif ($act == "content-delete") {
		$custom_header = "Content Remover";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			$database->query("DELETE FROM `content` WHERE `id` = '{$_POST['id']}' LIMIT 1");
			$raw_body = "The database action was successful.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$result = $database->query("SELECT * FROM `content` WHERE `id` = '{$_GET['id']}'");
			$row = mysql_fetch_assoc($result);
			// delete tab
			$delete = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=content-delete'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='id' value='{$_GET['id']}'>
			Only continue if you are 100% sure that you want to permanently delete: {$row['title']}<br><br>
			<input class='button' type='submit' value='Confirm Delete' title='Confirm Delete'/>
			</form>";
			mysql_free_result($result);
			$raw_body = $delete;
			$no_tabs= true;
		}
	}
	// content create
	elseif ($act == "page") {
		$custom_header = "Content Creator";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			$new_page = bcadd($database->last_id("content"), 1);
			$database->query("INSERT INTO `content` (`id`, `type`, `title`, `header`, `body`, `redir`, `shortname`) VALUES ('{$new_page}', 'page', '{$_POST['title']}', '{$_POST['title']}', '{$_POST['body']}', '{$_POST['redir']}', '{$_POST['shortname']}')");
			$raw_body = "The database action was successful.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$new = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=page'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='action' value='new'>
			<div class=\"table\">
				<div class=\"row\">
					<div class=\"cell\"><input style=\"width:98%\" type='text' name='title' placeholder='Enter title here'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><textarea style=\"width:98%\" name='body' rows='50'></textarea></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><input style=\"width:98%\" type='text' name='redir' placeholder='Enter Redirect URL here'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><input style=\"width:98%\" type='text' name='shortname' placeholder='Enter Page Name here'></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\"><button class=\"btn btn-primary\" type=\"submit\" title=\"Create a page\">Create</button></div>
				</div>
			</div>
			</form>";
			$raw_body = $new;
			$no_tabs= true;
		}
	}
	elseif ($act == "form") {
		$custom_header = "Form Creator";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			$new_page = bcadd($database->last_id("content"), 1);
			$database->query("INSERT INTO `content` (`id`, `type`, `title`, `header`, `body`, `redir`, `shortname`) VALUES ('{$new_page}', 'form', '{$_POST['title']}', '{$_POST['header']}', '{$_POST['body']}', '{$_POST['redir']}', '{$_POST['shortname']}')");
			$raw_body = "The database action was successful.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$new = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=form'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='action' value='new'>
			<div class=\"table\">
			<div class=\"row\">
			<div class=\"cell\">Title: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='title' size='25' value=''></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Header: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='header' size='25' value=''></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Body: </div>
			<div class=\"cell\"><textarea class='user_input' name='body' cols='60' rows='15'></textarea></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Redirect: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='redir' size='25' value=''></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Page Name: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='shortname' size='25' value=''></div>
			</div>
			</div>
			<br><input class='button' type='submit' value='Create' title='Create a page'>
			</form>";
			$raw_body = $new;
			$no_tabs= true;
		}
	}
	elseif ($act == "gallery") {
		$custom_header = "Gallery Uploader";
		if ($_POST['submit'] == "true"){
			// Retreive Member Variables
			$mvar = $member->vars($member->lookup($credentials['email']));
			$timestamp = time();
			$new_post = bcadd($database->last_id("content"), 1);
			// Run Query
			$database->query("INSERT INTO `content` (`id`, `type`, `timestamp`, `author`, `category`, `title`, `body`) VALUES ('{$new_post}', 'news', '{$timestamp}', '{$mvar['id']}', '{$_POST['category']}', '{$_POST['title']}', '{$_POST['content']}')");
			$raw_body = "The database action was successful.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$raw_body = "<div id=\"dropbox\"><span class=\"message\">Drop images here to upload.<br><i>(they will only be visible to you)</i></span></div>";
			$raw_body .= "<div id=\"dialog\" title=\"Under Construction\"><p>This feature is only a demonstration of what picture uploading will look and act like.  This is not a working feature.</div>";
			$no_tabs = true;
			$raw = true;
			$continue = false;
			$layout = "wide";
		}
	}
	elseif ($act == "news") {
		$custom_header = "News Post";
		if ($_POST['submit'] == "true"){
			$new_post = bcadd($database->last_id("content"), 1);
			$database->query("INSERT INTO `content` (`id`, `type`, `timestamp`, `author`, `category`, `title`, `body`) VALUES ('{$new_post}', 'news', '{$timestamp}', '{$mvar['id']}', '{$_POST['category']}', '{$_POST['title']}', '{$_POST['content']}')");
			/*echo "<html><head>
			<title>Control Panel</title>
			<meta http-equiv='refresh' content='3;url={$settings['website']}?page=admin&module=main'>
			</head>
			<body>The database action was successful.</body>
			</html>"; exit;*/
			$raw_body = "The database action was successful.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$new = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=news'>
			<input type='hidden' name='submit' value='true'>
			<div class=\"table\">
			<div class=\"row\">
			<div class=\"cell\">Category: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='category' size='25' value=''></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Title: </div>
			<div class=\"cell\"><input class='user_input' type='text' name='title' size='25' value=''></div>
			</div>
			<div class=\"row\">
			<div class=\"cell\">Content: </div>
			<div class=\"cell\"><textarea class='user_input' name='content' cols='60' rows='15'></textarea></div>
			</div>
			</div>
			<br><input class='button' type='submit' value='Create' title='Create a News Post'>
			</form>";
			$raw_body = $new;
			$no_tabs= true;
		}
	}
	// misc
	elseif ($act == "member-edit") {
		$custom_header = "Member Editor";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			/*if ($_POST['action'] == "new") {
				$new_page = bcadd($database->last_id("content"), 1);
				$database->query("INSERT INTO `content` (`id`, `type`, `title`, `header`, `body`, `redir`, `shortname`) VALUES ('{$new_page}', 'page', '{$_POST['title']}', '{$_POST['header']}', '{$_POST['body']}', '{$_POST['redir']}', '{$_POST['shortname']}')");
			}
			elseif ($_POST['action'] == "code") {
				$database->query("UPDATE `content` SET `title` = '{$_POST['title']}', `header` = '{$_POST['header']}', `body` = '{$_POST['body']}', `description` = '{$_POST['description']}', `redir` = '{$_POST['redir']}', `shortname` = '{$_POST['shortname']}', `navbutton` = '{$_POST['navbutton']}' WHERE `id` = '{$_POST['id']}'");
			}
			elseif ($_POST['action'] == "codeform") {
				$database->query("UPDATE `content` SET `title` = '{$_POST['title']}', `header` = '{$_POST['header']}', `action` = '{$_POST['actioninput']}', `method` = '{$_POST['method']}', `enctype` = '{$_POST['enctype']}', `name` = '{$_POST['name']}', `onsubmit` = '{$_POST['onsubmit']}', `table` = '{$_POST['table']}', `description` = '{$_POST['description']}', `redir` = '{$_POST['redir']}', `shortname` = '{$_POST['shortname']}', navbutton = '{$_POST['navbutton']}' WHERE `id` = '{$_POST['id']}'");
			}
			else {
				$raw_body = "The database action was unsuccessful.";
				$no_tabs= true;
				$continue = true;
			}*/
			$raw_body = "This feature is currently under development.";
			$no_tabs= true;
			$continue = true;
		}
		else {
			$result = $database->query("SELECT * FROM `members` WHERE `id` = '{$_GET['id']}'");
			$row = mysql_fetch_assoc($result);
			// code tab
			$code = "<div class=\"table\"><form method=post action='{$settings['acp_loc']}?page=editor&act=member-edit'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='action' value='code'>
			<input type='hidden' name='id' value='{$_GET['id']}'>
			<div class=\"row\">
				<div class=\"cell\">Group: </div>
				<div class=\"cell\">{$row['group']}</div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">Email: </div>
				<div class=\"cell\"><input class='user_input' type='text' name='email' size='25' value='{$row['email']}'></div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">Nickname: </div>
				<div class=\"cell\"><input class='user_input' type='text' name='nickname' size='25' value='{$row['nickname']}'></div>
			</div>
			<div class=\"row\">
				<div class=\"cell\">Associates: </div>
				<div class=\"cell\"><input class='user_input' type='text' name='associates' size='25' value='{$row['associates']}'></div>
			</div>
			<br>
			<input class='button' type='submit' value='Save' title='Save Changes'>
			</form></div>";
			$code .= "<div id=\"dialog\" title=\"Under Construction\"><p>This feature is currently undergoing heavy development and will not be functional until it is complete.</div>";
			mysql_free_result($result);
		}
	}
	elseif ($act == "navbar") {
		$curtab = $tab["content"];
		$highlight = "navbar";
		// Navbar tab
		$navbar = "<ul id=\"sortable\" class=\"sortable\">";
		$result = $database->query("SELECT * FROM content WHERE `navbutton` > 0 ORDER BY `navbutton` ASC");
		while ($navbutton = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if ($navbutton['title'] != NULL) { $navname = $navbutton['title']; }
			elseif ($navbutton['header'] != NULL) { $navname = $navbutton['header']; }
			else { $navname = "Unknown Title"; }
			$navbar .= "<li id=\"navsort_{$navbutton['id']}\" class=\"ui-state-default\">
				<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
				{$navname}
			</li>";
		}
		$navbar .= "</ul><p>This list can be sorted by dragging and dropping the names above.</p>";
		mysql_free_result($result);
		// Navsub tab
		$navsub = "<ul id=\"sortable-2\" class=\"sortable\">";
		$result = $database->query("SELECT * FROM content WHERE `navparent` > 0 ORDER BY `navsub` ASC");
		while ($navbutton = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if ($navbutton['title'] != NULL) { $navname = $navbutton['title']; }
			elseif ($navbutton['header'] != NULL) { $navname = $navbutton['header']; }
			else { $navname = "Unknown Title"; }
			$navsub .= "<li id=\"navsubsort_{$navbutton['id']}\" class=\"ui-state-default\">
				<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
				{$navname}
			</li>";
		}
		$navsub .= "</ul><p>This list can be sorted by dragging and dropping the names above.</p>";
		mysql_free_result($result);
	}
	elseif ($act == "schemes") {
		$uctable = ucfirst($_GET['table']);
		$custom_header = "{$uctable} Scheme Editor";
		if ($_POST['submit'] == "true"){
			// Run Query
			if ($_POST['insert'] == "design"){
				$raw_body = "The database action is under construction.";
			}
			if ($_POST['insert'] == "new"){
				$database->query("INSERT INTO `schemes` (`table`, `attribute`, `type`, `data`, `enabled`) VALUES ('{$_POST['table']}', '{$_POST['attribute']}', '{$_POST['type']}', '{$_POST['data']}', '{$_POST['enabled']}')");
				$raw_body = "The database action was successful.";
			}
			$no_tabs= true;
			$continue = true;
		}
		else {
			$design = "<div id=\"dialog\" title=\"Under Construction\">
				<p>The \"Design\" portion of this system is undergoing heavy construction and will be completed as soon as possible.  In the mean time, the \"New\" tab is fully functioning and will work for additions to schemes.  We appreciate your cooperation with this matter and look forward to any feedback.<br>
				<br>
				Thank You,<br>
				Administration</p>
				</div>";
			$design .= "<form method='post' action='{$settings['acp_loc']}?page=editor&act=schemes'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='insert' value='design'>
			<input type='hidden' name='table' value='{$_GET['table']}'>
			<div class=\"table\" id=\"newrows\">
				<div class=\"row\">
					<div class=\"cell\">Attribute</div>
					<div class=\"cell\">Type</div>
					<div class=\"cell\">Data</div>
					<div class=\"cell\">Enabled</div>
				</div>";
			$result = $database->query("SELECT * FROM `schemes` WHERE `table` = '{$_GET['table']}' ORDER BY `attribute` ASC");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$boolean = "";
				$integer = "";
				$text = "";
				$true = "";
				$false = "";
				if ($row['type'] == "boolean") { $boolean = "selected=\"selected\""; }
				if ($row['type'] == "integer") { $integer = "selected=\"selected\""; }
				if ($row['type'] == "text") { $text = "selected=\"selected\""; }
				if ($row['enabled'] == true) { $true = "selected=\"selected\""; }
				if ($row['enabled'] == false) { $false = "selected=\"selected\""; }
				$design .= "<div class=\"row\">
						<div class=\"cell\"><input class='user_input' type='text' name='edit-attribute' size='25' value='{$row['attribute']}'></div>
						<div class=\"cell\">
							<select name=\"edit-type\">
								<option value=\"boolean\" {$boolean}>Boolean</option>
								<option value=\"integer\" {$integer}>Integer</option>
								<option value=\"text\" {$text}>Text</option>
							</select>
						</div>
						<div class=\"cell\"><input class='user_input' type='text' name='edit-data' size='50' value='{$row['data']}'></div>
						<div class=\"cell\">
							<select name=\"edit-enabled\">
								<option value=\"1\" {$true}>true</option>
								<option value=\"0\" {$false}>false</option>
							</select>
						</div>
						<div class=\"cell\">
							<a class=\"deleterow\" id=\"delete-id\" title=\"Delete Task\">X</a>
						</div>
					</div>";
			}
			/*$design .= "<div class=\"row\">
					<div class=\"cell\"><input class='user_input' type='text' name='attribute' size='25' value=''></div>
					<div class=\"cell\">
						<select name=\"type\">
							<option value=\"boolean\" selected=\"selected\">Boolean</option>
							<option value=\"integer\">Integer</option>
							<option value=\"text\">Text</option>
						</select>
					</div>
					<div class=\"cell\"><input class='user_input' type='text' name='data' size='50' value=''></div>
					<div class=\"cell\">
						<select name=\"enabled\">
							<option value=\"1\" selected=\"selected\">true</option>
							<option value=\"0\">false</option>
						</select>
					</div>
				</div>";*/
			$design .= "</div><br>
			<input type=\"button\" id=\"addrow\" value=\"Add\" />
			<input class='button' type='submit' value='Save' title='Save changes to this sceheme'>
			</form>";
			
			/*$new = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=schemes'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='insert' value='new'>
			<input type='hidden' name='table' value='{$_GET['table']}'>
			<div class=\"table\">
				<div class=\"row\">
					<div class=\"cell\">Attribute: </div>
					<div class=\"cell\"><input class='user_input' type='text' name='attribute' size='25' value=''></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\">Type: </div>
					<div class=\"cell\">
						<select name=\"type\">
							<option value=\"boolean\" selected=\"selected\">Boolean</option>
							<option value=\"html\">Html</option>
							<option value=\"integer\">Integer</option>
							<option value=\"text\">Text</option>
						</select>
					</div>
				</div>
				<div class=\"row\">
					<div class=\"cell\">Data: </div>
					<div class=\"cell\"><textarea class=\"user_input\" name=\"data\" cols=\"60\" rows=\"15\"></textarea></div>
				</div>
				<div class=\"row\">
					<div class=\"cell\">Enabled: </div>
					<div class=\"cell\">
						<select name=\"enabled\">
							<option value=\"1\" selected=\"selected\">true</option>
							<option value=\"0\">false</option>
						</select>
					</div>
				</div>
			</div>
			<br><input class='button' type='submit' value='Create' title='Create a new attribute'>
			</form>";*/
		}
	}
	elseif ($act == "settings") {
		$header = "Settings Editor";
		if (isset($_POST['submit']) && $_POST['submit'] == "true"){
			//$curtab = $_POST['curtab'];
			$highlight = $_POST['highlight'];
			$database->query ("UPDATE settings SET value = '{$_POST['value']}' WHERE variable = '{$_POST['variable']}'");
			/*echo "<html><head>
			<title>Control Panel</title>
			<meta http-equiv='refresh' content='3;url={$settings['website']}?page=admin&module=main'>
			</head>
			<body>The database action was successful.</body>
			</html>"; exit;*/
			$settings = $settemp->generate();
			$raw_body = "Setting saved successfully.";
			$no_tabs = true;
			$continue = true;
			$redir = "{$settings['admin_loc']}?page=viewer&content=settings";
		}
		else {
			// Get Info from Database
			$result = $database->query("SELECT * FROM settings WHERE `variable` = '{$_GET['variable']}'");
			$row = mysql_fetch_assoc($result);
			// Open tab
			if ($row['category'] == 1) {
				//$curtab = $tab["settings"];
				$highlight = "settings";
			} elseif ($row['category'] == 2) {
				//$curtab = $tab["maintenance"];
				$highlight = "maintenance";
			} elseif ($row['category'] == 3) {
				//$curtab = $tab["appearance"];
				$highlight = "appearance";
			} else {
				//$curtab = $tab["settings"];
				$highlight = "settings";
			}
			// Highlight module
			//$highlight = $_GET['variable'];
			// Create Input Type
			if ($row['type'] == "boolean") {
				if ($row['value'] == "true"){ $input_form = "<option value='true' selected='selected'>true</option><option value='false'>false</option>"; }
				elseif ($row['value'] == "false"){ $input_form = "<option value='true'>true</option><option value='false' selected='selected'>false</option>"; }
				else { $input_form = "<option value='true'>true</option><option value='false'>false</option>"; }
				$input_form = "<select name='value'>{$input_form}</select>";
			} elseif ($row['type'] == "directory") {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			} elseif ($row['type'] == "email") {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			} elseif ($row['type'] == "html") {
				$row['value'] = htmlentities($row['value']);
				$input_form = "<textarea class='user_input' name='value' cols='40' rows='15'>{$row['value']}</textarea>";
			} elseif ($row['type'] == "integer") {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			} elseif ($row['type'] == "language") {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			} elseif ($row['type'] == "skin") {
				$data = new data();
				$file = new file();
				$thumbcount = 0;
				// choose files
				if ($row['variable'] == "favicon") {
					$skin_loc = "styles/icons/";
					//$skin_loc = "files/image/";
					$skins = $file->lists($skin_loc, array("index.html"));
					$current = $settings[$row['variable']];
				} elseif ($row['variable'] == "jquery_skin" || $row['variable'] == "acp_jquery_skin") {
					$skin_loc = "styles/jquery/";
					//$skins = $file->lists($skin_loc, array("core.css", "index.html"));
					$skins = $file->folders($skin_loc);
					$current = $settings[$row['variable']];
				} else {
					$skin_loc = "skins/";
					$skins = $file->folders($skin_loc);
					$current = $settings[$row['variable']]; }
				// build options
				foreach($skins as $skin){
					// ignore various files
					if ($skin == "template" or $skin == "thumbs") { continue; }
					// check exclusive files
					if ($data->starts($skin, "exclusive")) {
						// check if domain exists
						if ($data->contains($skin, $settings["domain"]) == false) { continue; }
					}
					// list items
					if ($skin == $current) { $list .= "\n<option value=\"{$skin}\" selected=\"selected\">{$skin}</option>"; }
					else { $list .= "<option value=\"{$skin}\">{$skin}</option>"; }
					// gallery items
					$skin_original = "{$skin_loc}{$skin}";
					if ($data->ends($skin, ".ico") or $data->ends($skin, ".css")) { $skin = substr($skin, 0, -4); }
					$thumb = "{$skin_loc}thumbs/{$skin}.png";
					if (is_file($thumb)) {
						if ((++$thumbcount % 5) == 0) {
							$thumbcount = 1;
							$thumbs .= "</tr><tr>";
						}
						$thumbs .= "<td>
							<center>
								<img src=\"{$thumb}\" width=\"80\" height=\"80\"><br>
								{$skin}
							</center>
						</td>";
					}
					elseif (is_file($skin_original) && $data->ends($skin_original, ".ico")) {
						if ((++$thumbcount % 5) == 0) {
							$thumbcount = 1;
							$thumbs .= "</div>
							<tr>";
						}
						$thumbs .= "<td>
							<center>
								<img src=\"{$skin_original}\" width=\"80\" height=\"80\"><br>
								{$skin}
							</center>
						</td>";
					}
				}
				$input_form = "<select name='value'>{$list}</select>";
				$thumbs = "<tr>{$thumbs}</tr>";
			} elseif ($row['type'] == "text") {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			} else {
				$input_form = "<input type='text' name='value' size='60' value='{$row['value']}'>";
			}
			$code = "<form method='post' action='{$settings['acp_loc']}?page=editor&act=settings'>
			<input type='hidden' name='submit' value='true'>
			<input type='hidden' name='variable' value='{$_GET['variable']}'>
			<input type='hidden' name='highlight' value='{$highlight}'>
			<table class=\"table\">
				<tr class=\"warning\">
					<td colspan=\"2\">Only continue if you are 100% sure that you want to edit the following settings.</td>
				</tr>
				<tr>
					<td>{$row['description']}:</td>
					<td>{$input_form}</td>
				</tr>
				<tr>
					<td><button class=\"btn btn-primary\" type=\"submit\" title=\"Save Changes\">Save</button></td>
				</tr>
			</table>
			<!--transitions: bump, grow, fade, crooked, reflect-->
			<table class=\"table reflect\">
				{$thumbs}
			</table>
			</form>";
			$raw_body = $code;
			$no_tabs= true;
		}
	}
	// unknown request
	else { $body = "An error occurred while processing your request."; }
	// begin body
	$body = "<div class=\"demo minimal\"><div id=\"tabs\"><ul>";
	// build tabs
	if (isset($design)) { $body .= "<li><a href=\"#tabs-1\">Design</a></li>"; }
	if (isset($code)) { $body .= "<li><a href=\"#tabs-2\">Code</a></li>"; }
	if (isset($gallery)) { $body .= "<li><a href=\"#tabs-3\">Gallery</a></li>"; }
	if (isset($new)) { $body .= "<li><a href=\"#tabs-4\">New</a></li>"; }
	if (isset($delete)) { $body .= "<li><a href=\"#tabs-5\">Delete</a></li>"; }
	if (isset($navbar)) { $body .= "<li><a href=\"#tabs-6\">Main Order</a></li>"; }
	if (isset($navsub)) { $body .= "<li><a href=\"#tabs-7\">Sub Order</a></li>"; }
	$body .= "</ul>";
	// build tab content
	if (isset($design)) { $body .= "<div id=\"tabs-1\"><p>{$design}</p></div>"; }
	if (isset($code)) { $body .= "<div id=\"tabs-2\"><p>{$code}</p></div>"; }
	if (isset($gallery)) { $body .= "<div id=\"tabs-3\"><p>{$gallery}</p></div>"; }
	if (isset($new)) { $body .= "<div id=\"tabs-4\"><p>{$new}</p></div>"; }
	if (isset($delete)) { $body .= "<div id=\"tabs-5\"><p>{$delete}</p></div>"; }
	if (isset($navbar)) { $body .= "<div id=\"tabs-6\"><p>{$navbar}</p></div>"; }
	if (isset($navsub)) { $body .= "<div id=\"tabs-7\"><p>{$navsub}</p></div>"; }
	$body .= "</div></div>";
	// overwrite body
	if ($no_tabs) { $body = $raw_body; }
	// push to template
	$continue = false;
	
?>
