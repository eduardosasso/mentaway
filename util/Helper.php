<?php 
class Helper {

	public static function nicetime($date) {
		if(empty($date)) {
			return "No date provided";
		}

		$periods   = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths   = array("60","60","24","7","4.35","12","10");

		$now       = time();
		$unix_date = strtotime($date);

		// check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference   = $now - $unix_date;
			//$tense      = "ago";
			$tense        = "";

		} else {
			$difference   = $unix_date - $now;
			$tense        = "from now";
		}

		for($j         = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference    = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] {$tense}";
	}

	public static function startsWith($haystack,$needle,$case=true) {
		if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
		return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}
	
	public static function linkify($ret) {
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\">\\2</a>", $ret);
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\">\\2</a>", $ret);
		$ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
		$ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\">#\\1</a>", $ret);

		return $ret;
	}
	
	public static function escape_special_char($id) {
		//underscore é reservado para id, se vier simula um scape para gravar...
		if (Helper::startsWith($id, '_')) {
			return '/' . $id;
		} else {
			return $id;
		}
	}
	
	public static function unescape_special_char($id) {
		return str_replace('/_' , '_', $id);
	}

} 

?>