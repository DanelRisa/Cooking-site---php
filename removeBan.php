<?php
session_start();
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_ban'])) {
    $user_id = $_POST['user_id'];

    if (removeBan($user_id)) {
        header("Location: indexAdmin.php");
        exit();
    } else {
        echo "Failed to remove the ban from the user.";
    }
}
?>
