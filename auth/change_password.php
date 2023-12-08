<?php
session_start();
require_once '../common/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

    $errors = [];
    if (empty($currentPassword)) {
        $errors['current_password'] = ' Empty! current password';
    }

    if (empty($newPassword)) {
        $errors['new_password'] = 'Empty! new password';
    } elseif (strlen($newPassword) < 6) {
        $errors['new_password'] = 'Password length must be at least 6 characters long';
    }

    if (empty($confirmNewPassword)) {
        $errors['confirm_new_password'] = 'Empty! new password';
    } elseif ($newPassword !== $confirmNewPassword) {
        $errors['confirm_new_password'] = 'Passwords do not match';
    }

    if (empty($errors)) {
        if (md5($currentPassword) !== $user['password']) {
            $errors['current_password'] = 'Incorrect old password';
        }

        if (strlen($newPassword) < 6) {
            $errors['new_password'] = 'Password length must be at least 6 characters long';
        }

        if ($newPassword !== $confirmNewPassword) {
            $errors['confirm_new_password'] = 'Passwords do not match';
        }
    }

    if ($errors) {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header('Location: change_password_form.php');
        exit();
    } else {
        $_SESSION['user']['password'] = md5($newPassword);
        updatePassword($user['email'], $newPassword);

        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Password changed successfully!';
        header('Location: change_password_form.php');
        exit();
    }
}
?>
