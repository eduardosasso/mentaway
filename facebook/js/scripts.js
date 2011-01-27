$(function(){
	$("a.top-location").click(function(e){
		href_ = $(this).attr('href');

		e.stopPropagation();

		top.location.href = href_;
		return false;

	});	
});

