<?php
require_once("AbstractService.class.php");
require_once("Controller.php");
require_once("Post.class.php");
require_once("lib/posterous-api.php");

class Posterous extends AbstractService {
	public function get_updates($username){
		$controller = new Controller();
		
		$servicename = 'posterous';
		$service = $controller->get_user_service($username, $servicename);
		
		$posterous = new PosterousAPI();
		$xml = $posterous->readposts(array('hostname' => $service->token, 'tag' => 'mentaway'));
		
		$posts = array();
		
		foreach($xml->post as $post_) {
			$post = new Post();
			$post->title = (string) $post_->title;
			$post->body = (string) $post_->body;
			$post->date = (string) $post_->date;
			$post->timestamp = strtotime($post->date);
			$post->link = (string) $post_->link;

			$posts[] = $post;			

		}
		return $posts;		
	}
	
	public function validate($hostname) {
		$posterous = new PosterousAPI();
		
		$args = array('hostname' =>$hostname);
		
		try {
			$posterous->gettags($args);
			$result = true;
		} catch (Exception $e) {
			$result = false;
		}
		
		return $result;
		
	}
	
}

?>
