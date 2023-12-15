<?php

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    else {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'You need to login';
        header("Location: auth/Loginform.php");
    }

    $banned_until = $user['banned_until'];
    $isBanExpired = isBanExpired($banned_until);
if (!$isBanExpired) {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'Your account is temporarily banned.';
        header('Location: auth/Loginform.php');
        exit();
    }

?>