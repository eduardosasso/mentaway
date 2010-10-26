<?php 

class View {
	public static function show_username_and_menu($user) {
		$id = $_SESSION['id'];
		
		$username_and_or_menu =  "<h3>" . $user->fullname . "</h3>"; 
		
		if (!empty($id)) {
			$username_and_or_menu .= 	
"				<div id='user_menu'>
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
	
}

?>