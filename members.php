<?php require '/app/includes/header.php' ?>
<?php require '/app/includes/nav.php' ?>
    <div class="row width-80 pb-4">
        <div class="col-sm-12">
            <h2 class='text-center p-4'>Connect with people, or bots</h2>
            <form class='connect-form' method="GET" onchange='searchUser(); return false;'>
                <input type='text' placeholder='Search people by username, first or last name' id='search_user' onkeyup='searchUser(); return false;'>
            </form>
        </div>
        <div class="col-sm-12" id="members">
            <?php require '/app/includes/functions/search_user.inc.php' ?>
        </div>
    </div>
<?php require '/app/includes/footer.php' ?>