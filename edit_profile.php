<?php 

    require '/includes/header.php';
    require '/includes/nav.php';
    require '/includes/db.inc.php';

    $user_id = $_SESSION["userId"];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $user_name = $row["username"];
        $describe_user = $row["describe_user"];
    }

?>
    <div class="row width-90 mx-auto">
        <div class='col-sm-12'>
            <h1 class='text-center py-4 font-weight-bold' style='font-family: "Fredericka The Great";'>Edit your profile</h1>
            <div id="message" class='mb-4'></div>
            <form class='editProfile mx-auto' method='POST' enctype='multipart/form-data'>
                <input type="hidden" id="userId" value="<?php echo $user_id; ?>">
                <div class="form_control">
                    <label for="first_name">First Name</label>
                    <input
                        type="text"
                        name='first_name'
                        id='first_name'
                        value="<?php echo $first_name; ?>"
                    >
                </div>
                <div class="form_control">
                    <label for="last_name">Last Name</label>
                    <input
                        type="text"
                        name='last_name'
                        id='last_name'
                        value="<?php echo $last_name; ?>"
                    >
                </div>
                <div class="form_control">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        name='username'
                        id='username'
                        autocomplete="off"
                        value="<?php echo $user_name; ?>"
                        onchange="editUsername()"
                    >
                </div>
                <div class="form_control">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" rows="4"><?php echo $describe_user; ?></textarea>
                    <div class='limit'>
                        <div id="length"></div>
                    </div>
                </div>
                <span class='delete-acc' onclick='modal()'>Delete account</span>
                <button id='updateBtn' onclick="updateProfile(); return false;">Update</button>
            </form>
        </div>
    </div>
    <?php require '/includes/modal.php' ?>  
    <script>
        textLimit('#bio', 150, '#updateBtn');
    </script>
<?php require '/includes/footer.php' ?>