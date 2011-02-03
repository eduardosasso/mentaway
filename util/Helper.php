<?php 
class Helper {
	public static function cmp_timestamp($a, $b) {
	 if ( $a->value->timestamp < $b->value->timestamp ) return 1;
	    if ( $a->value->timestamp > $b->value->timestamp ) return -1;
	    return 0; // equality
	}
	
	public static function showdate($timestamp) // $date -- time(); value
	{
		$difference = time() - $timestamp;
		$periods = array("sec", "min", "hour", "day", "week",
		"month", "years", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");

		if ($difference > 0) { // this was in the past
		$ending = "ago";
		} else { // this was in the future
		$difference = -$difference;
		$ending = "to go";
		}
		for($j = 0; $difference >= $lengths[$j]; $j++)
		$difference /= $lengths[$j];
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
		$text = "$difference $periods[$j] $ending";
		return $text;
		}

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
	
	/**
	 *  Given a file, i.e. /css/base.css, replaces it with a string containing the
	 *  file's mtime, i.e. /css/base.1221534296.css.
	 *  
	 *  @param $file  The file to be loaded.  Must be an absolute path (i.e.
	 *                starting with slash).
	 */
	public static function auto_version($file) {
	  if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
	    return $file;

	  $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
	  return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
	}
	
	public static function clean_string($string, $length = -1, $separator = '-') {
		// transliterate
		$string = Helper::transliterate($string);

		// lowercase
		$string = strtolower($string);

		// replace non alphanumeric and non underscore charachters by separator
		$string = preg_replace('/[^a-z0-9]/i', $separator, $string);

		// replace multiple occurences of separator by one instance
		$string = preg_replace('/'. preg_quote($separator) .'['. preg_quote($separator) .']*/', $separator, $string);

		// cut off to maximum length
		if ($length > -1 && strlen($string) > $length) {
			$string = substr($string, 0, $length);
		}

		// remove separator from start and end of string
		$string = preg_replace('/'. preg_quote($separator) .'$/', '', $string);
		$string = preg_replace('/^'. preg_quote($separator) .'/', '', $string);

		return $string;
	}
	
	public static function transliterate($string) {
		static $i18n_loaded = false;
		static $translations = array();

		if (!$i18n_loaded) {
			$path = Helper::path('util/i18n-ascii.txt');
			if (is_file($path)) {
				$translations = parse_ini_file($path);
			}
			$i18n_loaded = true;
		}

		return strtr($string, $translations);
	}
	
	public static function path($dir=''){
		if ($dir && Helper::starts_with($dir,'/')) {
			$dir = substr($dir, 1);
		}
		
		$path = '/www/mentaway/';
		if (isset($_ENV['USER']) && $_ENV['USER'] == 'eduardosasso') {
			//teste meio tosco so pra identificar que esta no ambiente de producao
			$path = '/Users/eduardosasso/Dropbox/mentaway/';
		} 
		
		return $path . $dir;		
	}
	
	public static function starts_with($haystack, $needle, $case=false) {
		if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
		return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}
	
	
} 

?>