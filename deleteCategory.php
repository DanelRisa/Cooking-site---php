<?php
session_start();
require_once 'common/connect.php';
require_once 'common/checkModerator.php';
require_once 'common/checkAdmin.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $categoryId = $_POST['category_id'];

    try {
        $query = $pdo->prepare("DELETE FROM categories WHERE id = :id");
        $query->execute(array(':id' => $categoryId));
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

header("Location: index.php");
exit();
?>
