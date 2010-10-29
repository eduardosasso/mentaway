var User = {
	name: '',
	
	init: function(username){
		this.name = username;
	},
	
	insert_update: function(args, callback) {
		/*
			TODO validar form
		*/
		
		url = base_url + '/services/profile.php';

		$.post(url, args, function(data){
				callback(data);
		});
		
	},
	
	add_trip: function(args, callback) {
		/*
			TODO antes de fazer o ajax tem q validar o form.
		*/
		params = args + "&action=add&username=" + this.name;
		
		// args = {
		// 	action: 'add',
		// 	username: this.name,
		// 	desc: desc
		// }

		url = base_url + '/services/trip.php';

		$.post(url, params, function(data){
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
	
	remove_service: function(service){
		args = {
			action: 'remove',
			service: service,
			username: this.name
		}
		
		url = '/services/service.php';

		$.post(url, args, function(data){
			//if (data == "ok") {
				window.location.reload(true);
			//}	
		});
		
	},
	
	dummy_save_service: function(callback){
		args = {
			action: 'save',
			username: this.name
		}
		
		url = '/services/service.php';

		$.post(url, args, function(data){
			callback(data);
		});
		
	},

	add_posterous: function(site, callback) {
		args = {
			username: this.name,
			site: site
		}

		url = base_url + '/services/posterous.php';

		$.get(url,args, function(data){
			//callback(data);
			window.location.reload(true);
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
		if ($('h1').length > 0  && trip) {
			$('h1').text(trip.name);

			if (trip.status) {
				$('h4.trip-status').html(trip.status.message);
			}
			
		};		
	});
	
	//controla o menu do usuario
	$('body').bind('click', function(e) {
		if($(e.target).closest('#user_menu_header, #user_menu').length == 0) {
			$('#user_menu_header').removeClass('active');
			$('#user_menu').hide();			
			e.stopPropagation();
		}
	});
	
	$('#user_menu_header').click(function(e){
		$(this).toggleClass('active');
		$('#user_menu').toggle();
		e.stopPropagation();
		return false;
	});
	
});