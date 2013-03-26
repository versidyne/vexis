<?php
	
	/* This library is meant to store various portions of data
	 * that is generated each time a page is loaded, but the
	 * data remains the same between pages, thus it should be
	 * a discrete value to avoid resource usage.  It will work
	 * by generating an initial load then storing it until the
	 * admin has changed data that the discrete value holds, in
	 * which case it will be generated again. */
	
	class discrete {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Store complete iterations
		public function store() {
			return false;
		}
		
		// Display complete iterations
		public function store() {
			return false;
		}

	}
	
?>
