var base_url='';
var map;
var placemarks = [];
var markers = [];
var infoWindow;
//index do placemark atual...
var idx;

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

format_date= function(date) {
	var dt = new Date(date*1000);
	return dt.toLocaleString();
}

create_marker = function(placemark){

	date = format_date(placemark.timestamp);
	
	var img = '';
	if (placemark.image) {
		img = '<img src="' + placemark.image + '"/>'
	};
	
	var desc = '';
	if (placemark.description) {
		desc = '<p class="desc">' + placemark.description + '</p>'; 
	};
		
	var html = 
		'<div class="infowindow">' + placemark.name + 
			'<p class="date">' + date + '</p>' + 
			desc + 
			img + 
		'</div>';	
	
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
	
		map.panTo(marker.position);
		map.panBy(400, -10);
		
		idx = (marker.__gm_id -1);
		
		hide_show_navigation(idx);
		
		if (marker.__gm_id == placemarks.length) {
			show_post();
		} else {
			current_placemark_timestamp = placemarks[idx].value.timestamp;
		  next_placemark_timestamp = placemarks[(idx + 1)].value.timestamp;
			show_post(current_placemark_timestamp, next_placemark_timestamp);			
		}		
		
		infoWindow.open(map, marker);
	});
	
	markers.push(marker);
}

add_placemarks_on_the_map = function(callback){
	/*
		TODO validar user defined.
	*/
	args = {
		a: "markers", 
		uid: user
	}
	
	$.getJSON(base_url + 'ajax.php', args, function(data) {
		placemarks = data;		
		callback(data);
	})
}

save_user = function(fields){
	args = {
		a: "save_user", 
		fields: fields
	}

	$.getJSON(base_url + 'ajax.php', args);
	
}

get_post = function(begin_date, end_date, callback){
	args = {
		a: "posts", 
		uid: user,
		begin: begin_date,
		end: end_date
	}
	
	$.getJSON(base_url + 'ajax.php', args, function(data) {		
		callback(data);
	})
}


show_post = function(begin_date, end_date) {
	get_post(begin_date, end_date, function(posts){
		title = posts[0]['title'];
		body = posts[0]['body'];

		$('#post #title').html(title);
		$('#post #body').html(body);
	});	
}

add_user_service = function(service,username){
	args = {
		username: username
	}
	
	url = base_url + '/services/' + service + '.php';
	
	$.get(url,args, function(url){
		window.location.replace(url);
	});
}

add_posterous = function(username,site, callback) {
	args = {
		username: username,
		site: site
	}

	url = base_url + '/services/posterous.php';
	
	$.get(url,args, function(data){
		callback(data);
	});	
}

add_trip = function(username, desc, callback) {
	args = {
		username: username,
		desc: desc
	}
	
	url = base_url + '/services/trip.php';
	
	$.get(url,args, function(data){
		callback(data);
	});
}

add_twitter = function(username, twitter, callback) {
	args = {
		username: username,
		twitter_user: twitter
	}

	url = base_url + '/services/twitter.php';
	
	$.get(url,args, function(data){
		callback(data);
	});
}


hide_show_navigation = function(idx){
	if (idx > 0 && idx <= (placemarks.length-1)) {
		$('#navigation #next, #navigation #previous,').show();
	} 

	if (idx == (placemarks.length-1)) {
		$('#navigation #next').hide();
	}
	
	if (idx == 0) {
		$('#navigation #previous').hide();
	}
}

add_markers_external_navigation = function(){
	//var idx = (markers.length -1);
	$('#navigation #next').hide();
	
	$('#navigation #previous').click(function(){
		$('#navigation #next').show();

		if (--idx > 0) {
			google.maps.event.trigger(markers[idx], 'click'); 
		} else {
			google.maps.event.trigger(markers[idx], 'click'); 
			$(this).hide();
		}
	});
	
	$('#navigation #next').click(function(){
		$('#navigation #previous').show();
		
		if (++idx < (markers.length -1)) {
			google.maps.event.trigger(markers[idx], 'click'); 
		} else {
			google.maps.event.trigger(markers[idx], 'click'); 
			$(this).hide();
		}	
	});
}

highlight_last_position = function(){
	idx = (markers.length - 1);
	google.maps.event.trigger(markers[idx], 'click'); 
}

$(document).ready(function() {
		map_elem = $('#map').get(0);
		post = $('#post');
		
		if ($('#map').length > 0) {
			add_placemarks_on_the_map(function(placemarks){
				most_recent_location = {
					lat: placemarks[0]['value']['lat'], 
					long: placemarks[0]['value']['long']
				}

				show_post();

				//inicia o map sempre na ultima localizacao do usuario
				init_map(most_recent_location.lat, most_recent_location.long, map_elem);

				$.each(placemarks, function(i,placemark) {
					create_marker(placemark['value']);
				});

				//faz com que o ultimo lugar visitado ja fiquei aparecendo
				highlight_last_position();

				//adciona navegacao nas marcacoes via links anterior e proximo
				add_markers_external_navigation();

			});
		}
		
		$('.add_user_service').click(function(){
			//usa pela class para ser generico e pegar todos os servicos...			
			
			service = $(this).attr('id');
			username = $('#username').val();
			
			add_user_service(service, username);
		});

		$('#add_posterous').click(function(){
			username = $('#username').val();
			site = $('#posterous_url').val();
			
			add_posterous(username,site, function(data){
				$('#posterous_block').html(data);
			});
		});
		
		$('#add_twitter').click(function(){
			username = $('#username').val();
			twitter = $('#twitter_user').val();
			
			add_twitter(username,twitter, function(data){
				$('#twitter_block').html(data);
			});
		});
		
		$('#add_trip').click(function(){
			username = $('#username').val();
			trip_desc = $('#trip_desc').val();
			
			add_trip(username,trip_desc, function(data){
				$('#trip_block').html(data);
			});
		});
		
		$('#new_user_account').click(function(){
			user = $('#user_field').val();
			save_user(user);
		});

});
