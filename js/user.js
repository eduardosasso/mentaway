var User = {
	name: '',
	
	init: function(username){
		this.name = username;
	},
	
	add_trip: function(desc, callback) {
		args = {
			action: 'add',
			username: this.name,
			desc: desc
		}

		url = base_url + '/services/trip.php';

		$.get(url,args, function(data){
			callback(data);
		});
	},
	
	get_trip: function(user,callback) {
		args = {			
			action: 'get',
			username: user,
		}
		
		url = 'services/trip.php';

		$.get(url,args, function(data){
			callback(data);
		});		
	},
	
	add_general_service: function(service){
		args = {
			username: this.name
		}

		url = base_url + '/services/' + service + '.php';

		$.get(url,args, function(url){
			window.location.replace(url);
		});
	},

	add_posterous: function(site, callback) {
		args = {
			username: this.name,
			site: site
		}

		url = base_url + '/services/posterous.php';

		$.get(url,args, function(data){
			callback(data);
		});	
	},

	add_twitter: function(twitter, callback) {
		args = {
			username: this.name,
			twitter_user: twitter
		}

		url = base_url + '/services/twitter.php';

		$.get(url,args, function(data){
			callback(data);
		});
	}

}