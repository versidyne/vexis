<?php
	
	class email {
		
		private $database = false;
		public function __construct($database) { $this->database = $database; }
		
		// Message count
		public function count($username, $password) {
			$mbox_loc = "{localhost:143/imap/notls}INBOX";
			$mailbox = @imap_open($mbox_loc, $username, $password);
			$check = @imap_check($mailbox);
			$message_count = $check->Nmsgs;
			if (!$message_count) {$message_count = "0";}
			//return array ("messages" => $message_count);
			return $message_count;
		}
		
		// Email sender
		public function send() {
			return 0;
		}
		
		// Account creator
		public function create() {
			return 0;
		}
		
	}
	
?>
