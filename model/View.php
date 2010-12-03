<?php 

class View {
	public static function show_username_and_menu($user) {
		$id = $_SESSION['id'];
		
		$username_and_or_menu =  "<h3>" . $user->fullname . "</h3>";
		
		$username  = $user->username; 
		
		//se tiver sessao, e o id da sessao for igual o username é pq ta conectado
		if (!empty($id) && $username == $id) {
			$username_and_or_menu = "<h3><a href='#' id='user_menu_header'>" . $user->fullname . "</a></h3>
				<div id='user_menu'>
				<ul>
					<li><a href='/user/profile/$username'>Profile</a></li>
					<li><a href='/user/services/$username'>Services</a></li>
					<li><a href='/user/trips/$username'>Trips</a></li>
					<li><a href='/user/signout/$username'>Sign out</a></li>
				</ul>
				</div>";
		}
		return $username_and_or_menu;
	}
	
	public static function show_facebook_metatags($placemark, $user) {
		// <meta property='og:url' content='http://beta.mentaway.com/eduardosasso/318'/>
		$title = $placemark->value->name;
		$description = $placemark->value->description;
		$lat = $placemark->value->lat;
		$long = $placemark->value->long;
		
		$fullname = $user->fullname;
		$username = $user->username;
		
		$service = $placemark->value->service;
		
		if ($service == 'flickr') {
			$img = $placemark->value->image;
		} else {
			$img = "http://foursquare.com/mapproxy/$lat/$long/map.png";
		}
		
		$name = "$fullname&#039;s Mentaway";
		
		$metatags = "
			<meta property='fb:app_id' content='136687686378472'/> 
			<meta property='og:title' content='$title'/>
			<meta property='og:image' content='$img'/>
			<meta property='og:latitude' content='$lat'/>
			<meta property='og:longitude' content='$long'/>			
			<meta property='og:site_name' content='$name'/>
			<meta property='og:description' content='$description'/>
			<meta property='og:type' content='activity' /> 
			";
			
		return $metatags;
	}
	
	public static function show_steps_registration($user, $page) {
		$steps_finished = count($user->services) + count($user->trips);
		
		//se o user tem o session invite eh pq ta comecando agora, se ta nos steps_finished eh pq fechou o browser e voltou novamente
		//if ($steps_finished <= 1 || $_SESSION['invite']) {
			
			$username = $user->username;
			
			$profile = "<a href='/user/profile/$username'>Profile</a>";
			$services = "<a href='/user/services/$username'>Services</a>";
			$trips = "<a href='/user/trips/$username'>Trips</a>";
			
			if (count($user->services) > 0) {
				$class_services = 'finished';
			}
			
			if ($user->email && $user->fullname) {
				$class_profile = 'finished';
			}
			
			if (count($user->trips) > 0) {
				$class_trips = 'finished';
			}
			
			
			switch ($page) {
				case 'profile':
					$html = "<li class='active'>Profile</li>
									 <li class='$class_services'>$services</li>
									 <li class='$class_trips'>$trips</li>";
					break;
				case 'services':
					$html = "<li class='$class_profile'>$profile</li>
									 <li class='active'>Services</li>
									 <li class='$class_trips'>$trips</li>";
					break;
				case 'trips':
					//como esse eh o ultimo ponto verifico pra ver se ja ta concluido para setar o finished nesse tb
					$class_trips = 'active';
					
					$html = "<li class='$class_profile'>$profile</li>
									 <li class='$class_services'>$services</li>
									 <li class='$class_trips'>Trips</li>";
					break;
			}
			
			$result = "<div id='registration_steps'>
									<ul>$html</ul>
								</div>";
			
			return $result;
	}
	
}

?>