<?php
	
	/* This library is meant to access various social networks and
	 * return all acquired data back to the system.  This should be
	 * able to access Avatars, Posts, User Information, etc, to help
	 * build profiles, registration, or display within a page. */
	
	// TODO: Develop social library
	
	class social {
		
		private $database = false;
		private $website = false;
		public function __construct($database, $website) { $this->database = $database; $this->website = $website; }
		
		public function get() {
			return false;
		}
		
		public function set() {
			return false;
		}
		
	}
	
?>
