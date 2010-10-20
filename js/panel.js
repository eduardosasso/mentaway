var Panel_aux = {
	el: {		
		panel: $("#panel2"),		
		title: $('h2', '#panel2'),
		close: $('#close', '#panel2'),
		date: $('.dates', '#panel2'),
		description: $('.desc', '#panel2'),
		service: $('#via span a', '#panel2')
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
	
	set_service: function(service){
		this.el.service.text(service);
	},
	
	show: function(){
		this.el.panel.show();
	},
	
	hide: function(){
		this.el.panel.hide();
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
		service: $('#via span a', '#panel1'),
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
			
			img = $('<a>').attr('href', img_big).attr('class', 'flickr').attr('class','lightbox').append(img);
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
	}

}

//tratamento de eventos...
Panel_aux.el.close.click(function(){
	Panel_aux.hide();
});


