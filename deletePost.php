<?php

	$id = $_POST['id'] ?? '';

	require_once 'common/connect.php';

	if($id)
		deletePost($id);

	header("Location: index.php");

?>