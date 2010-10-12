var Map = {

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
		
		return new google.maps.Map(this.options.map_el.get(0), map_options);
	},
	
	resize_map: function() {
		/*
			TODO altura deve calcular em porcento
		*/
		this.options.container_el.height($(window).height() - 130)
		this.options.map_el.height($(window).height() - 180);
		this.options.map_el.width($(window).width() - 570);
	},
	
	add_marker: function(placemark, map){
		var date = Util.format_date(placemark.timestamp);

		var img = placemark.image;

		if (img) {
			img = $('<img border="0" />').
				attr('src', placemark.image).
				attr('class', placemark.service);
		};

		if (placemark.service == 'flickr') {
			img_big = img.attr('src');

			//doc: http://www.flickr.com/services/api/misc.urls.html			
			img_big = img_big.replace('_t.','_b.');
			
			img = $('<a></a>').attr('href',img_big).attr('class', 'flickr').html(img);
		};

		var latlng = new google.maps.LatLng(
			parseFloat(placemark.lat),
			parseFloat(placemark.long)
		);

		var marker = new google.maps.Marker({
			map: map,
			position: latlng
		});

	},
	
	show: function(){
		this.resize_map();
		
		this.get_placemarks(function(placemarks){
			var most_recent_location = {
				lat: placemarks[0]['value']['lat'], 
				long: placemarks[0]['value']['long']
			}
			var map = Map.add(most_recent_location.lat, most_recent_location.long);
			
			$.each(placemarks, function(i,placemark) {
				Map.add_marker(placemark['value'], map);
			});
						
		});
	}
	
};
