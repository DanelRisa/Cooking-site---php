<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$postId = $_POST['post_id'] ?? '';

		if($postId){
			require_once 'common/connect.php';

			$result = deletePost($postId);
			header("Location: index.php");

		}
	}

?>