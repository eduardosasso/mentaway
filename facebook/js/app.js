head.ready(function(){
	$('a#states, #states_stats_btn').click(function(){
		get_db_view("users", "stats", $(this).attr('data-uid'), function(data){
			states_ = data.rows[0].value.states;
			//pega os valores do objeto e converte em array. via underscore.js
			states_ = _.values(states_);
			
			states_list = states_.join("|");
			states_print = states_.join(", ");
			
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
			cities_ = data.rows[0].value.cities;
			//pega os valores do objeto e converte em array. via underscore.js
			cities_ = _.values(cities_);
			
			cities_list = cities_.join("|");
			cities_print = cities_.join(", ");
			
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
			countries_ = data.rows[0].value.countries;
			//pega os valores do objeto e converte em array. via underscore.js
			countries_ = _.values(countries_);
			
			countries_list = countries_.join("|");
			countries_print = countries_.join(", ");
			
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
			var img_ = $('article.hover .description img:not(.icon)').attr('src');
			
			var link_ = 'http://apps.facebook.com/mentaway/';
			if (img_) {
				link_ = $('article.hover .description a.lightbox').attr('href');
			} else {
				lat_ = $('article.hover').attr('data-lat');
				long_ = $('article.hover').attr('data-long');
				img_ = "http://foursquare.com/mapproxy/"+ lat_ + "/" + long_ +"/map.png";
			}
			
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
	
	
	$('#timeline article').mouseover(function(){
		$('article').removeClass('hover');
		$(this).addClass('hover');
		
		xid_ = $(this).attr('data-xid');

		//recupera o número de comentários
		this_ = $(this);
		if ($('.comment_link', $(this_)).hasClass('count') == false) {
			FB.api({
				method: 'comments.get',
				xid: xid_
			}, function(response) {
				comments_ = eval(response);
				if (comments_ && comments_.length > 0) {
					comments_count_ = comments_.length;
					$('.comment_link', $(this_)).addClass('count');
					comment_label_ = ' comments';
					if (comments_count_ == 1 ) comment_label_ = ' comment';
					$('.comment_link', $(this_)).html(comments_count_ + comment_label_);
				};
			});
		}

		// var user_id = $(this).attr('data-user_id');
		// 		var placemark = $(this).attr('data-placemark');

		//var url_ = 'http://mentaway.com/' + user_id + '/' + placemark;
		//var like_ = '<fb:like show_faces="true" layout="box_count" href="' + url_ + '"></fb:like>';

	});
	
	$('.comment_link').click(function(e){
		e.stopPropagation();
		item_ = $(this).closest('article');
		var user_id = $(item_).attr('data-user_id');
		var xid_ = $(item_).attr('data-xid');
		
		var like_ = '<fb:comments numposts="10" width="510" publish_feed="false" simple="1" show_form="true" notify="true" canpost="true" xid="'+ xid_ +'" css="http://fb.mentaway.com/facebook/css/fb_comments8.css" send_notification_uid="'+ user_id + '"></fb:comments>';
		
		if ($('.share', $(item_)).html() == "")  {
			$('.share', $(item_)).html(like_);
			
			el_ = $('.share', $(item_)).get(0);
			
			FB.XFBML.parse(el_);		
		}
		
		$('.share', $(item_)).toggle();
		
		return false;			
	});

	if ($('section#timeline').length > 0) {
		previous_marker = '';

		Map.init({maptype: 'ROADMAP'});
		Map.add('-20.468189', '-59.589844');
		Map.set_zoom(2);
		
		if ($('section#timeline article:not(.void)').length > 0) {
			var adUnitDiv = document.createElement('div');
			var adUnitOptions = {
				format: google.maps.adsense.AdFormat.BUTTON,
				position: google.maps.ControlPosition.RIGHT,
				map: Map.gmap,
				visible: true,
				publisherId: 'pub-8046450694828694'
			}
			adUnit_ = new google.maps.adsense.AdUnit(adUnitDiv, adUnitOptions);
		}
				
	};
	
	//arruma a altura do scroll interno dinamicamente
	window_height_ = $(window).height();

	//$('section#timeline, section#settings').css('height', window_height_);

	$('section#friends, section#settings, section#about').css('min-height', window_height_);	
	$('section#help').css('min-height', 900);
 	
	if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)) {
		$('section#timeline nav').touchScroll();
		$('section#timeline').css("overflow-y", "auto");	
	} else {
		$('section#timeline').css('height', 620);
		
		//nav_height = $('section#timeline nav').height();
		//$('section#timeline nav').height(nav_height + 300);
		
		if ($('section#timeline article:not(.void)').length == 0) {
			$('section#timeline').hide();
		} else {
			$('section#timeline').gWaveScrollPane();
			$('section#timeline').css("overflow", "hidden");
		}
		
	}
	
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
		xid_ = $(this).attr('data-xid');
		
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
		
		xid_ = $(this).attr('data-xid');
		
		//recupera o número de comentários
		this_ = $(this);
		if ($('.comment_link', $(this_)).hasClass('count') == false) {
			FB.api({
				method: 'comments.get',
				xid: xid_
			}, function(response) {
				comments_ = eval(response);
				if (comments_ && comments_.length > 0) {
					comments_count_ = comments_.length;
					$('.comment_link', $(this_)).addClass('count');
					comment_label_ = ' comments';
					if (comments_count_ == 1 ) comment_label_ = ' comment';
					$('.comment_link', $(this_)).html(comments_count_ + comment_label_);
				};
			});
		}	
		
	});
	
	$('section#timeline article:first:visible').trigger('click');
		
});