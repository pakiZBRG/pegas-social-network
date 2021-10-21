<?php 

    include './includes/header.php';
    include './includes/nav.php';
    include "./includes/db.inc.php";

    $userName = $_GET["username"];
    $loggedUser = $_SESSION["userId"];

    $sql = "SELECT * FROM users WHERE username='$userName'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_array($result)) {
        $user_id = $row["id"];
        $cover_image = $row["cover_image"];
        $profile_image = $row["profile_image"];
        $user_name = $row["username"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $describe_user = $row["describe_user"];
        $register_date = $row["register_date"];
        $following = $row["following"];
        $followers = $row["followers"];
        $formatDate = substr(date_format(date_create($register_date), DATE_RFC1123), 4, 18);
        $changeCover = '';
        $changeProfile = '';
        $follow = '';
        $follower = '';
    }

    // Get followers
    $sql2 = "SELECT * FROM followers WHERE follower=? AND followed=?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "ii", $loggedUser, $user_id);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    if($row2 = mysqli_fetch_array($result2)) {
        $follower = $row2["follower"];
    }

    // If you are following, print unfollow
    if($loggedUser == $follower) {
        $follow = "
            <div class='following'>
                <p>Following</p>
                <p id='following'>$following</p>
            </div>
            <div class='followers'>
                <p>Followers</p>
                <p id='followers'>$followers</p>
            </div>
            <div class='add-follow invert' onclick='unfollow(); return false;'>
                <span><i class='fa fa-check'></i> Following</span>
                <small>unfollow</small>
            </div>
        ";
    } else {
        $follow = "
            <div class='following'>
                <p>Following</p>
                <p id='following'>$following</p>
            </div>
            <div class='followers'>
                <p>Followers</p>
                <p id='followers'>$followers</p>
            </div>
            <div class='add-follow' onclick='follow(); return false;'>
                <span><i class='fa fa-user-plus'></i> Follow</span>
            </div>
            <div class='send'>
                <span><i class='fa fa-envelope'></i> Messages</span>
            </div>
        ";
    }

    if($user_id == $loggedUser) {
        $changeCover = "
            <form method='POST' enctype='multipart/form-data' class='cover-form' id='coverForm'>
                <label class='btn btn-danger'>Change Cover
                    <input type='file' name='u_cover'>
                    <input type='hidden' value='$user_id' name='userId'>
                </label>
            </form>
        ";
        $changeProfile = "
            <form method='POST' enctype='multipart/form-data' class='profile-form' id='profileForm'>
                <label class='btn btn-danger'>Change Profile
                    <input type='file' name='u_profile'>
                    <input type='hidden' value='$user_id' name='userId'>
                </label>
            </form>
        ";
        $follow = "
            <div class='following'>
                <p>Following</p>
                <p id='following'>$following</p>
            </div>
            <div class='followers'>
                <p>Followers</p>
                <p id='followers'>$followers</p>
            </div>
        ";
    }
    
?>
    <div class="row width-80">
        <div class='col-lg-12 p-0'>
            <?php
                echo "
                    <div class='cover'>
                        <img id='cover' src='/pegas/$cover_image' alt='cover-img'>
                        $changeCover
                    </div>
                    <div class='profile'>
                        <img id='profile' src='/pegas/$profile_image' alt='profile-img' height='200px' width='200px'>
                        $changeProfile
                    </div>
                ";
            ?>
        </div>
    </div>
    <div class='row width-80'>
        <div class="col-lg-3 p-0">
            <?php
                echo "
                    <div class='about'>
                        <h2 class='pb-1'><strong>About</strong></h2>
                        <h5><span>Username:</span> $user_name</h5>
                        <h5><span>Name:</span> $first_name $last_name</h5>
                        <span>Bio:</span><p class='about-text'> $describe_user</p>
                        <p><span>Member since:</span> $formatDate</p>
                    </div>
                ";
            ?>
        </div>
        <div class='col-lg-9'>
            <div class="row width-80">
                <input type='hidden' value='<?php echo $user_id ?>' id='followed'>
                <input type='hidden' value='<?php echo $loggedUser ?>' id='follower'>
                <div class="follow" id='follow'>
                    <?php echo $follow; ?>
                </div>
                <input type="hidden" id="userId" value="<?php echo $loggedUser; ?>">
                <div id="feeds" class="row mx-auto" style='width: 100%'>
                    <?php include "./includes/functions/single_post.inc.php" ?>
                </div>
            </div>
        </div>
    </div>
<?php include "./includes/footer.php" ?>