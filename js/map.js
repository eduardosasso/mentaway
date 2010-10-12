var Map = {
	placemarks: {},
	markers: [],
	gmap: null,
	bounds: '',
	
	options: {
		container_el: $("#content"),
		map_el: $("#map"),
		user: ''
	},
	
	init: function(options) {			
		this.options = $.extend(this.options,options);
		this.show();
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
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: true
		}
		
		this.gmap = new google.maps.Map(this.options.map_el.get(0), map_options);
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
		
		google.maps.event.addListener(marker, 'click', function(e) {
			var idx = (marker.__gm_id -1);
			
			var placemark = Map.placemarks[idx].value;
			
			Panel.update(placemark);
			
			Map.zoom(idx);			
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
	
	zoom: function(idx) {	
		//cria o zoom dinamico conforme o local dos pontos
		current = this.markers[idx];

		//redefine o bounds se o meu ponto atual nao estiver na area.
		if (this.bounds != '' && this.bounds.contains(current.position) == false) {				
			if (idx == (this.markers.length -1)) {
				next = this.markers[(idx)];
			} else {
				next = this.markers[(idx + 1)];
			}
			previous = this.markers[(idx -1)];

			//cria uma nova area com os pontos anteriores, atual e proximo
			var bounds_ = new google.maps.LatLngBounds();		
			bounds_.extend(previous.position);
			bounds_.extend(current.position);
			bounds_.extend(next.position);

			//map.panToBounds(bounds);

			//redifine a area padrao...
			bounds = bounds_;

			map.fitBounds(bounds_);
		} else if (this.bounds == '') {
			//define uma area padrao ao iniciar o mapa..
			this.bounds = new google.maps.LatLngBounds();

			prev = this.markers[(idx -1)];
			next = this.markers[(idx)];	

			this.bounds.extend(prev.position);
			this.bounds.extend(next.position);

			this.gmap.fitBounds(this.bounds);		
		};

		this.gmap.panTo(current.position);
	},
	
	show: function(){
		this.resize_map();
		
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
			
			Map.enable_history();
						
		});
	}
	
};
