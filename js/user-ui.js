$(document).ready(function() {
	$("#begin_trip_date, #end_trip_date" ).datepicker();
	
	$('a.add_user_service').click(function(){
		//usa pela class para ser generico e pegar todos os servicos...			
		service = $(this).attr('id');

		$(this).attr('class','remove_user_service remove');
		
		User.add_general_service(service);
	});
	
	$('a.remove_user_service').click(function(){
		service = $(this).attr('id');
		
		$(this).attr('class','add_user_service add');
		
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
	
	$("#profile_block form").validate({
		submitHandler: function(form) {
			args = $('#profile_block form').serialize();

			User.insert_update(args, function(data){
				if (Util.is_url(data)) {
					Util.redirect(data);
				} else {
					Util.message(data);
					//$('#profile_block').html(data);
				}

			});
		}
	});
	
	$('#submit_service').click(function(){
		//o service na realidade ja ta salvo entao so chama o ajax para retornar uma mensagem ou redirecionar para outra etapa nao concluida
		User.dummy_save_service(function(data){
			if (Util.is_url(data)) {
				Util.redirect(data);
			} else {
				Util.message(data);
				//$('#services_block').html(data);
			}			
		});
	});
	
	
	$("#trip_block form").validate({
		submitHandler: function(form) {
			args = $('#trip_block form').serialize();

			User.add_trip(args, function(data){
				if (Util.is_url(data)) {
					Util.redirect(data);
				} else {
					//se chegou aqui eh pq a principio nao deu erro entao setar a Trip no Li se for user novo para finished
					$('#registration_steps ul li:last').removeClass('active').addClass('finished');
					Util.message(data);

					//$('#trip_block').html(data);
				}

			});	
		}
	});
	
});