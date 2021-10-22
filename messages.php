<?php require '/app/includes/header.php' ?>
<?php require '/app/includes/nav.php' ?>
<?php require '/app/includes/db.inc.php' ?>
    <div class="row" style='height: calc(100vh - 80px);'>
        <div class="col-lg-3 pr-0 follower">
            <input type='hidden' value='<?php echo $_SESSION["userId"]; ?>' id='userId' />
            <?php
                $userId = $_SESSION["userId"];
                $sql = "SELECT * FROM followers WHERE followed=? OR follower=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $userId, $userId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while($row = mysqli_fetch_assoc($result)) {
                    if($userId != $row["follower"]) {
                        $user = $row["follower"];
                    } else if($userId != $row["followed"]) {
                        $user = $row["followed"];
                    }

                    $user = "SELECT * FROM users WHERE id=$user";
                    $stmt_u = mysqli_prepare($conn, $user);
                    mysqli_stmt_execute($stmt_u);
                    $result_u = mysqli_stmt_get_result($stmt_u);
                    if($row_u = mysqli_fetch_assoc($result_u)) {
                        $user_id = $row_u["id"];
                        $loggedUser = $_SESSION["userId"];
                        $profile_img = $row_u["profile_image"];
                        $first_name = $row_u["first_name"];
                        $last_name = $row_u["last_name"];

                        echo "
                            <div class='follower-card' onclick='loadMessagesAndUser($user_id, $loggedUser);'>
                                <img src='/$profile_img' alt='$first_name $last_name'>
                                <p>$first_name $last_name</p>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
        <div class='col-lg-9'>
            <div id="messages">
                <div class='loading'>
                    <div class='loading-img'></div>
                    <div class='loading-username'></div>
                    <div class='loading-name'></div>
                    <div class='loading-bio'></div>
                </div>
                <div class='loading-messages'>
                    <div class="text-center d-flex flex-column justify-content-center align-items-center h-75" id='info'>
                        <i class='fa fa-info-circle'></i>
                        <h5>Click on the user from the right bar to view conversation and chat with them</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require '/app/includes/footer.php' ?>