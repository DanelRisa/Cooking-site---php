<?php
session_start();

$hasErrors = false;

if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
    $hasErrors = true;
}


?>

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

<div class="container centerForm">
    <!-- Показываем сообщение об успешном входе -->
   <!--  <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['message'] ?> 
        </div> -->
    <?php endif; ?>

    <!-- Показываем сообщение об основной ошибке -->
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
        <button type="submit" class="btn btn-primary">Login</button>
        <p>Not registered? <a href="Regform.php">Register here</a></p>
    </form>

    <!-- Проверяем наличие ошибок в сессии и выводим их -->
    <?php
    if ($hasErrors && isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        foreach ($errors as $error) {
            echo '<p class="inputError">' . $error . '</p>';
        }
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
