<?php
    include "db.inc.php";
    include "googleButton.php";

    if(!sizeof($_SESSION)) {
        header("Location: /");
    }

    // Find if the email is already stored in database
    $userEmail = $_SESSION['userEmail'];
    $sql = "SELECT * FROM users WHERE email='$userEmail';";
    $run_user = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($run_user);
    // if not store him
    if($num == 0) {
        $first_name = $google_info->givenName;
        $last_name = $google_info->familyName;
        $username = explode('@', $google_info->email)[0];
        $email = $google_info->email;
        $pwd = $google_info->id;
        $describe_user = '';
        $coverPic = 'img/default.jpg';
        $profilePic = 'img/user.jpg';
        $register_date = date("d-m-Y H:i");
        $posts = "no";
        $following = 0;
        $followers = 0;
        
        $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, username, email, password, describe_user, profile_image, cover_image, register_date, posts, following, followers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssssii", $first_name, $last_name, $username, $email, $hashPwd, $describe_user, $profilePic, $coverPic, $register_date, $posts, $following, $followers);
        mysqli_stmt_execute($stmt);
    } else {
        // if yes log him
        if($row = mysqli_fetch_assoc($run_user)){
            $user_id = $row["id"];
            $user_name = $row["username"];

            $_SESSION["userName"] = $user_name;
            $_SESSION["userId"] = $user_id;
        }
    }

?>

<nav class='nav'>
    <div class='container-fluid nav-flex'>
        <div class="nav-header">
            <a href="/home">
                <img src='/img/pegas.png' logo="pegas" class='nav-header-logo'>
            </a>
        </div>
        <div class='nav-article'>
            <ul class='nav-article-content'>
                <li><a href='/profile/<?php echo $user_name; ?>' id='navName'><?php echo $user_name; ?></a></li>
                <li><a href='/home'>Home</a></li>
                <li><a href='/members'>Connect</a></li>
                <li><a href='/messages/<?php echo $user_name; ?>'>Messages</a></li>
                <li><a href='/edit/<?php echo $user_name ?>'>Edit Account</a></li>
                <li><a href='/logout'>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class='hamburger' onclick='openModal()'>
    <p>menu</p>
</div>

<div class="mobile-nav" id='mobileNav'>
    <div class='mobile-nav-close' onclick='closeModal()'>close</div>
    <div class="mobile-nav-header">
        <a href="/home">
            <img src='/img/pegas.png' logo="pegas" class='nav-header-logo'>
        </a>
    </div>
    <div class='mobile-nav-article'>
        <ul class='mobile-nav-article-content'>
            <a href='/profile/<?php echo $user_name; ?>' id='navName'>
                <li><?php echo $user_name; ?></li>
            </a>
            <a href='/home'>
                <li>Home</li>
            </a>
            <a href='/members'>
                <li>Connect</li>
            </a>
            <a href='/messages/<?php echo $user_name; ?>'>
                <li>Messages</li>
            </a>
            <a href='/edit/<?php echo $user_name ?>'>
                <li>Edit Account</li>
            </a>
            <a href='/logout'>
                <li>Logout</li>
            </a>
        </ul>
    </div>
</div>