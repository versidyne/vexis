<?php
	
	/* This library is meant to allow user commenting on any
	 * generated page, unless otherwise specified by the
	 * administration.  This will also allow commenting on
	 * said comments in the form of "replies" to create the
	 * appearance of "threads" on each page.  This should
	 * look somewhat similar to the Disqus commenting system
	 * with far better integration, and using Gravatar as the
	 * primary Avatar, yet allowing for Facebook, Twitter,
	 * Google+, etc, to replace said Avatar per user request. */
	
	class comment {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Post New Comment
		public function post($author, $type, $parent, $body) {
			
			// TODO: Gather Unix Timestamp and Last Row
			
			// TODO: Create unique thread reference number, to gather all replies
			
			// TODO: Add New Row to Database
			
			return false;
		}
		
		// Display Thread
		public function thread($type, $parent) {
			
			// TODO: Gather all rows that fit the unique thread reference number, according to type and parent
			
			// TODO: Find a way to display threads according to levels
			
			// TODO: Add lines to the left of each comment to indicate which "level" the comment is.
			// For example, if the post is an original comment or a reply to a comment or reply.
			
			return false;
		}
		
	}
	
?>
