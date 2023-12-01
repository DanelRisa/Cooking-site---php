<?php

    session_start();

    if (!isset($_SESSION['user'])) {
        header('Location: Loginform.php');
        exit();
    }
    require_once 'common/connect.php';

    $categories = getCategories();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Homepage</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    </head>
    <body>
        
        
        <!-- Page content-->
        <div class="container py-4">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    
    <form action="createPost.php" method="post">
        <div class="form-group">
            <label for="titleId">Post title</label>
            <input name="title" type="text" class="form-control" id="titleId">
        </div> 

        <div class="form-group">
            <label for="contentId">Post content</label>
            <textarea name="content" class="form-control" id="contentId" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="categoryId">Select category</label>
            <select name="category_id" class="form-control" id="categoryId">

        <?php foreach($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= $cat['breakfast'] ?></option>
          <?php endforeach; ?>

            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
                    
                </div>
                <!-- Side widgets-->

                <div class="col-lg-4">
                    <?php require_once 'common/aside.php'; ?>
                </div>
            </div>
        </div>
        <!-- Footer-->
        
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
