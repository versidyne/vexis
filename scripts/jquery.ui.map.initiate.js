$(function() {
	//var mapcenter = new google.maps.LatLng(37.434538, -121.89970399999999);
	//var device = 1;
	var mapcenter = new google.maps.LatLng(37.0625, -95.677068);
	var zoomlevel = 3;
	$('#map_locations').gmap({ 'center': mapcenter, 'zoom': zoomlevel }).bind('init', function() {	
		$.ajax({
			type: "GET",
			url: "/?page=locations&output=xml&device=" + device,
			dataType: "xml",
			success: function( xmlResponse ) {
				$(xmlResponse).find("coordinate").each(function(){
					// gather data
					timestamp = $(this).find("timestamp").text();
					units = $(this).find("units").text();
					accuracy = $(this).find("accuracy").text();
					altitude = $(this).find("altitude").text();
					bearing = $(this).find("bearing").text();
					latitude = $(this).find("latitude").text();
					longitude = $(this).find("longitude").text();
					speed = $(this).find("speed").text();
					
					//convert time
					var time = new Date(timestamp * 1000);
					
					// make description
					var markerhtml;
					markerhtml = "<div class='mapinfo'>";
					markerhtml += "<div>" + time + "</div>";
					markerhtml += "<div>&nbsp;</div>";
					markerhtml += "<div>Units: " + units + "</div>";
					markerhtml += "<div>Accuracy: " + accuracy + " feet</div>";
					markerhtml += "<div>Altitude: " + altitude + " feet</div>";
					markerhtml += "<div>Bearing: " + bearing + "&deg;</div>";
					markerhtml += "<div>Latitude: " + latitude + "</div>";
					markerhtml += "<div>Longitude: " + longitude + "</div>";
					markerhtml += "<div>Speed: " + speed + " mph</div>";
					markerhtml += "</div>";
					
					//$('#map_locations').gmap('addMarker', {'position': latitude+','+longitude, 'bounds': true, 'icon':'/styles/maps/pin_map_down.png', 'shadow':'/styles/maps/pin_shadow.png' } ).click(function() {
					$('#map_locations').gmap('addMarker', {'position': latitude+','+longitude, 'bounds': true, 'icon':'/styles/maps/pin_map_down.png' } ).click(function() {
						$('#map_locations').gmap('openInfoWindow', {  'maxWidth':'260', 'content': markerhtml }, this);
					});
				});
			}
		});
	});
});
