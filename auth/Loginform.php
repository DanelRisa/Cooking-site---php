
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Loginform</title>
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

        .inputError {
            color: red;
        }
    </style>
</head>
<body>

<?php session_start(); ?>


<?php
$hasErrors = false;
if (isset($_SESSION['status']) && $_SESSION['status'] == 'error')
    $hasErrors = true;
?>

<div class="container centerForm">
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['message'] ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'mainError'): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form action="Login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
            <?php if ($hasErrors && isset($_SESSION['errors']['email'])): ?>
                <p class="inputError"><?= $_SESSION['errors']['email'] ?></p>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            <?php if ($hasErrors && isset($_SESSION['errors']['password'])): ?>
                <p class="inputError"><?= $_SESSION['errors']['password'] ?></p>
            <?php endif; ?>
        </div>
        <!-- <div class="form-group form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Remember me</label>
        </div> -->
        <button type="submit" class="btn btn-primary">Login</button>
        <p>Not registered? <a href="Regform.php">Register here</a></p>
    </form>
</div>
<?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['message']);
?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
