<?php if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    header("Location: auth/Loginform.php");
    exit();
}
 ?><nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home | </a></li>
                        <li class="nav-item"><a class="nav-link" href="indexModerator.php">Moderator Home | </a></li>
                        <li class="nav-item"><a class="nav-link" href="createPostForm.php">Create Post| </a></li>
                        <li class="nav-item"><a class="nav-link" href="getPending.php">Pending Posts | </a></li>
                        <li class="nav-item"><a class="nav-link" href="Profile.php">Profile | </a></li>
                        <li class="nav-item"><a class="nav-link" href="fav.php">Favourites | </a></li>




                        <li><img src="http://localhost/recipesproject/images/avatars/<?=$user['avatar']?>" alt="Avatar" class="avatar"></li>
                    </ul>
                </div>
                <form action="" method="post">
                <input type="submit" class="btn btn-danger" name="logout" value="Logout">
                </form>
            </div>
        </nav>

        <!DOCTYPE html>
        <body>
            <style>
            .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
            </style>
            
        </body>
        </html>