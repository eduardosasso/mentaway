head.ready(function(){

	$("section#timeline article a.twitter").click(function(e){
		href_ = $(this).attr('href');
		
		$.embedly(href_, {}, function(oembed, dict){
			jQuery.facebox({ image: oembed.url });
		});
		
		e.stopPropagation();		
		return false;
	});
	
	$("section#timeline article a.flickr, section#timeline article a.foursquare").facebox();
	
	// $("a.lightbox").fancybox({
	// 	'scrolling'		: 'no',
	// 	'autoScale'			:	'true',
	// 	'autoDimensions'		:	'true',
	// 	'centerOnScroll'		:	'false',	 	
	// 	'type': 'iframe',
	//  	'width': '612',
	// 	'height': '612',
	// });
	
	// $("a.lightbox").facebox(function(){
	// 	$.embedly($(this).attr('href'), {}, function(oembed, dict){
	// 		jQuery.facebox({ image: oembed.url });
	// 	});
	// });
	
	FB.init({
    appId  : '136687686378472',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });
	
	$(".redirect").click(function(e){
		href_ = $(this).attr('href');
		
		if (!href_) href_ = $(this).attr('data-url');

		e.stopPropagation();

		top.location.href = "http://apps.facebook.com/mentaway" + href_;
		return false;
	});	
	
	$(".external").click(function(e){
		href_ = $(this).attr('href');
		
		if (!href_) href_ = $(this).attr('data-url');

		e.stopPropagation();

		top.location.href = href_;
		return false;
	});
	
	$('#messages .close').click(function(e){
		e.stopPropagation();
		
		message_ = $(this).closest('.message');

		//remove do db a mensagem se for persistente
		$.post('/facebook/ajax/delete.php', {docid: message_.attr('id')});
		
		message_.remove();		
		
		return false;
		
	});	
	
	$('#invite_friends').find('input').click(function(){
		FB.ui({
			method: 'apprequests',
			message: 'If you love traveling you should definitely check out this app.' ,
			filters: '["app_non_users"]'
		});
	});

	$('.stats .friends a').click(function(e){
		e.stopPropagation();
		$('#friends_link').trigger('click');
		return false;
	});
	
	$('section#help article h1').click(function(e){
		e.stopPropagation();
		
		$(this).next('div').toggle();
		
		FB.Canvas.setAutoResize(); 

		return false;
	})
	
	Geo.update_placemarks();

});

get_db_view = function(dd, vn, k, callback) {
	var this_ = this;
	
	args_ = {
		design_document: dd, 
		view_name: vn,
		key: k
	}

	$.get('/facebook/ajax/views.php', args_, function(data){
		callback.call(this_, data);
	});	
}	


