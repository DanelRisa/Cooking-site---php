<?php

	session_start();
	require_once 'common/check_login.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$title = $_POST['title'] ?? '';
		$content = $_POST['content'] ?? '';
		$category_id = $_POST['category_id'] ?? '';

		require_once 'common/connect.php';

		$result = createPost($title, $content, $category_id, $user['id']);

		if($result)
			header("Location: index.php");
	}

?>