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
	
	get_trip: function(username,callback) {
		args = {			
			action: 'get',
			username: username,
		}
		
		url = base_url + '/services/trip.php';

		$.get(url,args, function(data){
			callback(data);
		});		
	},
	
	get_current_status: function(){
		args = {			
			action: 'status',
			username: user,
		}
		
		url = base_url + '/services/trip.php';

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
			/*
				TODO aqui tem q testar o retorno para ver se eh url, se nao for eh msg de erro, ou essa validacao tem q vir de cima...
			*/
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
			username: this.name
		}

		url = base_url + '/services/twitter.php';

		$.get(url,args, function(data){
			callback(data);
		});
	}

}

$(document).ready(function() {
	var username = $('#username').val();
	User.init(username);
	
	User.get_trip(username,function(trip){
		$('h1').text(trip.name);
		$('h4.trip-status').html(trip.status.message);
	});
	
	$('.add_user_service').click(function(){
		//usa pela class para ser generico e pegar todos os servicos...			
		service = $(this).attr('id');
		
		User.add_general_service(service);
	});

	$('#add_posterous').click(function(){
		site = $('#posterous_url').val();

		User.add_posterous(site, function(data){
			$('#posterous_block').html(data);
		});
	});

	// $('#twitter.add').click(function(){
	// 		User.add_twitter(twitter, function(data){
	// 			$('#twitter_block').html(data);
	// 		});
	// 	});
	
	$('#add_trip').click(function(){
		trip_desc = $('#trip_desc').val();
		
		User.add_trip(trip_desc, function(data){
			$('#trip_block').html(data);
		});
	});
	
	// $('#new_user_account').click(function(){
	// 	User.save_user();
	// });
	
});