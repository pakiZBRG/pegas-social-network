<?php


if(isset($_POST["signup"])){
    require "includes/database.inc.php";

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwd-repeat"];
    $status = "verified";
    $posts = "no";
    $profilePic = 'users/user.jpg';
    $coverPic = 'cover/cover-default.jpg';

    if(strlen($pwd) < 8){
        header("Location: signup.php?error=pwd_min_8_char");
        exit();
    }

    if(strlen($username) < 4){
        header("Location: signup.php?error=user_min_4_char");
        exit();
    }

    else if($pwd !== $pwdRepeat){
        header("Location: signup.php?error=password_check");
        exit();
    }
    

    // if the username is taken
    $sqlUsername = "SELECT username FROM users WHERE username='$username';";
    $run_sql = mysqli_query($conn, $sqlUsername);
    $result = mysqli_num_rows($run_sql);
    if($result > 0){
        header("Location: signup.php?error=username_taken");
        exit();
    }

    $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name,last_name, username, email, password, describe_user, profile_image, cover_image, register_date, status, posts, recovery_account) VALUES('$first_name', '$last_name', '$username', '$email', '$hashPwd', '', '$profilePic', '$coverPic', NOW(), '$status' ,'$posts' ,'pakiZBRG')";
    $query = mysqli_query($conn, $sql);

    if($query){
        header("Location: signup.php?signup=success");
        exit();
    }
    else {
        header("Location: signup.php?error=sql_error");
        exit();
    }
}
