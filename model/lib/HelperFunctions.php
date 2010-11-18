	<?php 
	function search_object_array($needle_key, $needle_val, $haystack)
	{
		// iterate through our haystack
		for ( $i = 0; $i < count($haystack); $i++ )
		{
			// ensure this array element is an object and has a key that matches our needle's key
			if ( is_object($haystack[$i]) and property_exists($haystack[$i], $needle_key) )
			{
				// determine if comparison is case sensitive
				if ( strtolower($needle_val) == strtolower($haystack[$i]->$needle_key) ) return $i;
			}
		}
		// no match found
		return false;
	}
	
	function array_remove_empty($arr){
		$narr = array();
		while(list($key, $val) = each($arr)){
			if (is_array($val)){
				$val = array_remove_empty($val);
				// does the result array contain anything?
				if (count($val)!=0){
					// yes :-)
					$narr[$key] = $val;
				}
			}
			else {
				if (!is_object($val) && trim($val) != ""){
					$narr[$key] = $val;
				}
			}
		}
		unset($arr);
		return $narr;
	}

	function nicetime($date)
	{
		if(empty($date)) {
			return "No date provided";
		}

		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");

		$now             = time();
		$unix_date         = strtotime($date);

		// check validity of date
		if(empty($unix_date)) {    
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {    
			$difference     = $now - $unix_date;
			//$tense         = "ago";
			$tense         = "";

		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] {$tense}";
	}

	?>