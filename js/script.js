var base_url='';

$(document).ready(function() {	
	Map.init({user: user, maptype: maptype});

	Diary.init(user);
	
	Panel.get_el().delegate("a.lightbox", "click", function(){
		$("a.lightbox").fancybox().trigger('click');
		return false;
	});
	
});
