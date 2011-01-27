$(function(){
	$('article').mouseover(function(){
		geocoder = new google.maps.Geocoder();
		var lat_ = $(this).attr('data-lat');
		var long_ = $(this).attr('data-long');
		
		var latlng = new google.maps.LatLng(lat_, long_);
		
		$this_ = $(this);
		
		geocoder.geocode( { 'location': latlng}, function(results, status) {
			if (!results) {
				return;
			};
			
			formatted_address_ = results[0].formatted_address;
			
			address_ = $('p.address', $this_);
			//console.log(address_);
			
			if (address_.text() == '') {
				address_.text(formatted_address_);
			}
			
		});

	});
	
	previous_marker = '';
	
	Map.init({maptype: 'ROADMAP'});
	Map.add('-20.468189', '-59.589844');
	Map.set_zoom(2);
	
	$('#placemarks').gWaveScrollPane();
	
	$('#placemarks article').click(function(){
		if (previous_marker) previous_marker.setMap(null); 
		
		lat_ = $(this).attr('data-lat');
		long_ = $(this).attr('data-long');
		
		var latlng = new google.maps.LatLng(
			parseFloat(lat_),
			parseFloat(long_)
		);

		var marker = new google.maps.Marker({
			map: Map.gmap,
			position: latlng,
			animation: google.maps.Animation.DROP
		});

		Map.gmap.panTo(latlng);
		
		/*
			TODO ver se o usuario mudou o zoom se sim manter o dele
		*/
		Map.gmap.setZoom(15);
		
		previous_marker = marker;
		
	});
		
});