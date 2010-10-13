var Panel = {
	previous_service: '',
	
	aux: {		
		panel: $("#panel2"),		
		title: $('h2', '#panel2'),
		date: $('.dates', '#panel2'),
		description: $('.desc', '#panel2'),
	},
		
	el: {
		container: $("#content"),		
		panel: $("#panel1"),		
		title: $('h2', '#panel1'),
		date: $('.dates', '#panel1'),
		description: $('.desc p', '#panel1'),
		service: $('#via span a'),
		service_icon: $('#via div.icon')
	},
	
	set_title: function(title){
		this.el.title.text(title);
	},

	set_date: function(timestamp){
		var date = Util.format_date(timestamp);
		this.el.date.text(date);
	},

	set_description: function(desc){
		this.el.description.html(desc);
	},
	
	//define a origem, flickr, foursquare etc... e seta classes para customizacao
	set_service: function(service){	
		if (this.previous_service != '') {
			this.el.service.removeClass(this.previous_service);
			this.el.service_icon.removeClass(this.previous_service);
		} 
		
		this.el.service.addClass(service);
		this.el.service_icon.addClass(service);
		
		this.el.service.text(service);
		
		this.el.panel.attr('class', service);
		
		this.previous_service = service;
	},
	
	bind_events: function(){
		$('a.flickr').live('click',function(){
			class_ = $(this).attr('class');
			src_ = $(this).attr('href');

			var img = $("<img border='0' />").
				attr('src',src_).
				attr('class', class_);

			Panel.aux.title.text('');
			Panel.aux.date.text('');
			Panel.aux.description.html(img);

			Panel.show_aux_panel();

			return false;			

		});		
	},
	
	show_aux_panel: function(){
		speed = 800;

		if($(window).width()<1024){
			this.el.panel.css("right", "400px");
			this.aux.panel.width(340);
			this.aux.panel.css("right", "0");
		}
		
		if($(window).width()>1024){
			w = 1100 - $(window).width() +"px";
			Map.get_map_el().animate({left: "-540px"}, speed );
			this.el.panel.animate({right: "540px"}, speed );
			this.aux.panel.animate({right: "0"}, speed);
		}
	},
	
	goto_original_position: function(){
		this.el.panel.animate({right: "0"}, speed );
		this.aux.panel.animate({right: "-540px"}, speed );
	},
			
	update: function(placemark){		
		//define a tag title da pagina
		$('title').text(placemark.user + ': ' + placemark.name);
		
		var description = placemark.description;
		
		if (description == null) description = '';

		var img = placemark.image;

		if (img) {
			img = $('<img border="0" />').
				attr('src', placemark.image).
				attr('class', placemark.service);
		}
		
		if (placemark.service == 'flickr') {
			img_big = img.attr('src');

			//doc: http://www.flickr.com/services/api/misc.urls.html			
			img_big = img_big.replace('_t.','_b.');
			
			img = $('<a>').attr('href', img_big).attr('class', 'flickr').append(img);
		};
		
		if (img) {
			//coloca a img em um dummy so pra pegar o html completo...
			img = $('<div>').append(img).html();
			
			description = img + description;
		}	
		
		this.set_title(placemark.name);
		this.set_date(placemark.timestamp);
		this.set_description(description);
		this.set_service(placemark.service);
		
		Panel.bind_events();
				
	}

}