<?php

    if(isset($_SESSION['user'])){
        if($_SESSION['user']['role'] == 'admin'){
            $user = $_SESSION['user'];
        }
        else {
            header("Location: index.php");
        }
    }
    else {
        $_SESSION['status'] = 'mainError';
        $_SESSION['message'] = 'First you need to login';
        header("Location: ../auth/Loginform.php");
    }

?>