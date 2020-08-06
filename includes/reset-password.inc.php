<?php

    if(isset($_POST['reset-password-submit'])){
        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        $password = $_POST['pwd'];
        $passwordRepeat = $_POST['pwd-repeat'];

        if(empty($password) || empty($passwordRepeat)){
            header("Location: ./create-new-password.php?selector=$selector&validator=$validator&newpwd=empty");
            exit();
        }
        else if(strlen($password) < 9){
            header("Location: ./create-new-password.php?selector=$selector&validator=$validator&newpwd=min_8_char");
            exit();
        }
        else if($password != $passwordRepeat){
            header("Location: ./create-new-password.php?selector=$selector&validator=$validator&newpwd=not_same");
            exit();
        }

        $currentDate = date("U");
        require "database.inc.php";

        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "There was an error on our side. Try again later!";
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                echo "You need to re-submit your reset request";
                exit();
            }
            else{
                $token = hex2bin($validator);
                $tokenCheck = password_verify($token, $row["pwdResetToken"]);

                if($tokenCheck === false){
                    echo "You need to re-submit your reset request";
                    exit();
                }
                else if($tokenCheck === true){
                    $tokenEmail = $row["pwdResetEmail"];
                    $sql = "SELECT * FROM users WHERE email=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "There was an error on our side. Try again later!";
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if(!$row = mysqli_fetch_assoc($result)){
                            echo "There was an error!";
                            exit();
                        }
                        else{
                            $sql = "UPDATE users SET password=? WHERE email=?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "There was an error on our side. Try again later!";
                                exit();
                            }
                            else {
                                $hashPwd = password_hash($password, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $hashPwd, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    echo "There was an error on our side. Try again later!";
                                    exit();
                                }
                                else {
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../index.php?newpwd=pass_updated");
                                }
                            }
                        }
                    }
                }
            }
        }

    }
    else {
        header("Location: ../index.php");
    }

?>