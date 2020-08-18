<?php

if(isset($_POST["login"])){
    require "includes/database.inc.php";
    
    $mailuid = $_POST["mailuid"];
    $password = $_POST["pwd"];

    $sql = "SELECT * FROM users WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: index.php?error=sql_error");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            $pwdCheck = password_verify($password, $row['password']);
            if($pwdCheck === false){
                header("Location: index.php?error=wrong_password");
                exit();
            }
            else if($pwdCheck === true){
                session_start();
                // if(isset($_SESSION['userId'])){
                //     header("Location: home.php");
                // }
                $_SESSION["userId"] = $row["id"];
                $_SESSION["userName"] = $row["username"];
                header("Location: home.php");
                exit();
            }
            else {
                header("Location: index.php?error=wrong_password");
                exit();
            }
        }
        else {
            header("Location: index.php?error=no_user");
            exit();
        }
    }
}