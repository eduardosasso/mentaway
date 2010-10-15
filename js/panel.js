var Panel_aux = {
	el: {		
		panel: $("#panel2"),		
		title: $('h2', '#panel2'),
		date: $('.dates', '#panel2'),
		description: $('.desc', '#panel2'),
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
	
	show: function(){
		// var speed = 800;
		// 
		// 	if($(window).width()<1024){
		// 		Panel.get_el().css("right", "400px");
		// 		this.el.panel.width(340);
		// 		this.el.panel.css("right", "0");
		// 	}
		// 	
		// 	if($(window).width()>1024){
		// 		w = 1100 - $(window).width() +"px";
		// 		Map.get_map_el().animate({left: "-540px"}, speed );
		// 		Panel.get_el().animate({right: "540px"}, speed );
		// 		this.el.panel.animate({right: "0"}, speed);
		// 	}
	},
	
	hide: function(){
		// var speed = 800;
		// 
		// w = $(window).width() - 570 +"px";
		// Map.get_map_el().animate({left: 0}, speed );		
		// Panel.get_el().animate({right: "0"}, speed );
		// this.el.panel.animate({right: "-540px"}, speed );
	}
	
}

var Panel = {
	previous_service: '',
	comments: $("#panel3"),	
		
	el: {
		container: $("#content"),		
		panel: $("#panel1"),		
		title: $('h2', '#panel1'),
		date: $('.dates', '#panel1'),
		description: $('.desc p', '#panel1'),
		service: $('#via span a'),
		service_icon: $('#via div.icon')
	},
	
	get_el: function(){
		return this.el.panel;
	},
	
	set_title: function(title){
		this.el.title.text(title);
	},

	set_date: function(timestamp){
		var date = Util.format_date(timestamp);
		this.el.date.text(date);
	},

	set_description: function(desc){
		//var comments = Util.add_comments();
		//this.el.description.html(desc + comments);
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
	
	/*
		TODO revisar eventos..
	*/
	bind_events: function(){
		$('a.flickr').live('click',function(){
			class_ = $(this).attr('class');
			src_ = $(this).attr('href');

			var img = $("<img border='0' />").
				attr('src',src_).
				attr('class', class_);

			Panel_aux.set_title('');
			Panel_aux.set_date('');
			Panel_aux.set_description(img);

			Panel_aux.show();

			return false;			

		});		
	},
	
	html: function(placemark){
		this.update(placemark);
		return this.el.panel.html();
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