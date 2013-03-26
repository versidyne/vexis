<?php
	
	class settings {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		public function generate () {
			
			// Generate Settings as Variables
			/*$settings_result = mysql_query ("SELECT * FROM settings");
			while ($settings_row = mysql_fetch_array($settings_result, MYSQL_ASSOC)) { $$settings_row["variable"] = $settings_row["value"]; }
			mysql_free_result($settings_result);*/
			
			// Grab table as array
			$temp = $this->database->table_string("settings", "variable", "value");
			
			// Detect SSL
			if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
				$temp['https'] = "true";
				$temp['protocol'] = "https";
			} else {
				$temp['https'] = "false";
				$temp['protocol'] = "http";
			}
			
			// Generate Prefix
			if ($temp['www_prefix'] == "true") { $temp['prefix'] = "www."; } else { $temp['prefix'] = ""; }
			
			// Generate website url
			$temp['website'] = "{$temp['protocol']}://{$temp['prefix']}{$temp['domain']}/";
			
			// Cookie website and domain are the same
			$temp['cookie_website'] = $temp['domain'];
			
			// Time, Day, & Date
			$temp['raw_hour'] = date("G");
			$temp['current_year'] = date("Y");
			$temp['current_date'] = date("F j, Y");
			$temp['current_gmdate'] = gmdate("D, d M Y H:i:s");
			$temp['current_day'] = date("l");
			//$temp['current_hour'] = bcadd($temp['raw_hour'], $temp['time_offset']);
			$temp['current_hour'] = $temp['raw_hour'];
			$temp['current_minute'] = date("i");
			if ($temp['current_hour'] < 0) { $temp['current_hour'] = bcadd($temp['current_hour'], 24); }
			
			// Set Current Time
			$temp['current_time'] = $temp['current_hour'].":".$temp['current_minute'];
			
			// Create arguments
			//if ($_SERVER["argv"][0]) { $$temp[args] = "/?".$_SERVER["argv"][0]; }
			//else { $$temp[args] = ""; }
			return $temp;
		}
		
	}

?>
