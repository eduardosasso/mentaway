String.prototype.startsWith = function(str){
    return (this.indexOf(str) === 0);
}

var Util = {
	fblike: $('#fb-like'),
	tweet: $('#tweet'),
	
	format_date: function(date) {
		var dt = new Date(date*1000);
		return dt.toLocaleString();
	},
	
	redirect: function(url){
		window.location.replace(jQuery.trim(url));
	},
	
	message: function(message, type) {
		$('#messages').removeClass().addClass(type).html(message).show();
	},
	
	is_url: function(arg){
		arg = jQuery.trim(arg);
		return arg.startsWith('/');
	},
	
	get_pretty_url: function(){
		var url = location.href;
		url = url.replace('#','/');
		return url;
	},
	
	add_comments: function(){
		var url = Util.get_pretty_url();
		return '<fb:comments width="360" xid="'+ Map.get_current_idx() +'" simple="1" url="'+ url + '"></fb:comments>';
	},	
	
	update_share_buttons: function() {
		Util.update_like_button();
		//Util.update_tweet_button();
	},
	
	update_metatags: function(placemark) {
		// $('meta[property=og:title]').attr('content',placemark.name);
		// $('meta[property=og:description]').attr('content',placemark.description);
		// $('meta[property=og:url]').attr('content',Util.get_pretty_url());
		// $('meta[property=og:image]').attr('content',placemark.image);
	},
	
	update_like_button: function(){
		var url = Util.get_pretty_url();
		
		var like = '<fb:like width="360" show_faces="false" url="' + url + '"></fb:like>';
				
		this.fblike.html(like);
		
		if (typeof(FB) != "undefined") {
			FB.XFBML.parse();		
		};
	},
	
	update_tweet_button: function(){
		var url = Util.get_pretty_url();
		
		var js = '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		
		var tweet_link = $('<a></a>').
			attr('href','http://twitter.com/share').
			addClass('twitter-share-button').
			attr('data-url',url).
			attr('data-count','none').
			attr('data-text', $('title').text());
		
		tweet_link = $('<div>').append(tweet_link).html();
			
		this.tweet.html(tweet_link + js);	
	}
	
}	