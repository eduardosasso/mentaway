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

} 

?>