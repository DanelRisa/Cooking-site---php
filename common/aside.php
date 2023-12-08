<div class="card mb-4">
     <div class="card-header">Search</div>
    <div class="card-body">
        <form action="index.php" method="post">
            <div class="input-group">
                <input name="search" class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
            </div>
        </form>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header">Categories</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <ul class="list-unstyled mb-0">
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="index.php?cat_id=<?= $cat['id'] ?>"><?= $cat['breakfast'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header">Side Widget</div>
    <div class="card-body">
        You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!
    </div>
</div>
