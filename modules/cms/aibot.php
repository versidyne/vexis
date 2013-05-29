<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	if ($_POST['submit'] == "true") {
		if (preg_match ("^(|.*?\b|.*?\s)What\b.+?\bis\b.+?\byour\b.+?\bname(|\b.*?|\s.*?)$", "{$_POST['query']}")) {
			$form_message = "I am merely a program, I don't have a name yet.";
		} else {
			$form_message = "I do not understand your statement.";
		}
	}
	
	
?>
