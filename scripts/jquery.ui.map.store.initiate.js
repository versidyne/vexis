$(function() {
	//var mapcenter = new google.maps.LatLng(37.434538, -121.89970399999999);
	//var device = 1;
	var mapcenter = new google.maps.LatLng(37.0625, -95.677068);
	var zoomlevel = 3;
	$('#map_store').gmap({ 'center': mapcenter, 'zoom': zoomlevel }).bind('init', function() {	
		$.ajax({
			type: "GET",
			url: "/?page=stores",
			dataType: "xml",
			success: function( xmlResponse ) {
				$(xmlResponse).find("coordinate").each(function(){
					// gather data
					name = $(this).find("name").text();
					latitude = $(this).find("latitude").text();
					longitude = $(this).find("longitude").text();
					description = $(this).find("description").text();
					
					// make description
					var markerhtml;
					markerhtml = "<div class='mapinfo'>";
					markerhtml += "<div>" + name + "</div>";
					markerhtml += "<div>&nbsp;</div>";
					markerhtml += description;
					markerhtml += "</div>";
					
					//$('#map_store').gmap('addMarker', {'position': latitude+','+longitude, 'bounds': true, 'icon':'/styles/maps/pin_map_down.png', 'shadow':'/styles/maps/pin_shadow.png' } ).click(function() {
					$('#map_store').gmap('addMarker', {'position': latitude+','+longitude, 'bounds': true, 'icon':'/styles/maps/pin_map_down.png' } ).click(function() {
						$('#map_store').gmap('openInfoWindow', {  'maxWidth':'260', 'content': markerhtml }, this);
					});
				});
			}
		});
	});
});
