<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'common/connect.php'; 
    $comment_id = $_POST['comment_id'] ?? '';
    $user_role = $_SESSION['user']['role'] ?? ''; 
    $user_id = $_SESSION['user']['id'] ?? ''; 
    
    if ($comment_id && $user_role && $user_id) {
        $result = deleteComment($comment_id, $user_role, $user_id);
        var_dump($post_id);
        
        if ($result) {
            $post_id = $_POST['post_id'] ?? ''; 
            if ($post_id) {
                header("Location: onePost.php?post_id=$post_id");
                exit(); 
            } else {
                echo "post_id не определен";
            }
        } else {
            echo "Ошибка при удалении комментария";
        }
    } else {
        echo "comment_id, user_role или user_id не определены";
    }
}
?>
