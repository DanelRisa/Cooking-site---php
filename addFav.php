<?php
session_start();
require_once 'common/connect.php';
require_once 'common/check_login.php';
require_once 'common/checkNav.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'] ?? ''; // Get user ID from the session or your authentication method
    $post_id = $_POST['post_id'] ?? '';

    if ($user_id && $post_id) {
        $result = addFav($user_id, $post_id);
        if ($result) {
            // Handle successful addition of favorite
            header("Location: fav.php"); // Redirect to the desired page after adding favorite
            exit();
        } else {
            // Handle failure to add favorite
            echo "Failed to add favorite.";
        }
    } else {
        echo "User ID or Post ID missing.";
    }
} else {
    echo "Invalid request method.";
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