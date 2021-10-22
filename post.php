<?php require '/app/includes/header.php' ?>
<?php require '/app/includes/nav.php' ?>
    <div class="row">
        <div class="mt-5 col-sm-12 d-flex justify-content-center align-items-center">
            <?php require '/app/includes/functions/view_post.inc.php' ?>
        </div>
        <div id="comments" class="mt-3 col-sm-12 d-flex flex-column justify-content-center align-items-center">
            <?php require '/app/includes/functions/comments.inc.php' ?>
        </div>
    </div>
<?php require '/app/includes/footer.php' ?>
