<?php

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=narxoz;", "root", "");
	}catch(PDOException $ex){
		echo $ex->getMessage();
	}

	function registerUser($email, $password, $name, $avatar='no-ava.jpg', $role='user'){

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

	function createPost($title, $content, $category_id, $user_id,$image='no-img.jpg', $status='draft'){

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
			$queryObj = $pdo->prepare("select posts.*, users.name from posts left join users on posts.user_id=users.id where posts.category_id = ?");
			$queryObj->execute([$catId]);
		}
		else{
			$queryObj = $pdo->query("select posts.*, users.name from posts left join users on posts.user_id=users.id");
		}

		
		$posts = $queryObj->fetchAll(PDO::FETCH_ASSOC);
		return $posts;
	}

	function searchPosts($search){
		global $pdo;

		if($search){
			$queryObj = $pdo->prepare("select * from posts where title like :search OR content like :search");
			$queryObj->execute(['search' => '%'.$search.'%']);
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

	function ratePost($user_id, $post_id, $rating){
		global $pdo;
		$queryObj = $pdo->prepare("select * from user_post where uid=:uid and pid=:pid");

		try {
			$queryObj->execute([
				'uid' => $user_id,
				'pid' => $post_id,
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}

		$result = $queryObj->fetch(PDO::FETCH_ASSOC);

		if($result){
			$queryObj = $pdo->prepare("update user_post SET rating=:rating where uid=:uid and pid=:pid");
		}
		else{
			$queryObj = $pdo->prepare("insert into user_post(uid, pid, rating) values(:uid, :pid, :rating)");
		}

		try {
			$queryObj->execute([
				'uid' => $user_id,
				'pid' => $post_id,
				'rating' => $rating,
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}
		return true;
	}

	function getRating($post_id){
		global $pdo;
		$queryObj = $pdo->prepare("select avg(rating) as rating from user_post where pid=:pid");

		try {
			$queryObj->execute([
				'pid' => $post_id,
			]);
		}catch(PDOException $ex){
			echo $ex->getMessage();
			return false;
		}
		$result = $queryObj->fetch(PDO::FETCH_ASSOC);
		return $result;
	}

	// commentbar

	function addComment($post_id, $user_id, $comment) {
		global $pdo;
		$queryObj = $pdo->prepare("INSERT into comments (post_id, user_id, comment, created_at) VALUES (:pid, :uid, :com, NOW())");
	
		try {
			$queryObj->execute([
				'pid' => $post_id,
				'uid' => $user_id,
				'com' => $comment,
			]);
		} catch (PDOException $ex) {
			echo $ex->getMessage();
			return false;
		}
		$result = $queryObj->fetch(PDO::FETCH_ASSOC);
		return $result;	}

		function getComments($post_id) {
			global $pdo;
			$queryObj = $pdo->prepare("SELECT * FROM comments WHERE post_id = :pid");
		
			try {
				$queryObj->execute(['pid' => $post_id]);
				$comments = $queryObj->fetchAll(PDO::FETCH_ASSOC);
				return $comments;
			} catch (PDOException $ex) {
				echo $ex->getMessage();
				return []; // Return an empty array in case of an error
			}
		}
		

?>

		



