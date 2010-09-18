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
?>