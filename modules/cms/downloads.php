<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	// Soon this will check if the file exists.
	if ($product_name) {
		if ($version) { header ("Location: $website/products/$product_name v$version.zip"); }
		else { header ("Location: $website/products/$product_name.zip"); }
	}
	else {
		$custom_title = "File Download";
		$custom_header = "File Download";
		$custom_body = "Below is a list of files that are currently available to download.";
	}
	
?>
