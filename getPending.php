<?php
session_start();
require_once 'common/check_login.php';
require_once 'common/connect.php';
require_once 'common/checkNav.php';


$categories = getCategories();


$search = $_POST['search'] ?? '';

if ($search) {
    $posts = searchPosts($search);
} else {
    $catId = $_GET['cat_id'] ?? null;

    if ($catId) {
        $posts = getPosts($catId);
    } else {
        $posts = getPosts();
    }
}

$pendingPosts = getPendingPosts();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['approve']) && isset($_SESSION['user'])) {
        $userRole = $_SESSION['user']['role'];
        $postId = $_POST['approve'];

        if ($userRole === 'moderator' || $userRole === 'admin') {
            approvePost($postId);
        }
        header("Location: getPending.php");
        exit();
    } elseif (isset($_POST['delete']) && isset($_SESSION['user'])) {
        $userRole = $_SESSION['user']['role'];
        $postId = $_POST['delete'];

        if ($userRole === 'moderator' || $userRole === 'admin') {
            deletePost($postId);
        }
        header("Location: getPending.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <?php if ($pendingPosts && count($pendingPosts) > 0) : ?>
                    <h2>Посты, ожидающие модерации:</h2>
                    <ul>
                        <?php foreach ($pendingPosts as $post) : ?>
                            <li>
                                <h3><?= $post['title']; ?></h3>
                                <p><?= $post['content']; ?></p>
                                <a href="#!"><img src="http://localhost/recipesproject/images/posts/<?= $post['image'] ?>" alt="Image" class="card-img-top" style="height: 300px; object-fit: cover;"></a>
                            </li>
                            <form action="getPending.php" method="post">
                                <input type="hidden" name="approve" value="<?= $post['id']; ?>">
                                <?php if ($_SESSION['user']['role'] === 'moderator' || $_SESSION['user']['role'] === 'admin') : ?>
                                    <button type="submit" name="approve" value="<?= $post['id']; ?>">Approve</button>
                                    <button type="submit" name="delete" value="<?= $post['id']; ?>">Delete</button>
                                <?php endif; ?>
                            </form>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>Нет постов, ожидающих модерации.</p>
                <?php endif; ?>
            </div>
            <?php require_once 'common/aside.php'; ?>
        </div>
    </div>
   
</body>
</html>
