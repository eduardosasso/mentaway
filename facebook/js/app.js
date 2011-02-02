head.ready(function(){
	
	$('a#countries').click(function(){
		get_db_view("users", "stats", FB.getSession().access_token, function(data){
			countries = data.rows[0].value.countries;
			//pega os valores do objeto e converte em array. via underscore.js
			countries = _.values(countries);
			
			countries_list = countries.join("|");
			countries_print = countries.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ countries_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'Countries i\'ve visited',
				description: countries_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});
		
	});
	
	FB.Event.subscribe('edge.create', function(response) {
		var user_id = $('article.active').attr('data-user_id');
		
		var title = $('article.active h1').text();
		var body = jQuery.trim($('article.active div.description').text());
		
		var picture_ = 'http://mentaway.com/images/facebook_like.png';
		message_ = "Likes " + body + ' @ ' + title; 
		
		FB.api('/'+ user_id + '/feed', 'post', { message: message_, picture: picture_ });
		
	});
	
	$('article').mouseover(function(){
		geocoder = new google.maps.Geocoder();
		var lat_ = $(this).attr('data-lat');
		var long_ = $(this).attr('data-long');
		var user_id = $(this).attr('data-user_id');
		var placemark = $(this).attr('data-placemark');
				
		var latlng = new google.maps.LatLng(lat_, long_);
		
		$this_ = $(this);
		
		var url_ = 'http://mentaway.com/' + user_id + '/' + placemark;
		var like_ = '<fb:like show_faces="true" width="450" href="' + url_ + '"></fb:like>';
		
		$('article').removeClass('active');
		$(this).addClass('active');
		
		if ($('.share', $(this)).html() == "")  {
			$('.share', $(this)).html(like_);
			
			el_ = $('.share', $(this)).get(0);
			
			FB.XFBML.parse(el_);
		}
		
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