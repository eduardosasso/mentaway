head.ready(function(){
	$('a#states, #states_stats_btn').click(function(){
		get_db_view("users", "stats", $(this).attr('data-uid'), function(data){
			states = data.rows[0].value.states;
			//pega os valores do objeto e converte em array. via underscore.js
			states = _.values(states);
			
			states_list = states.join("|");
			states_print = states.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ states_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'States map',
				description: states_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});		
	});
	
	$('a#cities, #cities_stats_btn').click(function(){
		get_db_view("users", "stats", $(this).attr('data-uid'), function(data){
			cities = data.rows[0].value.cities;
			//pega os valores do objeto e converte em array. via underscore.js
			cities = _.values(cities);
			
			cities_list = cities.join("|");
			cities_print = cities.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ cities_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'Cities map',
				description: cities_print,
				link: picture_,
				picture: picture_
			};

			FB.ui(publish);
			
		});		
	});
	
	$('a#countries, #countries_stats_btn').click(function(){
		get_db_view("users", "stats", $(this).attr('data-uid'), function(data){
			countries = data.rows[0].value.countries;
			//pega os valores do objeto e converte em array. via underscore.js
			countries = _.values(countries);
			
			countries_list = countries.join("|");
			countries_print = countries.join(", ");
			
			var picture_ = 'http://maps.google.com/maps/api/staticmap?size=900x400&maptype=roadmap&markers='+ countries_list + '&sensor=false';

			var publish = {
				method: 'feed',
				message: '',
				name: 'Countries map',
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
	
	FB.Event.subscribe('comments.add', function(response) {	
		var xid_ = $('article.hover').attr('data-xid');
		
		FB.api({
			method: 'comments.get', 
			xid: xid_
		}, function (res) {
			var user_id = $('article.hover').attr('data-user_id');
			
			var title_ = $('article.hover h1').text();
			var body_ = jQuery.trim($('article.hover div.description').text());
			var caption_ = $('article.hover p.address').text();
			var img_ = $('article.hover .description img').attr('src');
			
			var link_ = 'http://apps.facebook.com/mentaway/';
			if (img_) {
				link_ = $('article.hover .description a.lightbox').attr('href');
			};
			
			var params = {};
			params['message'] = res[0].text;
			params['name'] = title_;
			params['caption'] = caption_;
			params['description'] = body_;
			params['link'] = link_;
			params['picture'] = img_;
			
			FB.api('/'+ user_id + '/feed', 'post', params);
		});
		
	});
	
	
	$('article').mouseover(function(){
		$('article').removeClass('hover');
		$(this).addClass('hover');
		
		var user_id = $(this).attr('data-user_id');
		var placemark = $(this).attr('data-placemark');
				
		var url_ = 'http://mentaway.com/' + user_id + '/' + placemark;
		//var like_ = '<fb:like show_faces="true" layout="box_count" href="' + url_ + '"></fb:like>';

	});
	
	$('.comment_link').click(function(e){
		e.stopPropagation();
		item = $(this).closest('article');
		var user_id = $(item).attr('data-user_id');
		var xid_ = $(item).attr('data-xid');
		
		var like_ = '<fb:comments numposts="10" width="400" publish_feed="false" simple="1" show_form="true" notify="true" canpost="true" xid="'+ xid_ +'" css="http://fb.mentaway.com/facebook/css/fb_comments6.css" send_notification_uid="'+ user_id + '"></fb:comments>';
		
		if ($('.share', $(item)).html() == "")  {
			$('.share', $(item)).html(like_);
			
			el_ = $('.share', $(item)).get(0);
			
			FB.XFBML.parse(el_);		
		}
		
		$('.share', $(item)).toggle();
		
		return false;			
	});

	if ($('section#timeline').length > 0) {
		previous_marker = '';

		Map.init({maptype: 'ROADMAP'});
		Map.add('-20.468189', '-59.589844');
		Map.set_zoom(2);		
	};
	
	//arruma a altura do scroll interno dinamicamente
	window_height_ = $(window).height();
	$('section#timeline').css('height', window_height_);
	
	if ($('section#friends').css('height') < window_height_) {
		$('section#friends').css('height', window_height_);	
	};
	
	//console.log($('section#settings').get(0).offsetHeight);
	$('section#settings').css('height', $(window).height());	
	
	$('section#timeline').gWaveScrollPane();
	
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