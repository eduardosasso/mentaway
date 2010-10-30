<?php 

class View {
	public static function show_username_and_menu($user) {
		$id = $_SESSION['id'];
		
		$username_and_or_menu =  "<h3>" . $user->fullname . "</h3>"; 
		
		if (!empty($id)) {
			$username_and_or_menu =  "<h3><a href='#' id='user_menu_header'>" . $user->fullname . "</a></h3>
				<div id='user_menu'>
				<ul>
					<li><a href='/user/profile'>Profile</a></li>
					<li><a href='/user/services'>Services</a></li>
					<li><a href='/user/trips'>Trips</a></li>
					<li><a href='/user/signout'>Sign out</a></li>
				</ul>
				</div>";
		}
		return $username_and_or_menu;
	}
	
	public static function show_steps_registration($user, $page) {
		$steps_finished = count($user->services) + count($user->trips);
		
		//se o user tem o session invite eh pq ta comecando agora, se ta nos steps_finished eh pq fechou o browser e voltou novamente
		//if ($steps_finished <= 1 || $_SESSION['invite']) {
			
			$profile = "<a href='/user/profile'>Profile</a>";
			$services = "<a href='/user/services'>Services</a>";
			$trips = "<a href='/user/trips'>Trips</a>";
			
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