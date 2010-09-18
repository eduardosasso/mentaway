var base_url='';
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
	/*
		TODO validar user defined.
	*/
	args = {
		a: "markers", 
		uid: user
	}
	
	$.getJSON(base_url + 'ajax.php', args, function(data) {		
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

get_post = function(callback){
	args = {
		a: "posts", 
		uid: user
	}
	
	$.getJSON(base_url + 'ajax.php', args, function(data) {		
		callback(data);
	})
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

add_markers_external_navigation = function(){
	var idx = (markers.length -1);
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

				get_post(function(post){
					title = post[0]['title'];
					body = post[0]['body'];

					$('#post #title').html(title);
					$('#post #body').html(body);
				});

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
		
		$('#new_user_account').click(function(){
			user = $('#user_field').val();
			save_user(user);
		});

});
