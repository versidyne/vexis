<?php
	
	if ($validator['code'] != md5($validator['key'])) { echo "Please do not access this file directly."; exit; }
	
	$header = "Dashboard";
	$body = "<div class=\"minimal\">
		<div id=\"draggable\" class=\"draggable ui-widget-content right\" title=\"Alexa Internet Ranking\">
			<script type=\"text/javascript\" src=\"http://widgets.alexa.com/traffic/javascript/graph.js\"></script>
			<script type=\"text/javascript\">
				<!--
					// USER-EDITABLE VARIABLES
					// enter up to 3 domains, separated by a space
					var sites      = ['{$settings['domain']}'];
					var opts = {
						width:      400,  // width in pixels (max 400)
						height:     220,  // height in pixels (max 300)
						type:       'r',  // \"r\" Reach, \"n\" Rank, \"p\" Page Views
						range:      '3m', // \"7d\", \"1m\", \"3m\", \"6m\", \"1y\", \"3y\", \"5y\", \"max\"
						bgcolor:    'e6f3fc' // hex value without \"#\" char (usually \"e6f3fc\")
					};
					// END USER-EDITABLE VARIABLES
					AGraphManager.add( new AGraph(sites, opts) );
				//-->
			</script>
		</div>
		<!--<div id=\"dialog\" class=\"dialog\" title=\"Under Construction\">
			<p>Many features will be built and changed in a short period of time to make this system more user friendly.  We appreciate your cooperation with this matter and look forward to any feedback regarding this process.  Thanks.<br>
			<br>
			Administration</p>
		</div>-->
	</div>
	<!--End of dashboard-->";
	$highlight = "dashboard";
	$continue = false;
	
?>
