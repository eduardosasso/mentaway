head.ready(function(){
	$('a#states').click(function(){
		get_db_view("users", "stats", FB.getSession().access_token, function(data){
			states = data.rows[0].value.states;
			//pega os valores do objeto e converte em array. via underscore.js
			states = _.values(states);
			
			states_list = states.join("|");
			states_print = states.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ states_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'Some places I\'ve been',
				description: states_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});		
	});
	
	$('a#cities').click(function(){
		get_db_view("users", "stats", FB.getSession().access_token, function(data){
			cities = data.rows[0].value.cities;
			//pega os valores do objeto e converte em array. via underscore.js
			cities = _.values(cities);
			
			cities_list = cities.join("|");
			cities_print = cities.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ cities_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'Some places I\'ve been',
				description: cities_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});		
	});
	
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
				name: 'Countries I\'ve visited',
				description: countries_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});
		
	});
	
	FB.Event.subscribe('edge.create', function(response) {
		var user_id = $('article.hover').attr('data-user_id');
		
		var title = $('article.hover h1').text();
		var body = jQuery.trim($('article.hover div.description').text());
		
		var picture_ = 'http://mentaway.com/images/facebook_like.png';
		message_ = "Likes " + body + ' @ ' + title; 
		
		FB.api('/'+ user_id + '/feed', 'post', { message: message_, picture: picture_ });
		
	});
	
	$('article').mouseover(function(){
		$('article').removeClass('hover');
		$(this).addClass('hover');
		
		var user_id = $(this).attr('data-user_id');
		var placemark = $(this).attr('data-placemark');
				
		var url_ = 'http://mentaway.com/' + user_id + '/' + placemark;
		var like_ = '<fb:like show_faces="true" layout="box_count" href="' + url_ + '"></fb:like>';
		
		if ($('.share', $(this)).html() == "")  {
			$('.share', $(this)).html(like_);
			
			el_ = $('.share', $(this)).get(0);
			
			FB.XFBML.parse(el_);
		}

	});

	previous_marker = '';
	
	Map.init({maptype: 'ROADMAP'});
	Map.add('-20.468189', '-59.589844');
	Map.set_zoom(2);
	
	//arruma a altura do scroll interno dinamicamente
	$('#timeline').css('height', $(window).height());
	
	$('#timeline').gWaveScrollPane();
	
	FB.Canvas.setAutoResize();
	
	$('#timeline article').click(function(){
		$('article').removeClass('active');
		$(this).addClass('active');
		
		if (!previous_marker) {
			//se não teve nenhum placemark entao seta um zoom padrao
			Map.gmap.setZoom(15);
		} else {
			previous_marker.setMap(null); 
		}	
		
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
		
		previous_marker = marker;
		
	});
	
	$('#timeline article:first').trigger('click');
		
});