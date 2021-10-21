<?php include './includes/header.php' ?>
<?php include './includes/nav.php' ?>
    <div class="row width-80 pb-4">
        <div class="col-sm-12">
            <h2 class='text-center p-4'>Connect with people, or bots</h2>
            <form class='connect-form' method="GET" onchange='searchUser(); return false;'>
                <input type='text' placeholder='Search people by username, first or last name' id='search_user' onkeyup='searchUser(); return false;'>
            </form>
        </div>
        <div class="col-sm-12" id="members">
            <?php include "./includes/functions/search_user.inc.php" ?>
        </div>
    </div>
<?php include './includes/footer.php' ?>