<?php

    if(isset($_GET["signup"])){
        require "../db.inc.php";
        include "../helpers/Messages.php";

        $first_name = mysqli_real_escape_string($conn, $_GET["fname"]);
        $last_name = mysqli_real_escape_string($conn, $_GET["lname"]);
        $email = mysqli_real_escape_string($conn, $_GET["email"]);
        $username = mysqli_real_escape_string($conn, $_GET["uname"]);
        $pwd = mysqli_real_escape_string($conn, $_GET["pwd"]);
        $pwdRepeat = mysqli_real_escape_string($conn, $_GET["pwd_repeat"]);
        $posts = "no";
        $describe_user = '';
        $register_date = date("d-m-Y H:i");
        $coverPic = 'img/default.jpg';
        $profilePic = 'img/user.jpg';
        $following = 0;
        $followers = 0;

        if($first_name == '' || $last_name == '' || $email == '' || $username == '' || $pwd == '' || $pwdRepeat == ""){
            warning('Fill in all the field');
        } else if (strlen($pwd) < 8){
            warning('Password needs to have at least 8 characters');
        } else if (strlen($username) < 4){
            warning('Username needs to have at least 4 characters');
        } else if ($pwd !== $pwdRepeat){
            warning('Passwords do not match');
        } else {
            // if the username is taken
            $sqlUsername = "SELECT username FROM users WHERE username=?;";
            $stmtUsername = mysqli_prepare($conn, $sqlUsername);
            mysqli_stmt_bind_param($stmtUsername, "s", $username);
            mysqli_stmt_execute($stmtUsername);
            mysqli_stmt_store_result($stmtUsername);
            $numRow = mysqli_stmt_num_rows($stmtUsername);
            if($numRow > 0){
                warning('Username taken');
            } else {
                //if the email is taken
                $sqlEmail = "SELECT email FROM users WHERE email=?;";
                $stmtEmail = mysqli_prepare($conn, $sqlEmail);
                mysqli_stmt_bind_param($stmtEmail, "s", $email);
                mysqli_stmt_execute($stmtEmail);
                mysqli_stmt_store_result($stmtEmail);
                $numRow = mysqli_stmt_num_rows($stmtEmail);
                if($numRow > 0){
                    warning('Email taken');
                } else {
                    $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (first_name, last_name, username, email, password, describe_user, profile_image, cover_image, register_date, posts, following, followers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ssssssssssii", $first_name, $last_name, $username, $email, $hashPwd, $describe_user, $profilePic, $coverPic, $register_date, $posts, $following, $followers);
                    mysqli_stmt_execute($stmt);
                    if($stmt){
                        success('Signup success');
                    } else {
                        error('SQL error: '.mysqli_error($conn));
                    }
                }
            }
        }
    }
