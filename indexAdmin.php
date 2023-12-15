<?php
session_start();
require_once 'common/checkAdmin.php';
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

$search = $_POST['search'] ?? '';

    if($search){
        $users = searchUsers($search);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles if needed */
    </style>
</head>
<body>
    <?php require_once 'common/navAdmin.php' ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-6">
                <h1>Categories</h1>
                <?php if (!empty($categories)) : ?>
                    <ul class="list-group">
                        <?php foreach ($categories as $category) : ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <?php echo $category['breakfast']; ?>
                                <?php echo $category['lunch']; ?>
                                <?php echo $category['dinner']; ?>
                                <form method="post" action="editCategory.php" class="ml-auto">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <input type="text" name="updated_category_name" placeholder="New name" class="form-control mr-2">
                                    <button type="submit" name="update" class="btn btn-primary px-2 mt-1">Update</button>
                                </form>
                                <form method="post" action="deleteCategory.php">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger ml-2">Delete</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No categories found.</p>
                <?php endif; ?>
                <form method="post" action="addCategory.php" class="mt-3">
                    <div class="input-group">
                        <input type="text" name="new_category_name" placeholder="New category" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" name="add" class="btn btn-success">Add category</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <form action="indexAdmin.php" method="post">
                        <div class="input-group">
                            <input name="search" class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                        </div>
                    </form>
                </div>
            </div>
                <h1>Users</h1>
                <?php if (!empty($users)) : ?>
                    <ul class="list-group">
                        <?php foreach ($users as $user) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $user['name']; ?> - <?php echo $user['role']; ?>
                                <form method="post" action="changeUserRole.php" class="ml-auto">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <select name="new_role" class="form-control mr-2">
                                        <option value="user" <?php if ($user['role'] === 'user') ?>>User</option>
                                        <option value="admin" <?php if ($user['role'] === 'admin') ?>>Admin</option>
                                        <option value="moderator" <?php if ($user['role'] === 'moderator')?>>Moderator</option>
                                    </select>
                                    <button type="submit" name="change_role" class="btn btn-primary align-items-center mt-2 px-1">Change Role</button>
                                </form>
                                <form method="post" action="banUser.php" class="ml-2">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <input type="number" name="ban_duration" placeholder="Ban duration in minutes">
                                    <button type="submit" name="ban_user" class="btn btn-danger px-1 mt-1">Ban User</button>
                                </form>

                                <form method="post" action="removeBan.php">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="remove_ban" class="btn btn-success px-1">Remove Ban</button>
                                </form>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">&copy; Your Website <?php echo date('Y'); ?></p>
        </div>
    </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
