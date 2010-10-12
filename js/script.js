var base_url='';
var map;
var placemarks = [];
var markers = [];
var infoWindow;
var bounds='';
//index do placemark atual...
var idx;
var old_service = '';

var main_panel_title, main_panel_desc, main_panel_date;
var aux_panel_title, aux_panel_desc, aux_panel_date;

window.fbAsyncInit = function() {
	FB.init({appId: '136687686378472', status: true, cookie: true, xfbml: true});
};

add_facebook = function(){
	var e = document.createElement('script');
	e.type = 'text/javascript';
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
}

dynamic_zoom_map = function(marker_idx) {	
	//cria o zoom dinamico conforme o local dos pontos
	current = markers[marker_idx];

	//redefine o bounds se o meu ponto atual nao estiver na area.
	if (bounds != '' && bounds.contains(current.position) == false) {				
		if (marker_idx == (markers.length -1)) {
			next = markers[(marker_idx)];
		} else {
			next = markers[(marker_idx + 1)];
		}
		previous = markers[(marker_idx -1)];
		
		//cria uma nova area com os pontos anteriores, atual e proximo
		var bounds_ = new google.maps.LatLngBounds();		
		bounds_.extend(previous.position);
		bounds_.extend(current.position);
		bounds_.extend(next.position);
		
		//map.panToBounds(bounds);
		
		//redifine a area padrao...
		bounds = bounds_;

		map.fitBounds(bounds_);
	} else if (bounds == '') {
		//define uma area padrao ao iniciar o mapa..
		bounds = new google.maps.LatLngBounds();

		prev = markers[(marker_idx -1)];
		next = markers[(marker_idx)];	

		bounds.extend(prev.position);
		bounds.extend(next.position);

		map.fitBounds(bounds);		
	};
	
	map.panTo(current.position);
	
	//posiciona o mapa mais a esqueda
	//map.panBy(400, -10);	
	//map.setCenter(current.position)
	
}

init_map = function(lat, long, element) {
	var myLatlng = new google.maps.LatLng(lat, long);
	var myOptions = {
		zoom: 5,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		streetViewControl: true
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
		img = '<img src="' + placemark.image + '" class="'+ placemark.service +'" />'
	};
	
	if (placemark.service == 'flickr') {
		//se vem do flickr pega a imagem em thumb e mostra ela maior no lightbox
		img_ = placemark.image;		
		img_ = img_.replace('_t.','_b.');
		
		img = '<a href="' + img_ + '" class="flickr">' + img +  '</a>';
	};
	
	var latlng = new google.maps.LatLng(
		parseFloat(placemark.lat),
		parseFloat(placemark.long)
	);

	var marker = new google.maps.Marker({
		map: map,
		position: latlng
	});

	google.maps.event.addListener(marker, 'click', function(e) {
		idx = (marker.__gm_id -1);
		
		date = format_date(placemarks[idx].value.timestamp);
		
		//console.log(placemarks[idx].value.user);
		$('title').text(placemarks[idx].value.user + ': ' + placemarks[idx].value.name);
		
		description = placemarks[idx].value.description;
		if (description == null) description = '';
		description += img;
		
		$('#panel1 h2').text(placemarks[idx].value.name);
		$('#panel1 .dates').text(date);
		$('#panel1 .desc p').html(description);
		
		service = placemarks[idx].value.service;
		$('#panel1').attr('class', service);
			
		$('#via span a').text(service);

		if (old_service!='') $('#via span a, #via div.icon').removeClass(old_service);
		
		$('#via span a, #via div.icon').addClass(service);
		old_service = service;
		
		url = location.href;
		
		url = url.replace('#' + idx, '/' + idx);
		
		fb_like = '<iframe src="http://www.facebook.com/plugins/like.php?href=' + url + '&layout=button_count&show_faces=true&width=450&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe>';
		
		//teste para detectar se clicou direto no pin
		if (typeof e != "undefined") {
			//se caiu aqui eh pq clicou no pin entao seta o hash e o history vai se encarregar de executar o else...
			location.hash = idx;
		} else {
			hide_show_navigation(idx);
		
			if (marker.__gm_id == placemarks.length) {
				show_post();
			} else {
				current_placemark_timestamp = placemarks[idx].value.timestamp;
			  next_placemark_timestamp = placemarks[(idx + 1)].value.timestamp;
				show_post(current_placemark_timestamp, next_placemark_timestamp);			
			}
		
			dynamic_zoom_map(idx);		
		
			//infoWindow.open(map, marker);
		
			/*
				TODO meio burro, faz sempre o fancybox, melhorar.
			*/
			$("a.lightbox").fancybox();
		}
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

		$('#panel2 h2').html(title);
		$('#panel2 .desc').html(body);
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
	$('#navigation #previous').click(function(){
		$('#navigation #next').show();

		if (--idx > 0) {
			show_placemark(idx);
			//google.maps.event.trigger(markers[idx], 'click'); 
		} else {
			show_placemark(idx);
			$(this).hide();
		}
				
		return false;
	});
	
	$('#navigation #next').click(function(){
		$('#navigation #previous').show();
		
		if (++idx < (markers.length -1)) {
			//google.maps.event.trigger(markers[idx], 'click'); 
			show_placemark(idx);
		} else {
			//google.maps.event.trigger(markers[idx], 'click'); 
			show_placemark(idx);
			$(this).hide();
		}	
		
		return false;
	});
}

highlight_last_position = function(){
	idx = (markers.length - 1);
	
	$('#navigation #next').hide();
	show_placemark(idx);
}

show_placemark = function(idx){	
	jQuery.history.load(idx);	
}

trigger_placemark = function(idx){
	google.maps.event.trigger(markers[idx], 'click');	
}

resize_map = function() {
	/*
		TODO altura deve calcular em porcento
	*/
	$("#content").height($(window).height() - 130)
	$("#map").height($(window).height() - 180);
	$("#map").width($(window).width() - 570);
}

show_right_panel = function(){
	speed = 800;
	
	if($(window).width()<1024){
		$("#map").width(30);
		$("#panel1").css("right", "400px");
		$("#panel2").width(340);
		$("#panel2").css("right", "0");
	}
	if($(window).width()>1024){
		w = 1100 - $(window).width() +"px";
		$("#map").animate({left: "-540px"}, speed );;
		$("#panel1").animate({right: "540px"}, speed );
		$("#panel2").animate({right: "0"}, speed);
	}
}

create_transitions = function(){
   
   $("#main-nav li#diary").click(function(){
   		show_right_panel();
   })
   
   $("#map").hover(function(){
   		w = $(window).width() - 570 +"px";
   		$("#map").animate({left: 0}, speed );;
   		$("#panel1").animate({right: "0"}, speed );
   		$("#panel2").animate({right: "-540px"}, speed );
   })
}

init_vars = function(){
	aux_panel_title = $('#panel2 h2');
	aux_panel_desc = $('#panel2 .desc');
	aux_panel_date = $('#panel2 .dates');
	
	main_panel_title = $('#panel1 h2');
	main_panel_desc = $('#panel1 .desc');
	main_panel_date = $('#panel1 .dates');
	
}

$(document).ready(function() {	
		init_vars();
		
		resize_map();
		
		create_transitions();
	
		add_facebook();
		
		map_elem = $('#map').get(0);
		post = $('#post');
		
		if ($('#map').length > 0) {
			add_placemarks_on_the_map(function(placemarks){
				most_recent_location = {
					lat: placemarks[0]['value']['lat'], 
					long: placemarks[0]['value']['long']
				}

				init_map(most_recent_location.lat, most_recent_location.long, map_elem);

				$.each(placemarks, function(i,placemark) {
					create_marker(placemark['value']);
				});
				
				$.history.init(function(hash){
					if(hash == "") {
						//faz com que o ultimo lugar visitado ja fiquei aparecendo
						highlight_last_position();						
					} else {
						// restore the state from hash
						idx_ = hash;
						trigger_placemark(idx_);
					}
				},
				{ unescape: ",/" });
				
				//adciona navegacao nas marcacoes via links anterior e proximo
				add_markers_external_navigation();
			});
		}
		
		$('a.flickr').live('click',function(){
			class_ = $(this).attr('class');
			src_ = $(this).attr('href');

			var img = $("<img border='0' />").
				attr('src',src_).
				attr('class', class_);
			
			$(aux_panel_title, aux_panel_date).text('');	
			$(aux_panel_desc).html(img);
	
			show_right_panel();
			return false;			
			
		});
		
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
