<?php
session_start();

require_once 'common/connect.php';
require_once 'common/check_login.php';

// if (!isset($_SESSION['user'])) {
//     header("Location: auth/Loginform.php");
//     exit();
// }

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("Location: auth/Loginform.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <title>Your profile</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-header">
                        <h1 class="display-4">Welcome, 
                            <?php echo isset($user['name']) ? $user['name'] : 'User'; ?>!</h1>
                    </div>
                    <div class="card-body">
                    <img src="http://localhost/recipesproject/images/avatars/<?=$user['avatar']?>" alt="Avatar" class="avatar">
                         <form action="" method="post">
                            <input type="submit" class="btn btn-danger" name="logout" value="Logout">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
