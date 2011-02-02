$(function(){
	$("a.top-location").click(function(e){
		href_ = $(this).attr('href');

		e.stopPropagation();

		top.location.href = href_;
		return false;

	});	
	
	FB.init({
    appId  : '136687686378472',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });

});

get_db_view = function(dd, vn, k, callback) {
	var this_ = this;
	
	args_ = {
		design_document: dd, 
		view_name: vn,
		key: k
	}

	$.get('/facebook/couchjs.php', args_, function(data){
		callback.call(this_, data);
	});
	
}	