<?php

    session_start();
    require_once 'common/check_login.php';
    require_once 'common/connect.php';

	$rating = $_POST['rating'] ?? '';
	$post_id = $_POST['post_id'] ?? '';
	$user_id = $user['id'];

	$result = ratePost($user_id, $post_id, $rating);

	if($result){
		header("Location: onePost.php?post_id=$post_id");
	}
	

?>