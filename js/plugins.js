window.fbAsyncInit = function() {
	FB.init({appId: '136687686378472', status: true, cookie: true, xfbml: true});
};

add_facebook = function(){
	var e = document.createElement('script');
	e.type = 'text/javascript';
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);
}();

// remap jQuery to $
(function($){
	$.getScript("js/jquery.history.js");
	$.getScript("js/fancybox/jquery.fancybox-1.3.1.pack.js"); 
	
	/*
		TODO estudar para carregar o map async
	*/
	//$.getScript("http://maps.google.com/maps/api/js?sensor=false&callback=initialize");
})(window.jQuery);


// usage: log('inside coolFunc',this,arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};

// catch all document.write() calls
(function(doc){
  var write = doc.write;
  doc.write = function(q){ 
    log('document.write(): ',arguments); 
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);  
  };
})(document);


