<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: Loginform.php');
    exit();
}

require_once 'common/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .centerForm {
            margin: 50px auto;
            width: 80%;
            max-width: 400px;
        }

        .field-group {
            margin-bottom: 20px;
        }

        .bigError {
            color: red;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .fa-xmark {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
        }

        .success {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php
$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}
?>

<div class="container centerForm">

    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="alert alert-success">
            <?= $_SESSION['message'] ?>
            <p>Lets have fun! <a href="index.php">Main page</a></p>
        </div>
    <?php endif; ?>

    <?php if ($hasErrors && isset($_SESSION['errors'])): ?>
        <div class="bigError">

            <?php foreach ($_SESSION['errors'] as $error): ?>
                <?= $error ?>
                <i class="fa-solid fa-xmark" onclick="this.parentElement.remove()"></i>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['message']);
?>


    <form action="change_password.php" method="post">
        <div class="form-group field-group">
            <label for="current_password">Old Password:</label>
            <input type="password" name="current_password" id="current_password" class="form-control">
        </div>

        <div class="form-group field-group">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" class="form-control">
        </div>

        <div class="form-group field-group">
            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
