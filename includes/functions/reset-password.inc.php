<?php

    require "../db.inc.php";
    include "../helpers/Messages.php";

    if(isset($_GET['resetPassword'])){
        $selector = mysqli_real_escape_string($conn, $_GET['selector']);
        $validator = mysqli_real_escape_string($conn, $_GET['validator']);
        $password = mysqli_real_escape_string($conn, $_GET['pwd']);
        $passwordRepeat = mysqli_real_escape_string($conn, $_GET['pwdRepeat']);

        if(empty($password) || empty($passwordRepeat)){
            warning('Enter and confirm the password');
        } else if(strlen($password) < 8){
            warning('Password should be at leat 8 characters long');
        } else if($password != $passwordRepeat){
            warning('Password do not match');
        } else {
            // Get email from token
            $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $selector);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $tokenEmail = $row["pwdResetEmail"];
                // Update password
                $sql = "UPDATE users SET password=? WHERE email=?";
                $stmt = mysqli_prepare($conn, $sql);
                $hashPwd = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $hashPwd, $tokenEmail);
                mysqli_stmt_execute($stmt);
    
                // Delete reset password token
                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
    
                if($stmt) {
                    success('Password successfully updated');
                } else {
                    error('SQL error: '.mysqli_error($conn));
                }
            }
        }
    }

?>