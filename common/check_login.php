<?php

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    else {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'You need to login';
        header("Location: Loginform.php");
    }

?>