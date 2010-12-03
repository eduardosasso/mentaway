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
		messages_el = $('#messages');
		page = $('body').attr('id');
		
		if (messages_el.length == 0) {
			div_messages = $('<div/>').attr('id','messages').addClass(type).html(message);
			
			if (page == 'app') {
				$('#map').before(div_messages);
			} else if (page == 'user') {
				$('.content').prepend(div_messages);
			};
			
		} else {
			messages_el.removeClass().addClass(type).html(message).show();
		}
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
	
	linkify: function(text) {
		text = text.replace(/(https?:\/\/\S+)/gi, function (s) {
			return '<a href="' + s + '">' + s + '</a>';
		});

		text = text.replace(/(^|)@(\w+)/gi, function (s) {
			return '<a href="http://twitter.com/' + s + '">' + s + '</a>';
		});

		text = text.replace(/(^|)#(\w+)/gi, function (s) {
			return '<a href="http://search.twitter.com/search?q=' + s.replace(/#/,'%23') + '">' + s + '</a>';
		});
		return text;
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
		// 		$('meta[property=og:description]').attr('content',placemark.description);
		// 		$('meta[property=og:url]').attr('content',Util.get_pretty_url());
		// 		$('meta[property=og:image]').attr('content',placemark.image);
	},
	
	update_like_button: function(){
		var url = Util.get_pretty_url();
		
		//var like = '<fb:like width="360" show_faces="false" url="' + url + '"></fb:like>';		
		
		var like = '<iframe src="http://www.facebook.com/plugins/like.php?href=' +  url + '&layout=button_count" scrolling="no" frameborder="0" style="height: 21px; width: 360px" allowTransparency="true"></iframe>';
				
		this.fblike.html(like);
		
		// if (typeof(FB) != "undefined") {
		// 			FB.XFBML.parse();		
		// 		};
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