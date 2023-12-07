<?php
// deleteComment.php

session_start(); // Убедитесь, что сессия уже запущена

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'common/connect.php'; // Подключение к базе данных

    $comment_id = $_POST['comment_id'] ?? '';
    $user_role = $_SESSION['user']['role'] ?? ''; // Получение роли текущего пользователя из сессии
    $user_id = $_SESSION['user']['id'] ?? ''; // Получение ID текущего пользователя из сессии

    if ($comment_id && $user_role && $user_id) {
        $result = deleteComment($comment_id, $user_role, $user_id);

        if ($result) {
            // Успешно удалено
            $post_id = $_POST['post_id'] ?? ''; // Получение post_id из формы
            if ($post_id) {
                header("Location: onePost.php?post_id=$post_id");
                exit(); // Для предотвращения дальнейшего выполнения кода
            } else {
                echo "post_id не определен";
                // Дополнительные действия в случае отсутствия post_id
            }
        } else {
            echo "Ошибка при удалении комментария";
            // Дополнительные действия в случае неудачного удаления комментария
        }
    } else {
        echo "comment_id, user_role или user_id не определены";
        // Дополнительные действия в случае отсутствия каких-либо значений
    }
}
?>
