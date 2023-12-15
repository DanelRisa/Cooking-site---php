<?php
session_start();
require_once 'common/connect.php';
require_once 'common/checkModerator.php';
require_once 'common/checkAdmin.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $newCategoryName = $_POST['new_category_name'];
    if($newCategoryName !== ''){

    try {
        $query = $pdo->prepare("INSERT INTO categories (breakfast) VALUES (:name)");
        $query->execute(array(':name' => $newCategoryName));
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
}

header("Location: indexAdmin.php");
exit();
?>
