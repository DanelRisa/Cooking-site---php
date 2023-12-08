<?php
session_start();
require_once 'common/connect.php';
require_once 'common/checkModerator.php';
require_once 'common/checkAdmin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $categoryId = $_POST['category_id'];
    $updatedCategoryName = $_POST['updated_category_name'];

    try {
        $query = $pdo->prepare("UPDATE categories SET breakfast = :name WHERE id = :id");
        $query->execute(array(':name' => $updatedCategoryName, ':id' => $categoryId));
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

header("Location: index.php");
exit();
?>
