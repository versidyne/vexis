<?php
	
	include_once "core.php";
	
	class database extends core {
		
		// Properties
		private $conn;
		private $data;
		private $debug;
		private $type;
		private $server;
		private $username;
		private $password;
		
		// Constructs
		public function __construct($debug, $type) {
			$this->debug = $debug;
			$this->type = $type;
		}
		
		// Verify action
		private function verify($action, $description) {
			if (!$action) {
				if ($this->type == "mysql") {
					$error = mysql_errno($this->conn);
					$message = mysql_error($this->conn);
				}
				else if ($this->type == "pgsql") {
					$message = pg_last_error($this->conn);
				}
				else {
					$message = "Unsupported database type";
				}
				//$email =  new email($this);
				if ($this->debug) {
					if ($error) { echo "Error: {$error}<br>"; }
					echo "Message: {$message}<br>
					Description: {$description}";
				}
				else { echo "Database error."; }
				exit;
			}
		}
		
		// Connect to server
		public function connect($server, $username, $password) {
			$this->server = $server;
			$this->username = $username;
			$this->password = $password;
			return $this->doconnect();
		}
		public function doconnect() {
			if ($this->type == "mysql") {
				$this->conn = mysql_connect($this->server, $this->username, $this->password);
				$this->verify($this->conn, "Attempted to connect to server");
				return $this->conn;
			}
			else if ($this->type == "pgsql") {
				//$this->conn = pg_connect("host={$this->server} user={$this->username} password={$this->password}");
				return true;
			}
			else { return false; }
		}
		
		// Select database
		public function select($database) {
			if ($this->type == "mysql") {
				$this->data = mysql_select_db($database, $this->conn);
				$this->verify($this->data, "Attempted to select database");
				return $this->data;
			}
			else if ($this->type == "pgsql") {
				$this->conn = pg_connect("host={$this->server} dbname={$database} user={$this->username} password={$this->password}");
				$this->verify($this->conn, "Attempted to connect to server and select database");
				return $this->conn;
			}
			else {
				return false;
			}
		}
		
		// Run query
		public function query($query) {
			$result = mysql_query($query, $this->conn);
			if (mysql_error($this->conn)) { $this->verify($result, "Attempted to run query: {$query}"); }
			return $result;
		}
		
		// Child database information
		public function child($domain) {
			if ($domain) { $domain = str_replace("www.","",$domain); }
			$result = $this->query("SELECT * FROM `children` WHERE `domain` = '{$domain}' AND `enabled` = '1' LIMIT 1");
			return mysql_fetch_array($result, MYSQL_ASSOC);
		}

		// Create empty row, last id if not specified
		public function create_row($table, $id = false) {
			if ($id == false) {
				$last_id = $this->last_row($table);
				$id = bcadd($last_id, 1);
			}
			$this->query("INSERT INTO `{$table}` (`id`) VALUES ('{$id}')");
			return $id;
		}

		// Delete Row
		public function delete_row($table, $attribute, $value) {
			$this->query("DELETE FROM `{$table}` WHERE `{$attribute}` = '{$value}' LIMIT 1");
		}
		
		// Count Rows
		public function count($table) {
			$result = $this->query("SELECT COUNT(*) FROM `{$table}`");
			$rows = mysql_fetch_array($result);
			return $rows[0];
		}
		
		// Find Last Row
		public function last_row($table, $order = false, $ascending = false, $type = false) {
			$sundries = "";
			if ($type) { $sundries .= "WHERE `type` = '{$type}' "; }
			if (!$order) { $order = "id"; } $sundries .= "ORDER BY `{$order}` ";
			if ($ascending) { $sundries .= "ASC"; } else { $sundries .= "DESC"; }
			$result = $this->query("SELECT * FROM `{$table}` {$sundries} LIMIT 1");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			return $row["id"];
		}
		
		// Search Engine
		public function search($table, $column, $query) {
			$results = $this->query("SELECT * FROM `{$table}` WHERE `{$column}` LIKE '%{$query}%'");
			return $results;
		}
		
		// Table to Full Array
		public function table_array($table, $name, $value) {
			$result = $this->query("SELECT * FROM `{$table}`");
			$table = array();
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) { $table[$row[$name]] = $row[$value]; }
			mysql_free_result($result);
			return $table;
		}
		
		// Table to String Array
		public function table_string($table, $name, $value) {
			$result = $this->query("SELECT * FROM `{$table}`");
			$table = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { $table[$row[$name]] = $row[$value]; }
			mysql_free_result($result);
			return $table;
		}
		
	}

?>
