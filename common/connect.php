<?php

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=narxoz;", "root", "");
	}catch(PDOException $ex){
		echo $ex->getMessage();
	}

	function registerUser($email, $password, $name, $role='user', $avatar='no-ava.jpg'){

		global $pdo;
		$queryObj = $pdo->prepare("insert into users(email, password, name, role, avatar) values(:ue, :up, :un, :ur, :ua)");

		try {
			$queryObj->execute([
				'ue' => $email,
				'up' => md5($password),
				'un' => $name,
				'ur' => $role,
				'ua' => $avatar,
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}
		return true;
	}

	function loginUser($email, $password){
		global $pdo;
		$queryObj = $pdo->prepare("select * from users where email = :ue and password = :up");

		$queryObj->execute([
			'ue' => $email,
			'up' => md5($password)
		]);

		$user = $queryObj->fetch(PDO::FETCH_ASSOC);
		return $user;
	}

    function updatePassword($email, $newPassword) {
        global $pdo;

        $queryObj = $pdo->prepare("update users set password = :up WHERE email = :ue");

        try {
            $queryObj->execute([
                'up' =>  md5($newPassword),
                'ue' => $email,
            ]);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

	function getCategories(){
		global $pdo;
		$queryObj = $pdo->query("select * from categories");
		$categories = $queryObj->fetchAll(PDO::FETCH_ASSOC);
		return $categories;
	}


	function createPost($title, $content, $category_id, $user_id, $status='draft', $image='no-img.jpg'){

		global $pdo;
		$queryObj = $pdo->prepare("insert into posts(title, content, category_id, user_id, status, image, created_at) values(:ptt, :pcn, :pci, :pui, :pst, :pim, :pca)");

		date_default_timezone_set('Asia/Almaty');

		try {
			$queryObj->execute([
				'ptt' => $title,
				'pcn' => $content,
				'pci' => $category_id,
				'pui' => $user_id,
				'pst' => $status,
				'pim' => $image,
				'pca' => date("Y-m-d H:i:s", time()),
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}
		return true;
	}

	function getPosts($catId = null){
		global $pdo;

		if($catId){
			$queryObj = $pdo->prepare("select * from posts where category_id = ?");
			$queryObj->execute([$catId]);
		}
		else{
			$queryObj = $pdo->query("select * from posts");
		}

		
		$posts = $queryObj->fetchAll(PDO::FETCH_ASSOC);
		return $posts;
	}

	function getOnePost($postId){
		global $pdo;

		$queryObj = $pdo->prepare("select * from posts where id = ?");
		$queryObj->execute([$postId]);

		$post = $queryObj->fetch(PDO::FETCH_ASSOC);
		return $post;
	}

	function editPost($id, $title, $content, $category_id, $status='draft', $image='no-img.jpg'){

		global $pdo;
		$queryObj = $pdo->prepare("update posts SET title=:ptt, content=:pcn, category_id=:pci, status=:pst, image=:pim where id=:pid");

		try {
			$queryObj->execute([
				'pid' => $id,
				'ptt' => $title,
				'pcn' => $content,
				'pci' => $category_id,
				'pst' => $status,
				'pim' => $image,
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}
		return true;
	}

	function deletePost($postId){
		global $pdo;

		$queryObj = $pdo->prepare("delete from posts where id = ?");
		$result = $queryObj->execute([$postId]);

		return $result;
	}



    // function createComment($user_email, $text, $dateTime, $recipy_id, $db) {
    //     if ($user_email == '') {
    //         return "<h4><center>Select your e-mail id first!</h4></center>";
    //     } elseif (empty($text)) {
    //         return "<h4><center>Please fill out the Text fields first!</center></h4>";
    //     } else {
    //         $sql = "INSERT INTO commentbar(user_id, text, date_time, recipy_id) VALUES ('$user_email','$text','$dateTime','$recipy_id')";
    //         if (mysqli_query($db, $sql)) {
    //             return true; 
    //         } else {
    //             return "<h4><center>Error inserting comment!</center></h4>";
    //         }
    //     }
    // }

    // function getCommentsByRecipeId($recipe_id, $db) {
    //     $sql = "SELECT users.*, commentbar.* FROM signup, commentbar WHERE users.user_id = commentbar.user_id AND recipy_id='$recipe_id' ORDER BY id DESC";
    //     $result = mysqli_query($db, $sql);
    //     $comments = [];
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $comments[] = $row;
    //     }
    //     return $comments;
    // }
    

?>



