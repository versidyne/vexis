<?php
	
	/* This library is meant to access "addons", "extensions", or
	 * "plugins" (still haven't decided the name) that will be
	 * small, specific features, run system-wide.  These will
	 * differ from modules in many ways, namely they will be run
	 * every time a page is generated, Object Oriented, and extend
	 * a "core" framework. */
	
	// TODO: Develop addon library
	
	class addon {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		public function get() {
			return false;
		}
		
		public function set() {
			return false;
		}
		
	}
	
?>
