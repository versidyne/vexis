<?php

	class skin {
		
		private $database = false;
		private $custom = NULL;
		public function __construct($database) { $this->database = $database; }
        
        // Customize output
		public function customize($name) {
			$result = $this->database->query("SELECT * FROM `skins` WHERE `name` = '{$name}' LIMIT 1");
			$custom = mysql_fetch_array($result, MYSQL_ASSOC);
			if ($custom) { $this->custom = $custom; }
			mysql_free_result($result);
			return false;
		}
        
		// Account Login Form
		public function login($settings, $page) {
			$authentication = new authentication($this->database);
			$form = new form($this->database);
			$data = "";
			if ($page == "logout") { $logged_in = false; }
			elseif ($authentication->authenticate($settings['cookie_prefix']) == true) { $logged_in = true; }
			else { $logged_in = false; }
			if ($logged_in == true) {
				$infobox = "<h1>Account info</h1><h2>You're logged in.</h2><p><a href='?page=member'>Control Panel</a><br><a href='?page=logout'>Logout</a></p>";
				$data = $infobox;
			}
			else {
				$loginbox = $form->parse("loginbox");
				if ($loginbox['existence'] == true) { $data = "<h1>{$loginbox['header']}</h1> <p>{$loginbox['body']}</p>"; }
			}
			return $data;
		}

		// Links
		public function links($settings, $page) {
			$authentication = new authentication($this->database);
			if ($page == "logout") { $data = $settings['link_unauth']; }
			elseif ($authentication->authenticate($settings['cookie_prefix']) == true) { $data = $settings['link_auth']; }
			else { $data = $settings['link_unauth']; }
			return $data;
		}
		
		// Links
		public function linklogin($settings, $page) {
			$authentication = new authentication($this->database);
			if ($page == "logout") { $data = "<a href=\"/?page=login\">Login</a>"; }
			elseif ($authentication->authenticate($settings['cookie_prefix']) == true) { $data = "<a href=\"/?page=logout\">Logout</a>"; }
			else { $data = "<a href=\"/?page=login\">Login</a>"; }
			return $data;
		}
		
		// Links
		public function linkregister($settings, $page) {
			$authentication = new authentication($this->database);
			if ($page == "logout") { $data = "<a href=\"/?page=register\">Register</a>"; }
			elseif ($authentication->authenticate($settings['cookie_prefix']) == true) { $data = "<a href=\"/?page=member\">Control Panel</a>"; }
			else { $data = "<a href=\"/?page=register\">Register</a>"; }
			return $data;
		}
		
		// Breadcrumb Display
		public function breadcrumbs($current_page) {
			$links = "";
			// Make home page
			if ($current_page != "home") { $links = "\n<li>&#187;</li> \n <li><a href=\"/?page=home\">Home</a></li>"; }
			// Find all associated pages
			$result = $this->database->query("SELECT * FROM content WHERE `shortname` = '{$current_page}'");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$links .= "\n<li>&#187;</li>\n";
				if ($content["title"] == ""  && $content["header"] != "") { $content["title"] = $content["header"]; }
				if ($content["shortname"] == $current_page) { $links .= "<li class='current'><a href='?page={$content["shortname"]}'>{$content["title"]}</a></li> \n"; }
				else { $links .= "<li><a href='?page={$content["shortname"]}'>{$content["title"]}</a></li> \n"; }
			}
			mysql_free_result($result);
			return $links;
		}

		// Clock Display
		public function clock($settings) { return $settings['current_time']." ".$settings['time_zone']; }

		// Content Display
		public function content($header, $body, $raw) {
			if ($raw == true) { $data = $body; }
			else { $data = "<h1>".$header."</h1><p>".$body."</p>"; }
			return $data;
		}
		
		// Featured Page Display
		public function featured() {
			$pages = "";
			// Find last row
			$result = $this->database->query("SELECT * FROM content WHERE `featured` > 0 ORDER BY `featured` DESC LIMIT 1");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) { $last = $content["featured"]; }
			mysql_free_result($result);
			// Create featured pages
			$result = $this->database->query("SELECT * FROM content WHERE `featured` > 0 ORDER BY `featured` ASC");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) {
				//if ($content["featured"] == $last) { $pages .= "<li class=\"last\"><h2>{$content["title"]}</h2> \n <p class=\"imgholder\"><img src=\"skins/modern-business/img/demo/290x100.gif\" alt=\"\" /></p> \n <p>{$content["description"]} <a href=\"?page={$content["shortname"]}\">More &raquo;</a></p></li> \n"; }
				//else { $pages .= "<li><h2>{$content["title"]}</h2> \n <p class=\"imgholder\"><img src=\"skins/modern-business/img/demo/290x100.gif\" alt=\"\" /></p> \n <p>{$content["description"]} <a href=\"?page={$content["shortname"]}\">More &raquo;</a></p></li> \n"; }
				if ($content["featured"] == $last) {
					$tags = array("{class}"=>"last","{title}"=>$content["title"],"{description}"=>$content["description"],"{shortname}"=>$content["shortname"]);
					$pages .= $this->parse($tags, "", $this->custom['featured']);
				}
				else {
					$tags = array("{class}"=>"","{title}"=>$content["title"],"{description}"=>$content["description"],"{shortname}"=>$content["shortname"]);
					$pages .= $this->parse($tags, "", $this->custom['featured']);
				}
			}
			mysql_free_result($result);
			// Return data
			return $pages;
		}

		// Header links, scripts, and meta tags
		public function headers() {
			$header = array();
			$headers = "";
			$result = $this->database->query("SELECT * FROM `headers` WHERE `enabled` = '1'");
			while ($header = mysql_fetch_array($result, MYSQL_ASSOC)) {
				// Link tags
				if ($header["type"] == "link") {
					if ($header["name"] == "") { $headers .= "<link rel=\"{$header["rel"]}\" type=\"{$header["mime"]}\" href=\"{$header["src"]}\" /> \n"; }
					else { $headers .= "<link rel=\"{$header["rel"]}\" type=\"{$header["mime"]}\" title=\"{$header["name"]}\" href=\"{$header["src"]}\" /> \n"; }
				}
				// Script tags
				elseif ($header["type"] == "script") {
					if ($header["remote"] == true) { $header["loc"] = $header["src"]; }
					else {
						if ($header["src"] == true) { $header["loc"] = "/scripts/{$header["src"]}"; }
						else { $header["loc"] = false; }
					}
					if ($header["loc"] == false ) { $headers .= "<script type=\"{$header["mime"]}\">{$header["content"]}</script>\n"; }
					else { $headers .= "<script type=\"{$header["mime"]}\" src=\"{$header["loc"]}\">{$header["content"]}</script>\n"; }
				}
				// Meta tags
				elseif ($header["type"] == "meta") {
					$headers .= "<meta http-equiv=\"{$header["mime"]}\" name=\"{$header["name"]}\" content=\"{$header["content"]}\" scheme=\"{$header["scheme"]}\" />\n";
				}
				// Style tags
				elseif ($header["type"] == "style") {
					$headers .= "<style type=\"{$header["mime"]}\" />{$header["content"]}</style>\n";
				}
				else {
					// unknown type
				}
			}
			mysql_free_result($result);
			return $headers;
		}
		
		// Page Header
		public function header($title) { return "<title>{$title}</title>\n".$this->headers(); }
		
		// Intro Display
		public function intro() {
			// Find last row
			$result = $this->database->query("SELECT * FROM content WHERE `featured` > 0 ORDER BY `featured` DESC LIMIT 1");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) { $last = $content["featured"]; }
			mysql_free_result($result);
			// Create featured pages
			$result = $this->database->query("SELECT * FROM content WHERE `featured` > 0 ORDER BY `featured` ASC");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($content["featured"] == $last) { $pages .= "<li class=\"last\"><h2>{$content["title"]}</h2> \n <p class=\"imgholder\"><img src=\"skins/business/img/demo/290x100.gif\" alt=\"\" /></p> \n <p>{$content["description"]} <a href=\"?page={$content["shortname"]}\">More &raquo;</a></p></li> \n"; }
				else { $pages .= "<li><h2>{$content["title"]}</h2> \n <p class=\"imgholder\"><img src=\"skins/business/img/demo/290x100.gif\" alt=\"\" /></p> \n <p>{$content["description"]} <a href=\"?page={$content["shortname"]}\">More &raquo;</a></p></li> \n"; }
			}
			mysql_free_result($result);
			// Return data
			return $pages;
		}
		
		// Navbar Display
		public function navbar($current_page, $vfs = "false", $reverse = false) {
			$links = "";
			if ($vfs == "true") { $subdir = "/pages/"; } else { $subdir = "/?page="; }
			// Find last navbutton
			$result = $this->database->query("SELECT * FROM `content` WHERE `navbutton` > 0 AND `enabled` = 1 ORDER BY `navbutton` DESC LIMIT 1");
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) { $last = $content["navbutton"]; }
			mysql_free_result($result);
			// Find all pages marked for navigation
			if ($reverse) { $result = $this->database->query("SELECT * FROM content WHERE `navbutton` > 0 AND `enabled` = 1 ORDER BY `navbutton` DESC"); }
			else { $result = $this->database->query("SELECT * FROM content WHERE `navbutton` > 0 AND `enabled` = 1 ORDER BY `navbutton` ASC"); }
			while ($content = mysql_fetch_array($result, MYSQL_ASSOC)) {
				// Build navigation sub-menus
				$subresult = $this->database->query("SELECT * FROM content WHERE `navparent` = '{$content["navbutton"]}' AND `enabled` = 1 ORDER BY `navsub` ASC");
				if (mysql_num_rows($subresult) > 0) {
					while ($subcontent = mysql_fetch_array($subresult, MYSQL_ASSOC)) {
						$tags = array("{class}"=>"","{title}"=>$subcontent["title"],"{description}"=>$subcontent["description"],"{link}"=>"{$subdir}{$subcontent['shortname']}");
						$navsub .= $this->parse($tags, "", $this->custom['navbar']);
						$navsub .= "\n";
					}
					$template = $this->custom['subnav'];
				}
				else {
					$navsub = NULL;
					$template = $this->custom['navbar'];
				}
				// Use header if title doesn't exist
				if ($content["title"] == ""  && $content["header"] != "") {
					if ($content["shortname"] == $current_page) {
						$tags = array("{class}"=>"active","{title}"=>$content["header"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
					else {
						$tags = array("{class}"=>"","{title}"=>$content["header"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
				}
				// Last page
				elseif ($content["navbutton"] == $last) {
					if ($content["shortname"] == $current_page) {
						$tags = array("{class}"=>"active last","{title}"=>$content["title"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
					else {
						$tags = array("{class}"=>"last","{title}"=>$content["title"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
				}
				// Normal pages
				else {
					if ($content["shortname"] == $current_page) {
						$tags = array("{class}"=>"active","{title}"=>$content["title"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
					else {
						$tags = array("{class}"=>"","{title}"=>$content["title"],"{description}"=>$content["description"],"{link}"=>"{$subdir}{$content['shortname']}","{navsub}"=>$navsub);
						$links .= $this->parse($tags, "", $template);
					}
				}
				$links .= "\n";
			}
			mysql_free_result($result);
			return $links;
		}
		
		// News Preview
		public function news() {
			// Find the last page id in the database
			$last_id = $this->database->last_row('content', false, false, 'news');
			// Retrieve News List
			$result = $this->database->query("SELECT * FROM `content` WHERE `type` = 'news' AND `id` = '{$last_id}'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$subject = $row["title"];
				$body = substr($row["body"], 0, 150)."...";
			}
			$data = "<h2>{$subject}</h2>";
			$data .= "<p>{$body}</p>";
			$data .= "<p><a href='/?page=news'>Continue Reading &raquo;</a></p>";
			//mysql_free_result($result);
			return $data;
		}
		
		// News List
		public function newslist() {
			// Find the last page id in the database
			$last_id = $this->database->last_row('content', false, false, 'news');
			// Retrieve News List, descending
			$result = $this->database->query("SELECT * FROM `content` WHERE `type` = 'news'");
			// save the year, month, and day to compare on the next iteration
			// if the comparison fails, depending, it will close that portion
			/*while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$subject = $row["title"];
				$body = substr($row["body"], 0, 150)."...";
				$data = "<h2>{$subject}</h2>";
				$data .= "<p>{$body}</p>";
				$data .= "<p><a href='/?page=news'>Continue Reading &raquo;</a></p>";
			} */
			mysql_free_result($result);
			$data = '
			<li><a href="#">Year</a></li>
			<li><a href="#">Year</a>
				<ul>
					<li><a href="#">Month</a></li>
					<li><a href="#">Month</a></li>
				</ul>
			</li>
			<li><a href="#">Year</a>
				<ul>
					<li><a href="#">Month</a></li>
					<li><a href="#">Month</a>
					<ul>
						<li><a href="#">Day</a></li>
						<li><a href="#">Day</a></li>
					</ul>
					</li>
				</ul>
			</li>
			<li><a href="#">Year</a></li>';
			return $data;
		}
		
		// Online Users
		public function online($settings) {
			// variables
			$timeout = 90;
			$timestamp = time();
			$timeout = $timestamp-$timeout;
			$data = " ";
			$member = new member($this->database);
			$inactive = true;
			// gather 
			$result = $this->database->query("SELECT * FROM `sessions` WHERE `enabled` = '1'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($row["timestamp"] > $timeout) {
					$inactive = false;
					$mvar = $member->vars($member->lookup($row['identifier']));
					$data .= "<li><a href='{$settings['website']}?page=member-list&member={$row['identifier']}'>{$mvar['nickname']}</a></li>";
				}
			}
			mysql_free_result($result);
			if ($inactive) { $data = "<li><a href='{$settings['website']}?page=member-list'>All members offline</a></li>"; }
			return $data;
		}
		
		// Search Form
		public function search($settings) {
			$tags = array("<action>"=>"{$settings['website']}?page=search");
			$data = $this->parse($tags, "", $this->custom['search']);
			/*$data = "<form action='{$settings['website']}?page=search' method='get'>
			<fieldset>
			
			<legend>Search</legend>
			<input type='hidden' name='page' value='search' />
			
			<input class='searchfield' id=\"query\" name=\"query\" type='text' value='Search Our Website&hellip;'  onfocus=\"this.value=(this.value=='Search Our Website&hellip;')? '' : this.value ;\" onkeyup=\"searchSuggest();\" autocomplete=\"off\" />
			<input class='searchbutton' type='submit' id='go' value='search' title='search' />
			
			</fieldset>
			<div id=\"suggest\"></div>
			</form>";*/
			return $data;
		}
		
		// Parse Skin Formatting
		public function parse($tags, $custom_tags, $template) {
			// Set variables
			if ($custom_tags == "") { $custom_tags = array(); }
			$data = $template;
			// Replace each tag with corresponding values
			foreach ($tags as $tag => $value) {
				$data = str_replace($tag, $value, $data);
			}
			// Do the same for custom tags
			foreach ($custom_tags as $tag => $value) {
				$data = str_replace($tag, $value, $data);
			}
			// Check if data was altered
			//if ($data == $template) { $data = "An error occurred during formatting."; }
			// Return formatted data
			return $data;
		}

		// Sponsors
		public function sponsors($settings) {
			return $settings["sponsors"];
		}

	}

?>
