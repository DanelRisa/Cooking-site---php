<?php
session_start();
require_once 'common/checkModerator.php';
require_once 'common/connect.php';

$categories = [];
$users = [];

try {
    $queryCategories = $pdo->query("SELECT id, breakfast, lunch, dinner FROM categories");
    $categories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);

    $queryUsers = $pdo->query("SELECT id, name, role FROM users");
    $users = $queryUsers->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .card-body form {
            display: inline;
        }
    </style>
</head>

<body>
    <?php require_once 'common/navModerator.php' ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-6">
                <h1>Categories</h1>

                <?php if (!empty($categories)) : ?>
                    <ul>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <?php echo $category['breakfast']; ?>
                                <?php echo $category['lunch']; ?>
                                <?php echo $category['dinner']; ?>

                                <form method="post" action="editCategory.php">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <input type="text" name="updated_category_name" placeholder="New name">
                                    <button type="submit" name="update">Update</button>
                                </form>

                                <form method="post" action="deleteCategory.php">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <button type="submit" name="delete">Delete</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No categories found.</p>
                <?php endif; ?>

                <form method="post" action="addCategory.php">
                    <input type="text" name="new_category_name" placeholder="New category">
                    <button type="submit" name="add">Add category</button>
                </form>
            </div>
        </div>
    </div>
   
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>