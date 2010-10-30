$(document).ready(function() {
	$('a#twitter-register').click(function(){
		var code = $('#code').val();
		var twitter = $(this).attr('href');

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
					Util.message('Invalid invitation code.','error');
					
					$('#code').select();
				} 
			});
			
			return false;
			
	});
	
});
