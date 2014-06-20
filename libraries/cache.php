<?php
	
	/* This library is meant to store large portions of data for
	 * quick and easy access by the system, without regenerating
	 * the entire page. This will be vastly similar to the value
	 * storing "discrete" library, but intended for a larger
	 * scale as well as based on a per user generation rather
	 * than the admin generation utilized in the discrete values. */
	
	// TODO: Develop cache library
	
	class cache {
		
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
