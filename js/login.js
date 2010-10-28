$(document).ready(function() {
	$('a#twitter-login').click(function(){
		var code = $('#code').val();
		var twitter = $(this).attr('href');
		
		if (code) {
			//se colocou codigo eh pq eh usuario novo
			args = {
				a: 'invite',
				code: code
			}
			
			url = '/ajax.php';

			$.post(url, args, function(data){
				if (jQuery.trim(data) == "true") {
					window.location.replace(twitter);
				} else {
					alert('It seems that your invitation code is invalid. :(');
				} 
			});
			
			return false;
			
		} 
		
	});
	
});
