var Diary = {
	user: '',
	has_data: false,
	link_el: $('#diary'),
		
	init: function(user) {
		this.user = user;
		
		this.link_el.click(function(){
			Panel_aux.show();
		});
		
		//quando inicializa ve se tem posts para mostrar ou nao o link do diario na tela...
		Diary.get_(null,null,function(posts){
			if (posts) {
				Diary.has_data = true;
				Diary.link_el.show();
				
				var title = posts[0]['title'];
				var body = posts[0]['body'];
				
				Panel_aux.set_title(title);
				Panel_aux.set_description(body);
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
		Diary.get_(begin_date, end_date, function(posts){
			var title = posts[0]['title'];
			var body = posts[0]['body'];
			
			Panel_aux.set_title(title);
			Panel_aux.set_description(body);			
		});	
	}
	
}