<?php require '/includes/header.php' ?>
<?php require '/includes/nav.php' ?>
    <div class="row width-80 pb-4">
        <div class="col-sm-12">
            <h2 class='text-center p-4 font-weight-bold' style='font-family: "Fredericka The Great";'>Connect with people, or bots</h2>
            <form class='connect-form' method="GET" onchange='searchUser(); return false;'>
                <input type='text' placeholder='Search people by username, first or last name' id='search_user' onkeyup='searchUser(); return false;'>
            </form>
        </div>
        <div class="col-sm-12" id="members">
            <?php require '/includes/functions/search_user.inc.php' ?>
        </div>
    </div>
<?php require '/includes/footer.php' ?>