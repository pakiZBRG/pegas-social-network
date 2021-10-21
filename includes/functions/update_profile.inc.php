<?php

    include "../db.inc.php";
    include "../helpers/Messages.php";

    if(isset($_POST)){
        $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
        $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
        $userName = mysqli_real_escape_string($conn, $_POST["userName"]);
        $describeUser = mysqli_real_escape_string($conn, $_POST["describeUser"]);
        $userId = mysqli_real_escape_string($conn, $_POST["userId"]);

        if($firstName == '' || $lastName == '' || $userName == ''){
            warning("Fill in the fields");
        } else {
            $get_username = "SELECT username FROM users WHERE id=$userId";
            $stmt = mysqli_prepare($conn, $get_username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)) {
                $original_username = $row["username"];
                // if username is unchanged
                if($original_username == $userName) {
                    $sql = "UPDATE users SET first_name=?, last_name=?, username=?, describe_user=? WHERE id=?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $userName, $describeUser, $userId);
                    mysqli_stmt_execute($stmt);
                    if($stmt) {
                        success("User successfully updated");
                        echo $original_username;
                    } else {
                        error(mysqli_error($conn));
                    }
                } else {
                    $get_username = "SELECT * FROM users WHERE username='$userName'";
                    $stmt = mysqli_prepare($conn, $get_username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $num = mysqli_num_rows($result);
                    if($num == 1) {
                        warning("Username already exists. Take another one");
                    } else {
                        $sql = "UPDATE users SET first_name=?, last_name=?, username=?, describe_user=? WHERE id=?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $userName, $describeUser, $userId);
                        mysqli_stmt_execute($stmt);
                        if($stmt) {
                            success("User successfully updated");
                            echo $userName;
                        } else {
                            error(mysqli_error($conn));
                        }
                    }
                }
            }
        }
    }

?>