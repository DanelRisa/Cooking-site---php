<?php
session_start();

unset($_SESSION['status']);
unset($_SESSION['message']);
unset($_SESSION['user']);


header('Location: Loginform.php');
exit;
?>
