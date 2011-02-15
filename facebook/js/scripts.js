head.ready(function(){

	$("a.lightbox").fancybox();
	
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
	})

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