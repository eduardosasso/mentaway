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
		if ($steps_finished <= 1 || $_SESSION['invite']) {
			
			switch ($page) {
				case 'profile':
					$html = '<li class="active">Profile</li>
									 <li>Services</li>
									 <li>Trips</li>';
					break;
				case 'services':
					$html = '<li class="finished">Profile</li>
									 <li class="active">Services</li>
									 <li>Trips</li>';
					break;
				case 'trips':
					//como esse eh o ultimo ponto verifico pra ver se ja ta concluido para setar o finished nesse tb
					$class = 'active';					
					if (count($user->trips) > 0) {
						$class = 'finished';
					}
					
					$html = '<li class="finished">Profile</li>
									 <li class="finished">Services</li>
									 <li class="' . $class . '">Trips</li>';
					break;
			}
			
			$result = "<div id='registration_steps'>
									<ul>$html</ul>
								</div>";
			
			return $result;
		}
	}
	
}

?>