
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header("Location: Loginform.php");
        exit();
    }

    if (isset($_POST['logout'])) {
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        unset($_SESSION['user']);
        session_destroy();
        header("Location: Loginform.php");
        exit();
    }
}

?>
