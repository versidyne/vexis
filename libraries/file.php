<?php

	class file {
		// Copy
		/*function copy($old, $new) {
			return false;
		}
		// Delete
		function delete($old, $new) {
			return false;
		}
		// Move
		function move($old, $new) {
			return false;
		}
		// Rename
		function rename($old, $new) {
			return false;
		}*/
		// File List
		function lists($dir, $ignored = NULL) {
			$list = array();
			if (is_null($ignored)) { $ignored = array(".", ".."); }
			else { $ignored = array_merge(array(".", ".."), $ignored); }
			if (is_dir($dir)){
				$results = scandir($dir);
				foreach ($results as $result) {
					if (in_array($result, $ignored)) { continue; }
					if (is_file($dir.'/'.$result)) { $list[] = $result; }
				}
			}
			else { echo "Error: File directory ({$dir}) does not exist. <br><br>"; exit; }
			return $list;
		}
		// Folder List
		function folders($dir, $ignored = NULL) {
			$list = array();
			if (is_null($ignored)) { $ignored = array(".", ".."); }
			else { $ignored = array_merge(array(".", ".."), $ignored); }
			if (is_dir($dir)){
				$results = scandir($dir);
				foreach ($results as $result) {
					if (in_array($result, $ignored)) { continue; }
					if (is_dir($dir.'/'.$result)) { $list[] = $result; }
				}
			}
			else { echo "Error: File directory ({$dir}) does not exist. <br><br>"; exit; }
			return $list;
		}
		// Folder List (PHP4)
		function folders_php4($startdir) {
			$ignoredDirectory[] = '.';
			$ignoredDirectory[] = '..';
			if (is_dir($startdir)){
				if ($dh = opendir($startdir)){
					while (($folder = readdir($dh)) !== false){
						if (!(array_search($folder,$ignoredDirectory) > -1)){
							if (filetype($startdir . $folder) == "dir"){
								$directorylist[$startdir . $folder]['name'] = $folder;
								$directorylist[$startdir . $folder]['path'] = $startdir;
							}
						}
					}
					closedir($dh);
				}
			}
			else { echo "Error: File directory ({$startdir}) does not exist. <br><br>"; }
			return($directorylist);
		}
	}

?>
