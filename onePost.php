<?php

session_start();

require_once 'common/check_login.php';
require_once 'common/connect.php';
require_once 'common/checkNav.php';

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
    <link href="styles.css" rel="stylesheet" type="text/css">
    <link href="rate.js" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
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

                <!-- <form action="rate.php" method="post">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <select class="form-select" name="rating">
                        <option value="1">very bad (1)</option>
                        <option value="2">bad (2)</option>
                        <option value="3">ok (3)</option>
                        <option value="4">good (4)</option>
                        <option value="5">very good (5)</option>
                    </select>
                    <button type="submit" class="btn btn-info my-3">Rate</button>
                </form> -->
                <form action="rate.php" method="post" class="rating-form">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <div class="rating">
                        <input type="submit" id="star5" name="rating" value="5" >
                        <label for="star5" class="fa fa-star checked"></label>
                        <input type="submit" id="star4" name="rating" value="4">
                        <label for="star4" class="fa fa-star checked"></label>
                        <input type="submit" id="star3" name="rating" value="3">
                        <label for="star3" class="fa fa-star checked"></label>
                        <input type="submit" id="star2" name="rating" value="2">
                        <label for="star2" class="fa fa-star checked"></label>
                        <input type="submit" id="star1" name="rating" value="1">
                        <label for="star1" class="fa fa-star checked"></label>
                    </div>
                    <!-- <button type="submit" class="btn btn-info my-3">Rate</button> -->
                </form>

                <div class="comments-section">
    <form action="addComment.php" method="post">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <textarea class="form-control" name="comment" rows="3" placeholder="Write your comment here..."></textarea>
        <button type="submit" class="btn btn-info my-3">Comment</button>
    </form>

            <?php if (count($comments) > 0) : ?>
                    <?php foreach ($comments as $comment) : ?>
                            <div class="comment-header d-flex align-items-center">
                                <img src="http://localhost/recipesproject/images/avatars/<?= $comment['user_avatar'] ?>" alt="Avatar" class="avatar">
                                <div class="user-details ms-3">
                                    <h5 class="fw-bold"><?= $comment['user_name'] ?></h5>
                                    <span class="comment-time"><?= $comment['created_at'] ?></span>
                                </div>
                            </div>
                            <p class="comment-content"><?= $comment['comment'] ?></p>
                            <div class="comment-actions">
                                <?php if ($_SESSION['user']['role'] === 'admin' || ($_SESSION['user']['id'] === $comment['user_id'])) : ?>
                                    <form action="deleteComment.php" method="post">
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                        <button type="submit" class="btn btn-info my-1">Delete</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($_SESSION['user']['id'] === $comment['user_id'] || $_SESSION['user']['role'] === 'admin') : ?>
                                    <button type="button" class="btn btn-primary" onclick="showEditForm(<?= $comment['id']?>)">Edit</button>
                                    <form action="editComment.php" method="post" id="editForm_<?= $comment['id'] ?>" style="display: none;">
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                        <textarea name="edited_comment" rows="3"><?= $comment['comment'] ?></textarea>
                                        <button type="submit">Save</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                    <?php endforeach; ?>
            <?php else : ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>

            </div>
            <!-- <?php require_once 'common/aside.php' ?> -->
        </div>
    </div>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showEditForm(commentId) {
        var editForm = document.getElementById('editForm_' + commentId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>
</body>

</html>