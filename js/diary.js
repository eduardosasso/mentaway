var Diary = {
	user: '',
	has_data: true,
	link_el: $('#diary a'),
		
	init: function(user) {
		this.user = user;
		
		this.link_el.click(function(){
			if (Diary.has_data) {
				Panel_aux.show();
			};
			
			return false;
		});
		
		// //quando inicializa ve se tem posts para mostrar ou nao o link do diario na tela...
				Diary.get_(null,null,function(posts){
					if (posts) {
						Diary.has_data = true;
						Diary.link_el.show();
						
						// var title = posts[0]['title'];
						// var body = posts[0]['body'];
						// var date = posts[0]['timestamp'];
						// var service = posts[0]['service'];
						// 
						// Panel_aux.set_title(title);
						// Panel_aux.set_date(date);
						// Panel_aux.set_description(body);
						// Panel_aux.set_service(service);
						
					} else {
						Diary.link_el.hide();
					}
				});		
	},
	
	has_posts: function(){
		return this.has_data;
	},
	
	get_: function(begin_date, end_date, callback){
		args = {
			a: "posts", 
			uid: user,
			begin: begin_date,
			end: end_date
		}
		
		$.getJSON(base_url + 'ajax.php', args, function(data) {		
			callback(data);
		})
	},
	
	get_posts: function(begin_date, end_date) {
		if (Diary.has_data == false) {
			return;
		}
		
		Diary.get_(begin_date, end_date, function(posts){
			if (posts) {
				Diary.has_data = true;
			
				var title = posts[0]['title'];
				var body = posts[0]['body'];
				var date = posts[0]['timestamp'];
				var service = posts[0]['service'];

				Panel_aux.set_title(title);
				Panel_aux.set_date(date);
				Panel_aux.set_description(body);
				Panel_aux.set_service(service);			
			} else {
				Diary.link_el.addClass('disabled-feature');
				Diary.has_data = false;
			}
		});	
	}
	
}