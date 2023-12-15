<?php
session_start();
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ban_user'])) {
    $user_id = $_POST['user_id'];
    $ban_duration = $_POST['ban_duration'];

    if (banUser($user_id, $ban_duration)) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Failed to ban the user.";
    }
}
?>
