var Map = {
	placemarks: {},
	markers: [],
	marker_idx: '',
	gmap: null,
	//infoWindow: null,
	bounds: '',
	previous_marker: '',

	options: {
		container_el: $("#content"),
		map_el: $("#map"),
		user: '',
		active_icon: 'images/mark-active.png',
		default_icon: 'images/marks.png'
	},
	
	init: function(options) {			
		this.options = $.extend(this.options,options);
		this.show();
	},
	
	get_map_el: function(){
		return this.options.map_el;
	},

	get_current_idx: function(){
		return Map.marker_idx;
	},
	
	get_markers_count: function(){
		return (Map.markers.length - 1);
	},
	
	get_placemarks: function(callback){
		/*
			TODO validar user defined.
		*/
		args = {
			a: "markers", 
			uid: this.options.user
		}

		$.getJSON(base_url + 'ajax.php', args, function(data) {
			callback(data);
		})
	},
	
	add: function(lat, long) {
		var lat_long = new google.maps.LatLng(lat, long);
		var map_options = {
			zoom: 5,
			center: lat_long,
			mapTypeId: google.maps.MapTypeId.HYBRID,
			streetViewControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.BOTTOM_RIGHT
			},
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL,
				position: google.maps.ControlPosition.BOTTOM_LEFT 
			},
			scaleControl: false
		}
		
		this.gmap = new google.maps.Map(this.options.map_el.get(0), map_options);
		
		// var infoWindowOptions = {
		// 	maxWidth: 400
		// };
		// 
		// this.infoWindow = new google.maps.InfoWindow(infoWindowOptions);
	},
	
	resize_map: function() {
		/*
			TODO altura deve calcular em porcento
		*/
		this.options.container_el.height($(window).height() - 130)
		this.options.map_el.height($(window).height() - 180);
		this.options.map_el.width($(window).width() - 570);
	},
	
	add_marker: function(placemark){
		var latlng = new google.maps.LatLng(
			parseFloat(placemark.lat),
			parseFloat(placemark.long)
		);

		var marker = new google.maps.Marker({
			map: Map.gmap,
			position: latlng
		});
		
		marker.setIcon(Map.options.default_icon);
		
		google.maps.event.addListener(marker, 'click', function(e) {
			if (Map.previous_marker != '') {
				//volta o icone default ao ir para outro ponto
				Map.previous_marker.setIcon(Map.options.default_icon);
			}
			
			Map.marker_idx = (marker.__gm_id -1);
			
			marker.setIcon(Map.options.active_icon);
			Map.previous_marker = marker;
			
			var placemark = Map.placemarks[Map.marker_idx].value;
			
			Panel.update(placemark);
			
			Util.update_metatags(placemark);
			//var html = Panel.html(placemark);
			//Map.infoWindow.setContent(html);
			
			//teste para detectar se clicou direto no pin
			if (typeof e != "undefined") {
				//se caiu aqui eh pq clicou no pin entao seta o hash e o history vai se encarregar de executar o else...
				location.hash = Map.marker_idx;
			} else {
				Nav.hide_show();
				
				if (Map.marker_idx > 0) {
					
					var next_id = Map.marker_idx + 1;
					if (next_id < Map.placemarks.length) {
						current_placemark_timestamp = placemark.timestamp;
						next_placemark_timestamp = Map.placemarks[next_id].value.timestamp;
						Diary.get_posts(current_placemark_timestamp, next_placemark_timestamp);	
					} else {
						Diary.get_posts();
					}
					
				}
				
				Map.zoom();
				
				//Map.infoWindow.open(Map.gmap, marker);
				
				Util.update_share_buttons();
			}
			
		});	
		
		this.markers.push(marker);
	},
	
	show_placemark: function(idx){	
		jQuery.history.load(idx);	
	},
	
	trigger_placemark: function(idx){
		google.maps.event.trigger(this.markers[idx], 'click');	
	},
	
	highlight_most_recent: function(){
		var idx = (Map.placemarks.length - 1);
		// 	$('#navigation #next').hide();
		
		this.show_placemark(idx);
	},
	
	enable_history: function(){
		$.history.init(function(hash){
			if(hash == "") {
				//faz com que o ultimo lugar visitado ja fiquei aparecendo
				Map.highlight_most_recent();
			} else {
				// restaura o estado pelo hash
				var idx = hash;
				Map.trigger_placemark(idx);
			}
		},
		{ unescape: ",/" });
	},
	
	get_next_marker: function(){
		var idx = Map.get_current_idx();
		var next = '';
		
		if (idx == (this.markers.length -1)) {
			next = this.markers[(idx)];
		} else {
			next = this.markers[(idx + 1)];
		}		
		return next;
	},
	
	get_previous_marker: function(){
		var idx = Map.get_current_idx();
		var previous = '';
		
		if (idx > 0) {
			previous = this.markers[(idx -1)];
		} else {
			previous = this.markers[(idx)];
		}
		return previous;
	},
	
	zoom: function() {	
		var idx = Map.get_current_idx();
		//cria o zoom dinamico conforme o local dos pontos
		
		var current = this.markers[idx];
		var next = Map.get_next_marker();
		var previous = Map.get_previous_marker();

		//redefine o bounds se o meu ponto atual nao estiver na area.
		if (this.bounds != '' && this.bounds.contains(current.position) == false) {							
			//cria uma nova area com os pontos anteriores, atual e proximo
			var bounds_ = new google.maps.LatLngBounds();		
			bounds_.extend(previous.position);
			bounds_.extend(current.position);
			bounds_.extend(next.position);

			//redifine a area padrao...
			bounds = bounds_;

			this.gmap.fitBounds(bounds_);
		} else if (this.bounds == '') {
			//define uma area padrao ao iniciar o mapa..
			this.bounds = new google.maps.LatLngBounds();

			this.bounds.extend(previous.position);
			this.bounds.extend(next.position);

			this.gmap.fitBounds(this.bounds);		
		};

		this.gmap.panTo(current.position);
	},
	
	/*
		TODO revisar para ver se esse eh o melhor lugar para essa funcionalidade
	*/
	bind_events: function(){
		// Map.options.map_el.hover(function(){
		// 	Panel_aux.hide();		   		
		// });
	},
	
	//funcao principal... 
	show: function(){
		//this.resize_map();
		
		this.get_placemarks(function(placemarks){
			Map.placemarks = placemarks;
			
			var most_recent_location = {
				lat: placemarks[0]['value']['lat'], 
				long: placemarks[0]['value']['long']
			}
			
			Map.add(most_recent_location.lat, most_recent_location.long);
			
			$.each(placemarks, function(i,placemark) {
				Map.add_marker(placemark['value']);
			});
			
			Nav.enable();
			
			Map.enable_history();
			
			Map.bind_events();
						
		});
	}
	
};
