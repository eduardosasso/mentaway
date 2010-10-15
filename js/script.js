var base_url='';

$(document).ready(function() {	
	User.get_trip(user,function(trip){
		$('h1').text(trip);
	});

	Map.init({user: user});

	Diary.init(user);
});
