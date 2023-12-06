<?php

	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: auth/Loginform.php');
		exit();
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$id = $_POST['id'] ?? '';
		$title = $_POST['title'] ?? '';
		$content = $_POST['content'] ?? '';
		$category_id = $_POST['category_id'] ?? '';

		require_once 'common/connect.php';

		$result = editPost($id, $title, $content, $category_id);

		if($result)
			header("Location: index.php");
	}

?>