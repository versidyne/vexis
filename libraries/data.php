<?php
	
	class data {
		
		// Compare string beginning
		function starts($haystack, $needle) {
			$length = strlen($needle);
			return (substr($haystack, 0, $length) === $needle);
		}
		
		// Compare string ending
		function ends($haystack, $needle) {
			$length = strlen($needle);
			if ($length == 0) { return true; }
			return (substr($haystack, -$length) === $needle);
		}
		
		// Compare string ending
		function contains($haystack, $needle) {
			$pos = strpos($haystack,$needle);
			if ($pos === false) { return false; }
			return $pos;
		}
		
		// Get Between a String
		public function between($str, $start, $end) {
			$startlen = strlen($start);
			if (($startpos = strpos($str, $start)) !== false
			&& ($endpos = strpos($str, $end)) !== false
			&& ($skip = $startpos + $startlen) <= $endpos) {
				return substr($str, $skip, $endpos - $skip);
			}
			else {return false;}
		}
		
		// Generate a Random String
		public function random($minLen, $maxLen, $alphaLower = 1, $alphaUpper = 1, $num = 1, $batch = 1) {
			
			$alphaLowerArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
			$alphaUpperArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$numArray = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
			
			if (isset($minLen) && isset($maxLen)) {
				if ($minLen == $maxLen) {
					$strLen = $minLen;
				} else {
					$strLen = rand($minLen, $maxLen);
				}
				$merged = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
				
				if ($alphaLower == 1 && $alphaUpper == 1 && $num == 1) {
					$finalArray = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
				} elseif ($alphaLower == 1 && $alphaUpper == 1 && $num == 0) {
					$finalArray = array_merge($alphaLowerArray, $alphaUpperArray);
				} elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 1) {
					$finalArray = array_merge($alphaLowerArray, $numArray);
				} elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 1) {
					$finalArray = array_merge($alphaUpperArray, $numArray);
				} elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 0) {
					$finalArray = $alphaLowerArray;
				} elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 0) {
					$finalArray = $alphaUpperArray;                        
				} elseif ($alphaLower == 0 && $alphaUpper == 0 && $num == 1) {
					$finalArray = $numArray;
				} else {
					return FALSE;
				}
				
				$count = count($finalArray);
				
				if ($batch == 1) {
					$str = '';
					$i = 1;
					while ($i <= $strLen) {
						$rand = rand(0, $count);
						$newChar = $finalArray[$rand];
						$str .= $newChar;
						$i++;
					}
					$result = $str;
				} else {
					$j = 1;
					$result = array();
					while ($j <= $batch) { 
						$str = '';
						$i = 1;
						while ($i <= $strLen) {
							$rand = rand(0, $count);
							$newChar = $finalArray[$rand];
							$str .= $newChar;
							$i++;
						}
						$result[] = $str;
						$j++;
					}
				}
				
				return $result;
			}
			
		}
		
		// Retreive Data (Cookie)
		public function retreive_cookie($settings, $name) {
			$cname = $settings["cookie_prefix"].$name;
			if (isset($_COOKIE["{$cname}"])) { $data = $_COOKIE["{$cname}"]; }
			else { $data = false; }
			return $data;
		}
		
		// Save Data (Cookie)
		public function save_cookie($settings, $name, $expiration, $data) {
			$cname = $settings["cookie_prefix"].$name;
			setcookie ($cname, $data, time()+$expiration, $settings["cookie_directory"], $settings["cookie_website"], 0);
		}
		
		public function sizeunits ($bytes) {
			if ($bytes >= 1073741824)
			{
				$bytes = number_format($bytes / 1073741824, 2) . ' GB';
			}
			elseif ($bytes >= 1048576)
			{
				$bytes = number_format($bytes / 1048576, 2) . ' MB';
			}
			elseif ($bytes >= 1024)
			{
				$bytes = number_format($bytes / 1024, 2) . ' KB';
			}
			elseif ($bytes > 1)
			{
				$bytes = $bytes . ' bytes';
			}
			elseif ($bytes == 1)
			{
				$bytes = $bytes . ' byte';
			}
			else
			{
				$bytes = '0 bytes';
			}

			return $bytes;
		}

	}

?>
