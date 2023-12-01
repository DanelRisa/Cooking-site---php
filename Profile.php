<?php
session_start();
include 'db.php';

if (!isset($_SESSION['authenticated'])) {
    header('Location: Loginform.php');
    exit();
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
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
                        <img src="Youre-welcome.png" alt="image" class="img-fluid rounded-circle mb-4" width="300">
                        
                        <form action="Logout.php" method="POST">
                            <button class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
