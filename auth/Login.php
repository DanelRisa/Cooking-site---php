<?php

	session_start();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';

		$errors = [];

		if(empty($email)){
			$errors['email'] = 'Email is empty';
		}
		else{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  				$errors['email'] = "Invalid email format";
		}

		if(empty($password)){
			$errors['password'] = 'Password is empty';
		}
		else{
			if(strlen($password) < 6){
				$errors['password'] = 'Password length should be at least 6 symbols';
			}
		}

		if($errors){
			$_SESSION['status'] = 'error';
        	$_SESSION['errors'] = $errors;
        	header('Location: Loginform.php');
		}
		else {
			require_once '../common/connect.php';
			$user = loginUser($email, $password);

			if($user){
				$_SESSION['status'] = 'success';
	        	$_SESSION['message'] = 'You have logged in';
	        	$_SESSION['user'] = $user;
				
				if ($user['role'] == 'user') {
					header('Location: ../index.php');
				} elseif ($user['role'] == 'admin') {
					header('Location: ../indexAdmin.php');
				} elseif ($user['role'] == 'moderator') {
					header('Location: ../indexModerator.php');
				}			
			}else{
				$_SESSION['status'] = 'mainError';
	        	$_SESSION['message'] = 'No user with this email and password. You need to regitrate';
	        	header('Location: Loginform.php');
			}
		}
	}
  

?>