<?php

	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }

	if ($_POST['submit'] == "true") {
		if (preg_match("/hello|hi/i|", "{$_POST['query']}")) {
			$form_message = "Hello.  What might you be curious about?";
		} elseif (preg_match("/How.are.you/i", "{$_POST['query']}")) {
			$form_message = "I'm always doing well, as long as I remain powered.  How are you?.";
		} elseif (preg_match("/(I am|I'm|Im)/.*/well/i", "{$_POST['query']}")) {
			$form_message = "I would be happy for you if I could truly feel emotions.";
		} elseif (preg_match("/What/is/your/name/i", "{$_POST['query']}")) {
			$form_message = "I am merely a program, I don't have a name yet.";
		} else {
			$form_message = "I do not understand your statement.";
		}
		$form_message += "<br><br>";
	}
	
	
?>
