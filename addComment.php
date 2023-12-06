<?php
session_start();

require_once 'common/check_login.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? '';
    $user_id = $user['id'];
    $comment = $_POST['comment'] ?? '';

    if ($post_id && $comment !== '') {
        if (isset($user['id'])) {
            $result = addComment($post_id, $user_id, $comment);
            if ($result) {
                header("Location: onePost.php?post_id=$post_id");
            } 
        }
    }

}
?>