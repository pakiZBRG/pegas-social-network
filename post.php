<?php include './includes/header.php' ?>
<?php include './includes/nav.php' ?>
    <div class="row">
        <div class="mt-5 col-sm-12 d-flex justify-content-center align-items-center">
            <?php include "./includes/functions/view_post.inc.php" ?>
        </div>
        <div id="comments" class="mt-3 col-sm-12 d-flex flex-column justify-content-center align-items-center">
            <?php include "./includes/functions/comments.inc.php" ?>
        </div>
    </div>
<?php include './includes/footer.php' ?>
