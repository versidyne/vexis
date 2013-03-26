<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	$securimage = new securimage();
	$securimage->ttf_file = 'styles/fonts/AHGBold.ttf';
	$securimage->show();
	
?>
