<?php
session_start();
require_once 'common/check_login.php';
require_once 'common/connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'] ?? '';
    $new_comment = $_POST['edited_comment'] ?? ''; 
    $result = editComment($comment_id, $new_comment);
            header("Location: index.php");
        exit();
    }
?> 

<!-- session_start();

require_once 'common/check_login.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'] ?? '';

    if ($comment_id) {
        $comment = getComments($comment_id); // Функция для получения комментария по его ID

        if ($comment && ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['id'] === $comment['user_id'])) {
            $new_comment = $_POST['new_comment'] ?? '';

            if ($new_comment !== '') {
                editComment($comment_id, $new_comment); 
                header("Location: onePost.php?post_id={$comment['post_id']}");
                exit();
            }
        }
    }
} -->
