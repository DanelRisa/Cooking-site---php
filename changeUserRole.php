<?php
session_start();
require_once 'common/checkAdmin.php';
require_once 'common/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'], $_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    try {
        $updateQuery = $pdo->prepare("UPDATE users SET role = :new_role WHERE id = :user_id");
        $updateQuery->bindParam(':new_role', $new_role);
        $updateQuery->bindParam(':user_id', $user_id);
        $updateQuery->execute();

        $_SESSION['message'] = 'Role updated successfully';
        $_SESSION['status'] = 'success';
        header('Location: indexAdmin.php'); 
        exit();
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error updating role';
        header('Location: indexAdmin.php');
        exit();
    }
} else {
    header('Location: indexAdmin.php');
    exit();
}
?>
