<?php
	
	class authentication {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Authenticate based on Cookie
		public function authenticate($cookie_prefix) {
			$output = false;
			$credentials = $this->retreive_credentials($this->cookie_data($cookie_prefix));
			$result = $this->database->query("SELECT * FROM `members` WHERE `email` = '{$credentials['email']}'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($credentials['identifier'] == $row['email'] && $credentials['key'] == $row['password'] && $credentials['ip'] == $_SERVER['REMOTE_ADDR']) {
					$output = true;
					break;
				}
			}
			mysql_free_result($result);
			$timestamp = time();
			if ($output == true) { $this->database->query("UPDATE `sessions` SET `timestamp` = '{$timestamp}' WHERE `session` = '{$credentials['session']}'"); }
			return $output;
		}
		
		// Authenticate based on Identifier & Key Combination (w/o IP Verification)
		public function authenticate_login($identifier, $key) {
			$output = false;
			$credentials = array( "identifier" => $identifier, "key" => $key );
			$result = $this->database->query("SELECT * FROM `members` WHERE `email` = '{$identifier}'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($credentials['identifier'] == $row['email'] && $credentials['key'] == $row['password']) {
					$output = true;
					break;
				}
			}
			mysql_free_result($result);
			//$timestamp = time();
			//if ($output == true) { $this->database->query("UPDATE `sessions` SET `timestamp` = '{$timestamp}' WHERE `session` = '{$credentials['session']}'"); }
			return $output;
			
		}
		
		// Authenticate Device (meid, sim)
		public function authenticate_device($identifier, $key) {
			$output = false;
			$credentials = array( "identifier" => $identifier, "key" => $key );
			$result = $this->database->query("SELECT * FROM `devices` WHERE `meid` = '{$identifier}'");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if ($credentials['identifier'] == $row['meid'] && $credentials['key'] == $row['sim']) {
					$output = true;
					break;
				}
			}
			mysql_free_result($result);
			//$timestamp = time();
			//if ($output == true) { $this->database->query("UPDATE `sessions` SET `timestamp` = '{$timestamp}' WHERE `session` = '{$credentials['session']}'"); }
			return $output;
		}
		
		// Retreive cookie data
		public function cookie_data($cookie_prefix) {
			if (isset($_COOKIE["{$cookie_prefix}_session"])) { return $_COOKIE["{$cookie_prefix}_session"]; }
			else { return false; }
		}
		
		// Create session
		public function create_session($identifier, $key, $only = true) {
			$data = new data();
			if ($only == true) { $this->database->query("UPDATE `sessions` SET `enabled` = '0' WHERE `identifier` = '{$identifier}'"); }
			$timestamp = time();
			$session = $data->random(10, 20);
			$session_row = $this->database->create_row("sessions");
			$this->database->query("UPDATE `sessions` SET `session` = '{$session}', `identifier` = '{$identifier}', `key` = '{$key}', `timestamp` = '{$timestamp}', `ip` = '{$_SERVER['REMOTE_ADDR']}', `enabled` = '1' WHERE `id` = '{$session_row}'");
			return $session;
		}
		
		// Delete Credentials
		public function delete_credentials($cookie_prefix, $cookie_directory, $cookie_website) {
			$session_cookie = "{$cookie_prefix}_session";
			if ($_COOKIE [$session_cookie]) {
				$credentials = $this->retreive_credentials($this->cookie_data($cookie_prefix));
				$this->database->query ("UPDATE `sessions` SET `enabled` = '0' WHERE `session` = '{$credentials['session']}'");
				setcookie ($session_cookie, "", time()-60, $cookie_directory, $cookie_website, 0);
				$variable = true;
			} else {
				$variable = false;
			}
			return $variable;
		}
		
		// Perform HTTP Authentication
		public function http() {
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				$this->http_prompt();
			}
			else {
				if ($this->authenticate_login("{$_SERVER['PHP_AUTH_USER']}", "{$_SERVER['PHP_AUTH_PW']}")) { /* do nothing */ }
				else { $this->http_prompt(); }
				//echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
				//echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p>";
			}
		}
		
		// Prompt for HTTP Authentication
		private function http_prompt() {
			header('WWW-Authenticate: Basic realm="Restricted Zone"');
			header('HTTP/1.0 401 Unauthorized');
			echo "User authentication is required to view this site.";
			exit;
		}
		
		// Recover Login Credentials
		public function recover_credentials($settings, $session) {
			$session_cookie = "{$settings["cookie_prefix"]}_session";
			setcookie ($session_cookie, $session, time()+(5 * 365 * 24 * 60 * 60), $settings['cookie_directory'], $settings['cookie_website'], 0);
		}
		
		// Retreive Credentials
		public function retreive_credentials($session) {
			$result = $this->database->query("SELECT * FROM `sessions` WHERE `session` = '{$session}' AND `enabled` = '1'");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if (!$row) { $array = array("email" => $row["identifier"]); }
			else { $array = array_merge($row, array("email" => $row["identifier"])); }
			mysql_free_result($result);
			return $array;
		}
		
		// Save Login Credentials
		public function save_credentials($settings, $identifier, $key, $only = true) {
			$session_cookie = "{$settings["cookie_prefix"]}_session";
			$session = $this->create_session($identifier, $key, $only);
			//setcookie ($session_cookie, $session, time()+$settings["session_timeout"], $settings["cookie_directory"], $settings["cookie_website"], 0);
			setcookie ($session_cookie, $session, time()+(5 * 365 * 24 * 60 * 60), $settings["cookie_directory"], $settings["cookie_website"], 0);
		}
		
		// Timestamp Update
		public function timestamp_update($cookie_prefix) {
			// do something
		}
		
	}
	
?>
