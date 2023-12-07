<?php

session_start();

require_once 'common/check_login.php';
require_once 'common/connect.php';

$categories = getCategories();

$postId = $_GET['post_id'] ?? null;

$post_id = $_GET['post_id'] ?? '';
$comments = getComments($post_id);
$comment_id = $_POST['comment_id'] ?? '';


if ($postId)
    $post = getOnePost($postId);
$avg = getRating($postId); // $avg is an array

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <?php require_once 'common/nav.php' ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <article>
                    <header class="mb-4">
                        <h1 class="fw-bolder mb-1"><?= $post['title'] ?></h1>
                        <h4>
                            <?php
                            if ($avg['rating'])
                                echo "rating: " . round($avg['rating'], 2);
                            else
                                echo "Not rated";
                            ?>
                        </h4>
                        <div class="text-muted fst-italic mb-2"><?= $post['created_at'] ?></div>

                    </header>
                    <div class="card mb-4">
                        <a href="#!"><img src="http://localhost/recipesproject/images/posts/<?= $post['image'] ?>" alt="Image" class="card-img-top" style="height: 300px; object-fit: cover;"></a>
                        <div class="card-body">
                    <section class="mb-5">
                        <?= $post['content'] ?>
                    </section>
                </article>

                <form action="rate.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <select class="form-select" name="rating">
                        <option value="1">very bad (1)</option>
                        <option value="2">bad (2)</option>
                        <option value="3">ok (3)</option>
                        <option value="4">good (4)</option>
                        <option value="5">very good (5)</option>
                    </select>
                    <button type="submit" class="btn btn-info my-3">Rate</button>
                </form>
                <section class="mb-5">
                    <div class="card bg-light">
                        <div class="card-body">
                            <form action="addComment.php" method="post">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Write your comment here..."></textarea>
                                <button type="submit" class="btn btn-info my-3">Comment</button>
                            </form>
                            <div class="d-flex mb-4">
                                <div class="comments-section">
                                    <?php if (count($comments) > 0) : ?>
                                        <ul class="comment-list">
                                        <?php foreach ($comments as $comment) : ?>
                                            <div class="comment-header d-flex align-items-center">
                                                <img src="http://localhost/recipesproject/images/avatars/<?= $comment['user_avatar'] ?>" alt="Avatar" class="avatar">
                                                <div class="user-details ms-3">
                                                    <h5 class="fw-bold"><?= $comment['user_name'] ?></h5>
                                                    <span class="comment-time"><?= $comment['created_at'] ?></span>
                                                </div>
                                            </div>
                                            <p class="comment-content"><?= $comment['comment'] ?></p>
                                                <form action="deleteComment.php" method="post">
                                                <?php if ($_SESSION['user']['role'] === 'admin' || ($_SESSION['user']['id'] === $comment['user_id'])) : ?>
                                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                                    <button type="submit" class="btn btn-info my-1">Delete</button>
                                                </form>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p>No comments yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
            <?php require_once 'common/aside.php' ?>
        </div>
    </div>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>