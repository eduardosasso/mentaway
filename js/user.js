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
		if (trip) {
			$('h1').text(trip.name);

			if (trip.status) {
				$('h4.trip-status').html(trip.status.message);
			}
			
		};		
	});
	
	$('a.add_user_service').click(function(){
		//usa pela class para ser generico e pegar todos os servicos...			
		service = $(this).attr('id');
		
		User.add_general_service(service);
	});
	
	$('a.remove_user_service').click(function(){
		service = $(this).attr('id');
		
		User.remove_service(service);
		
		return false;
	});
	
	$('a#posterous.add').click(function(){
		$('#posterous_block').removeClass('hidden').show();
		$('#posterous_url').focus();
	})
	
	$('#add_posterous').click(function(){
		site = $('#posterous_url').val();

		User.add_posterous(site);
	});

	// $('#twitter.add').click(function(){
	// 		User.add_twitter(twitter, function(data){
	// 			$('#twitter_block').html(data);
	// 		});
	// 	});
	
	$('#submit_profile').click(function(){
		args = $('#profile_block form').serialize();
		
		User.insert_update(args, function(data){
			if (Util.is_url(data)) {
				Util.redirect(data);
			} else {
				/*
					TODO Definir aqui um esquema para setar mensagens Message::set
				*/
				$('#profile_block').html(data);
			}
			
		});
		
		return false;
	});
	
	$('#submit_service').click(function(){
		//o service na realidade ja ta salvo entao so chama o ajax para retornar uma mensagem ou redirecionar para outra etapa nao concluida
		User.dummy_save_service(function(data){
			if (Util.is_url(data)) {
				Util.redirect(data);
			} else {
				/*
					TODO Definir aqui um esquema para setar mensagens Message::set
				*/
				$('#services_block').html(data);
			}			
		});
	});
	
	$('#submit_trip').click(function(){
		args = $('#trip_block form').serialize();
		
		User.add_trip(args, function(data){
			if (Util.is_url(data)) {
				Util.redirect(data);
			} else {
				//se chegou aqui eh pq a principio nao deu erro entao setar a Trip no Li se for user novo para finished
				$('#registration_steps ul li:last').removeClass('active').addClass('finished');
				/*
					TODO Definir aqui um esquema para setar mensagens Message::set
				*/
				$('#trip_block').html(data);
			}
			
		});
		
		return false;
	});
	
	// $('#new_user_account').click(function(){
	// 	User.save_user();
	// });
	
});