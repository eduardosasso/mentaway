function init_map(lat, long, element) {
	var myLatlng = new google.maps.LatLng(lat, long);
	var myOptions = {
		zoom: 15,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(element, myOptions);
	
	var ctaLayer = new google.maps.KmlLayer('http://feeds.foursquare.com/history/G0YBJX4MHOJ1YTE3TXRNNBPQV3HSIBPQ.kml');
	ctaLayer.setMap(map);
}

function init_map_default(element){
	navigator.geolocation.getCurrentPosition(function(p) {
		lat = p.coords.latitude;
		long = p.coords.longitude;
		
		init_map(lat, long, element);
	});	
}

$(document).ready(function() {
	init_map_default($('#map_canvas').get(0));
});
