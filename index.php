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

    $search = $_POST['search'] ?? '';

    if($search){
        $posts = searchPosts($search);
    }
    else {
        $catId = $_GET['cat_id'] ?? null;

        if($catId)
            $posts = getPosts($catId);
        else
            $posts = getPosts();
    }

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
     <?php if(isset($_SESSION['user'])) {
    if($_SESSION['user']['role'] === 'admin') {
        require_once 'common/navAdmin.php';
    } elseif($_SESSION['user']['role'] === 'moderator') {
        require_once 'common/navModerator.php';
    } else {
        require_once 'common/nav.php';
    }
} ?>
    
<div class="container body-content">
    
    <div>
        <form action="auth\change_password.php" method="post">
            <input type="submit" class="btn btn-primary" name="change_password" value="Change password">
        </form>
    </div>
    <div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                <?php foreach($posts as $post): ?>
                    <div class="card mb-4">
                    <form action="addFav.php" method="post">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <!-- Изображение сердца в качестве кнопки -->
    <button type="submit" name="add_fav" style="background: none; border: none;">
        <img src="heart.png" alt="Add to Favorites" width="30" height="30">
    </button>
                    </form>
                        


                        <a href="#!"><img src="http://localhost/recipesproject/images/posts/<?= $post['image'] ?>" alt="Image" class="card-img-top" style="height: 300px; object-fit: cover;"></a>
                        <div class="card-body">
                            <div class="small text-muted"><?= $post['created_at'] ?></div>
                            <div class="small text-muted">author: <?=$post['name']?></div>
                            <h2 class="card-title h4"><?= $post['title'] ?></h2>
                            <p class="card-text"><?= $post['content'] ?></p>
                            <a class="btn btn-primary" href="onePost.php?post_id=<?= $post['id'] ?>">Read →</a>
                            
                            <?php if($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'moderator'|| $post['user_id'] == $user['id']): ?>
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
            <nav aria-label="Pagination">
                <hr class="my-0" />
                <ul class="pagination justify-content-center my-4">
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                    <li class="page-item"><a class="page-link" href="#!">2</a></li>
                    <li class="page-item"><a class="page-link" href="#!">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                    <li class="page-item"><a class="page-link" href="#!">15</a></li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-4">
            <?php require_once 'common/aside.php'; ?>
        </div>
    </div>
</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>				
		</div>
	</div>
	<footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">&copy; Your Website <?php echo date('Y'); ?></p>
        </div>
    </footer>
</body>
</html>