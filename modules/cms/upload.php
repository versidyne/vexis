<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	if ($_POST['submit'] == "true") {
		// Debug Info
		//$form_message .= print_r($_FILES);
		// Check file size
		if ($_FILES["file"]["size"] < $settings["max_filesize"]) {
			// Check for errors
			if ($_FILES["file"]["error"] > 0) {
				$form_message = "Return Code: " . $_FILES["file"]["error"] . "<br />";
			}
			else {
				// Find basic mime
				if ($_FILES["file"]["type"]) {
					$file_type = explode("/", $_FILES["file"]["type"]);
					$type = $file_type[0];
					// Ensure directory existence
					if (!is_dir("files/{$type}/")) { mkdir("files/{$type}/", 0777); }
				} else { $type = "misc"; }
				// Display data
				$form_message = "File Name: {$_FILES["file"]["name"]}<br>";
				$form_message .= "File Type: {$type}<br>";
				$form_message .= "File Mime: {$_FILES["file"]["type"]}<br>";
				$form_message .= "File Size: ".($_FILES["file"]["size"] / 1024)." Kb<br>";
				$form_message .= "Temporary File: {$_FILES["file"]["tmp_name"]}<br>";
				// Move file to limbo for analysis
				$limbo = "limbo/{$_FILES["file"]["name"]}";
				move_uploaded_file($_FILES["file"]["tmp_name"], $limbo);
				chmod($limbo, 0777);
				// Find file extension
				if (file_exists($limbo)) { $ext = pathinfo($limbo, PATHINFO_EXTENSION); }
				else { $ext = "ext"; }
				$form_message .= "Limbo File: {$limbo}<br>";
				$form_message .= "File Extension: {$ext}<br>";
				// Generate random name
				$data = new data();
				// Put the next two lines into a loop, checking to see
				// if the file path exists and regenerating a number code
				$file = $data->random(10, 20);
				$form_message .= "Random Name: {$file}.{$ext}<br>";
				$path = "files/{$type}/{$file}.{$ext}";
				// Verify path
				if (file_exists($path)) {
					$form_message .= "<br>File <i>{$file}.{$ext}</i> already exists. <br><br>";
					// Delete temporary file
					unlink($limbo);
				}
				else {
					// Copy to destination
					if (copy($limbo, $path)) {
						// Delete temporary file
						unlink($limbo);
						// Set file permissions
						chmod($path, 0777);
						// Create Row
						$pid = $database->create_row("media");
						// Catalog File
						$database->query ("UPDATE `media` SET `type` = '{$type}', `mime` = '{$_FILES["file"]["type"]}', `src` = '{$file}.{$ext}', `name` = '{$file}', `featured` = '0', `remote` = '0', `enabled` = '1' WHERE `id` ='{$pid}' LIMIT 1");
						// Return information
						$form_message .= "File Path: <a href=\"{$settings['website']}/{$path}\">{$path}</a><br>";
						$form_message .= "CDN Display: <a href=\"<media:{$file}\"><media:{$file}</a><br>";
					}
					else {
						$form_message .= "Path: The file did not reach its destination.<br>";
						$form_message .= "CDN: The file did not reach its destination.<br>";
					}
				}
			}
		}
		else {
			$form_message = "File is larger than the allowed size.";
		}
	}
	
?>
