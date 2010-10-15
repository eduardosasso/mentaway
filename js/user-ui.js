$(document).ready(function() {
	var username = $('#username').val();
	User.init(username);
	
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

	$('#add_twitter').click(function(){
		twitter = $('#twitter_user').val();

		User.add_twitter(twitter, function(data){
			$('#twitter_block').html(data);
		});
	});
	
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