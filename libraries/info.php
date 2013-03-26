<?php
	
	class info {
		
		// Browser
		public function browser($agent=null) {
			// Declare known browsers to look for
			$known = array('msie', 'firefox', 'chrome', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko', 'mozilla', 'seamonkey', 'navigator', 'mosiac', 'lynx', 'amaya', 'omniweb', 'avant', 'camino', 'flock', 'aol');
			// Clean up agent and build regex that matches phrases for known browsers
			// (e.g. "Firefox/2.0" or "MSIE 6.0" (This only matches the major and minor
			// version numbers.  E.g. "2.0.0.6" is parsed as simply "2.0"
			$agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
			$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
			// Find all phrases (or return empty array if none found)
			if (!preg_match_all($pattern, $agent, $matches)) return array();
			// Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
			// Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
			// in the UA).  That's usually the most correct, except in Google Chrome's
			// case.
			if(strstr($agent, 'chrome')) {
				$i = count($matches['browser'])-2;
			}
			else {
				$i = count($matches['browser'])-1;
			}
			return array($matches['browser'][$i] => $matches['version'][$i], 'name' => $matches['browser'][$i], 'version' => $matches['version'][$i], 'upper' => ucwords($matches['browser'][$i]));
		}
		
		// Operating System
		public function system() {
			$OS_List = array(
			// Match user agent string with operating systems
			'Windows 3.11' => 'Win16',
			'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
			'Windows 98' => '(Windows 98)|(Win98)',
			'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
			'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
			'Windows Server 2003' => '(Windows NT 5.2)',
			'Windows Vista' => '(Windows NT 6.0)',
			'Windows 7' => '(Windows NT 6.1)',
			'Windows 8' => '(Windows NT 6.2)',
			'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
			'Windows ME' => 'Windows ME',
			'Open BSD' => 'OpenBSD',
			'Sun OS' => 'SunOS',
			'Linux' => '(Linux)|(X11)',
			'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
			'QNX' => 'QNX',
			'BeOS' => 'BeOS',
			'OS/2' => 'OS/2',
			'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)');
			// Loop through the array of user agents and matching operating systems
			foreach($OS_List as $CurrOS=>$Match) { if (eregi($Match, $_SERVER['HTTP_USER_AGENT'])) { break; } }
			return $CurrOS;
		}
		
	}

?>
