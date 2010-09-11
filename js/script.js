var map;
var markers = [];
var infoWindow;


init_map = function(lat, long, element) {
	var myLatlng = new google.maps.LatLng(lat, long);
	var myOptions = {
		zoom: 15,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	
	map = new google.maps.Map(element, myOptions);
	infoWindow = new google.maps.InfoWindow();
}

init_map_current_location = function(element){
	navigator.geolocation.getCurrentPosition(function(p) {
		lat = p.coords.latitude;
		long = p.coords.longitude;
		
		init_map(lat, long, element);
	});	
}

create_marker = function(placemark){
	var html = placemark.name;
	
	var latlng = new google.maps.LatLng(
		parseFloat(placemark.lat),
		parseFloat(placemark.long)
	);

	var marker = new google.maps.Marker({
		map: map,
		position: latlng
	});

	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	});
	
	markers.push(marker);
}

add_placemarks_on_the_map = function(callback){
	$.getJSON('model/markers.php', function(data) {
		callback(data);
	})
}

$(document).ready(function() {
		map_elem = $('#map_canvas').get(0);
		
		add_placemarks_on_the_map(function(placemarks){
			most_recent_location = {
				lat: placemarks[0]['lat'], 
				long: placemarks[0]['long']
			}
			
			//inicia o map sempre na ultima localizacao do usuario
			init_map(most_recent_location.lat, most_recent_location.long, map_elem);
			
			$.each(placemarks, function(i,placemark) {
				create_marker(placemark);
			});
			
		});		
});
