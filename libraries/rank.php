<?php
	
	/* This library is meant to update, retreive, and sort through
	 * ranks for various pages, profiles, and comments, as well as
	 * allowing for full customization of said ranks and display
	 * as either text or image. */
	
	// TODO: Develop rank library
	
	// TODO: Design ranks into the database
	// TODO: Decide if ranks should be a column or a table
	
	class rank {
		
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
