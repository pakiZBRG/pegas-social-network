<?php

    if(isset($_GET["login"])){
        require "../db.inc.php";
        include "../helpers/Messages.php";
        
        $mailuid = mysqli_real_escape_string($conn, $_GET["mailuid"]);
        $password = mysqli_real_escape_string($conn, $_GET["pwd"]);

        if($mailuid == '' || $password == '') {
            warning('Fill in the fields');
        } else {
            $sql = "SELECT * FROM users WHERE username=? OR email=?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['password']);
                if($pwdCheck === false){
                    warning('Wrong credentials');
                }
                else if($pwdCheck === true){
                    session_start();
                    $_SESSION["userId"] = $row["id"];
                    $_SESSION["userName"] = $row["username"];
                    $_SESSION["userEmail"] = $row["email"];
                    header("Location: /home");
                }
                else {
                    warning('Wrong credentials');
                }
            }
            else {
                warning('User doesn\'t exist');
            }
        }
    }