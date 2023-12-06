<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register form </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .inputError {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .centerForm {
            margin-top: 50px;
        }
        .errorHighlight {
            border: 1px solid red;
        }
    </style>
</head>
<body>

    <?php
    session_start();

    $hasErrors = false;
    $errorMessages = [];

    if (isset($_SESSION['status']) && $_SESSION['status'] == 'error') {
        $hasErrors = true;
        if (isset($_SESSION['errors'])) {
            $errorMessages = $_SESSION['errors'];
        }
    }
    ?>

    <div class="container centerForm">
        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'success'): ?>
            <div class="alert alert-success">
                <?= $_SESSION['message'] ?>
            </div>
        <?php endif; ?>

        <form action="Registration.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control <?php if ($hasErrors && isset($errorMessages['name'])) echo 'errorHighlight'; ?>">
                <?php if ($hasErrors && isset($errorMessages['name'])): ?>
                    <p class="inputError"><?= $errorMessages['name'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control <?php if ($hasErrors && isset($errorMessages['email'])) echo 'errorHighlight'; ?>">
                <?php if ($hasErrors && isset($errorMessages['email'])): ?>
                    <p class="inputError"><?= $errorMessages['email'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control <?php if ($hasErrors && isset($errorMessages['password'])) echo 'errorHighlight'; ?>">
                <?php if ($hasErrors && isset($errorMessages['password'])): ?>
                    <p class="inputError"><?= $errorMessages['password'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php if ($hasErrors && isset($errorMessages['confirm_password'])) echo 'errorHighlight'; ?>">
                <?php if ($hasErrors && isset($errorMessages['confirm_password'])): ?>
                    <p class="inputError"><?= $errorMessages['confirm_password'] ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                    <label for="avatar">User Avatar</label>
                    <input type="file" id="avatar" name="avatar" />
                    <?php if($hasErrors && isset($errorMessages['errors']['avatar'])): ?>
						<p class="inputError"><?= $errorMessages['errors']['avatar'] ?></p>
					<?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
            <p>Registered? <a href="Loginform.php">Login here</a></p>
        </form>
    </div>

    <?php
    unset($_SESSION['status']);
    unset($_SESSION['errors']);
    unset($_SESSION['message']);
    ?>

</body>
</html>
