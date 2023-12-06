<?php
session_start();

require_once 'common/connect.php';
require_once 'common/check_login.php';

// if (!isset($_SESSION['user'])) {
//     header("Location: auth/Loginform.php");
//     exit();
// }

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("Location: auth/Loginform.php");
    exit();
}

$categories = getCategories();

$cat_id = $_GET['cat_id'] ?? '';
if($cat_id)
    $posts = getPosts($cat_id);
else
    $posts = getPosts();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nyam</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .user-icon {
            display: inline-block;
            height: 20px;
            width: 20px;
            margin-right: 5px;
            vertical-align: middle;
        }
        .card-body form {
            display: inline;
        }
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </div>
    <?php require_once 'common/nav.php' ?>
    
<div class="container body-content">
    
    <div>
        <form action="" method="post">
            <input type="submit" class="btn btn-danger" name="logout" value="Logout">
        </form>
        <form action="auth\change_password.php" method="post">
            <input type="submit" class="btn btn-primary" name="change_password" value="Change password">
        </form>
        <form action="createPostForm.php" method="post">
            <input type="submit" class="btn btn-primary" name="createPostForm" value="Create Post">
        </form>


    </div>

    <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                           
                        <?php foreach($posts as $post): ?>
                            
                            <div class="card mb-4">
                                <a href="#!"><img src="http://localhost/recipesproject/images/posts/<?= $post['image'] ?>" alt="Image" class="image"></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?= $post['created_at'] ?></div>
                                    <div class="small text-muted">author: <?=$post['name']?></div>
                                    <h2 class="card-title h4"><?= $post['title'] ?></h2>
                                    <p class="card-text"><?= $post['content'] ?></p>
                                    <a class="btn btn-primary" href="onePost.php?post_id=<?= $post['id'] ?>">Read →</a>
                                    
                                    <?php if($post['user_id'] == $user['id']): ?>
                    
                                        <a class="btn btn-primary" href="editPostForm.php?post_id=<?= $post['id'] ?>">Edit →</a>
                    
                                    <form onsubmit="return confirm('Really want to delete?')" action="deletePost.php" method="post">
                                        <input type="hidden" name="post_id" value="<?= $post['id']?>">
                                        <button class="btn btn-danger" type="submit">
                                            Delete
                                        </button>
                                    </form>
                    
                                    <?php endif; ?>
                    
                                </div>
                            </div>
                                                
                                                 <?php endforeach; ?>
                            

                        </div>
                    </div>
                    <!-- Pagination-->
                    <nav aria-label="Pagination">
                        <hr class="my-0" />
                        <ul class="pagination justify-content-center my-4">
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                            <li class="page-item"><a class="page-link" href="#!">2</a></li>
                            <li class="page-item"><a class="page-link" href="#!">3</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                            <li class="page-item"><a class="page-link" href="#!">15</a></li>
                            <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <?php require_once 'common/aside.php'; ?>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
   

    <!-- 
        <div class="body">
	
		<div>
			<div class="header">
				<ul>
					<li class="current">
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="recipes.php">Recipes</a>
					</li>
					<li>
							<a href="featured.php">Recipe of Month</a>
					</li>
					
					<li>
						<a href="about.php">About</a>
					</li>
					
					
					
				</ul>
			</div>
			<div class="body">
				<div>
					<a href="index.php"><img src="images/turkey.jpg" alt="Image"></a>
				</div>
				<ul>
					<li class="current">
						<a href="blog.php"><img src="images/holi-turkey.jpg" alt="Image"></a>
						<div>
							<h2><a href="blog.php">Holy Turkey</a></h2>
							<p>
								Tuck wings under turkey
								
							</p>
						</div>
					</li>
					<li>
						<a href="blog.php"><img src="images/fruits-and-bread.jpg" alt="Image"></a>
						<div>
							<h2><a href="blog.php">Fruits &amp; Bread</a></h2>
							<p>
								Fresh Fruit Bread Recipe
							</p>
						</div>
					</li>
					<li>
						<a href="blog.php"><img src="images/dessert.jpg" alt="Image"></a>
						<div>
							<h2><a href="blog.php">Dessert</a></h2>
							<p>
								5 Quick-and-Easy Dessert Recipes
							</p>
						</div>
					</li>
				</ul>
			</div>
			<div class="footer">
				<ul>
				<li>
						<h2><a href="recipes.php"> Recipes</a></h2>
						<a href="recipes.php"><img src="images/a-z.jpg" alt="Image"></a>
					</li>
					<li>
						<h2><a href="featured.php">Featured Recipes</a></h2>
						<a href="featured.php"><img src="images/featured.jpg" alt="Image"></a>
					</li>
					
				</ul>
				<ul>
					<li>
						<h2><a href="videos.php">Videos</a></h2>
						<a href="videos.php"><img src="images/videos.jpg" alt="Image"></a>
					</li>
					<li>
						<h2><a href="blog.php">Blog</a></h2>
						<a href="blog.php"><img src="images/blog.jpg" alt="Image"></a>
					</li>
				</ul>
			</div>
		</div>
		<div>
			<div>
				<h3>Cooking Video</h3>
				<a href="videos.php"><img src="images/cooking-video.png" alt="Image"></a>
				<span>Vegetable &amp; Rice Topping</span>
			</div>
			<div>
				<h3>Featured Recipes</h3>
				<ul id="featured">
					<li>
						<a href="recipes.php"><img src="images/sandwich.jpg" alt="Image"></a>
						<div>
							<h2><a href="recipes.php">Ham Sandwich</a></h2>
							<span>by: Anna</span>
						</div>
					</li>
					<li>
						<a href="recipes.php"><img src="images/biscuit-and-coffee.jpg" alt="Image"></a>
						<div>
							<h2><a href="recipes.php">Biscuit &amp; Sandwich</a></h2>
							<span>by: Sarah</span>
						</div>
					</li>
					<li>
						<a href="recipes.php"><img src="images/pizza.jpg" alt="Image"></a>
						<div>
							<h2><a href="recipes.php">Delicious Pizza</a></h2>
							<span>by: Rico</span>
						</div>
					</li>
				</ul>
			</div>
			 -->
			
				<!-- <h3>Settings</h3>
				<form action="" method="post">
            	<input type="submit" name="logout" value="Logout">
        		</form>

				<form action="change_password.php" method="post">
            	<input type="submit" name="change_password" value="Change password">
        		</form> -->
				
		</div>
	</div>
</body>
</html>