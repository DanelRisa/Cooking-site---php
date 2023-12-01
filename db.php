<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=narxoz;", "root", "");
}catch(PDOException $exc) {
    echo $exc->getMessage();
}
?>