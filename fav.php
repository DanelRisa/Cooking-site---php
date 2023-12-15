<?php
session_start();
require_once 'common/connect.php';
require_once 'common/check_login.php';
require_once 'common/checkNav.php';

$user_id = $_SESSION['user']['id'] ?? '';
$favPosts = [];

if ($user_id) {
    $favPosts = getFavPosts($user_id);
} else {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_fav'])) {
    $user_id = $_SESSION['user']['id'] ?? '';
    $post_id = $_POST['post_id'] ?? '';

    if ($user_id && $post_id) {
        $result = removeFav($user_id, $post_id); // Функция для удаления избранного поста из базы данных
        if ($result) {
            // Handle successful removal from favorites
            header("Location: fav.php"); // Redirect to the favorites page after removing from favorites
            exit();
        } else {
            // Handle failure to remove from favorites
            $_SESSION['error_message'] = "Failed to remove from favorites.";
            header("Location: fav.php"); // Redirect to the favorites page with error message
            exit();
        }
    } else {
        $_SESSION['error_message'] = "User ID or Post ID missing.";
        header("Location: fav.php"); // Redirect to the favorites page with error message
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Избранные посты</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Ваши стили */
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="col-lg-6 mx-auto">
                    <h1>Избранные посты</h1>
                    <?php if ($favPosts && count($favPosts) > 0) : ?>
                        <?php foreach ($favPosts as $post) : ?>
                            <div class="card mb-4">
                                <form action="fav.php" method="post">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                    <!-- Кнопка в виде сердца для удаления из избранного -->
                                    <button type="submit" name="remove_fav" style="background: none; border: none;">
                                        <img src="heart.png" alt="Remove from Favorites" width="30" height="30">
                                    </button>
                                </form>
                                <!-- Остальная разметка для отображения поста -->
                                <a href="#!"><img src="http://localhost/recipesproject/images/posts/<?= $post['image'] ?>" alt="Изображение" class="card-img-top" style="height: 300px; object-fit: cover;"></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?= $post['created_at'] ?></div>
                                    <div class="small text-muted">Автор: <?= $post['user_name'] ?></div>
                                    <h2 class="card-title h4"><?= $post['title'] ?></h2>
                                    <p class="card-text"><?= $post['content'] ?></p>
                                    <!-- Другие детали поста -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Нет избранных постов.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
