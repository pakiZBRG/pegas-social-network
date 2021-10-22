<?php

    include "../db.inc.php";
    include "../helpers/Messages.php";

    if(isset($_POST)){
        $follower = mysqli_real_escape_string($conn, $_POST["follower"]);
        $followed = mysqli_real_escape_string($conn, $_POST["followed"]);

        // Get follow from follower
        $sql3 = "SELECT * FROM users WHERE id=?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $follower);
        mysqli_stmt_execute($stmt3);
        $result = mysqli_stmt_get_result($stmt3);
        if($row = mysqli_fetch_assoc($result)){
            $following1 = $row["following"];
            $followers1 = $row["followers"];
        }

        // Get follow from followed
        $sql4 = "SELECT * FROM users WHERE id=?";
        $stmt4 = mysqli_prepare($conn, $sql4);
        mysqli_stmt_bind_param($stmt4, "i", $followed);
        mysqli_stmt_execute($stmt4);
        $result = mysqli_stmt_get_result($stmt4);
        if($row = mysqli_fetch_assoc($result)){
            $following2 = $row["following"];
            $followers2 = $row["followers"];
        }

        // echo "Follower: <br>$following1 following <br> $followers1 followers";
        // echo "<br>Followed: <br>$following2 following <br> $followers2 followers";

        //Insert into table who followed who
        $sql = "INSERT INTO followers (follower, followed) VALUES (?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $follower, $followed);
        mysqli_stmt_execute($stmt);

        // Increment following for followed
        $following1 = (int) $following1 + 1;
        $update = "UPDATE users SET following=? WHERE id=?;";
        $stmt1 = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt1, "ii", $following1, $follower);
        mysqli_stmt_execute($stmt1);

        // Increment followers for follower
        $followers2 = (int) $followers2 + 1;
        $update2 = "UPDATE users SET followers=? WHERE id=?;";
        $stmt2 = mysqli_prepare($conn, $update2);
        mysqli_stmt_bind_param($stmt2, "ii", $followers2, $followed);
        mysqli_stmt_execute($stmt2);

        if($stmt && $stmt1 && $stmt2) {
            echo "
                <div class='following'>
                    <p>Following</p>
                    <p id='following'>$following2</p>
                </div>
                <div class='followers'>
                    <p>Followers</p>
                    <p id='followers'>$followers2</p>
                </div>
                <div class='add-follow invert' onclick='unfollow(); return false;'>
                    <span><i class='fa fa-check'></i> Following</span>
                    <small>unfollow</small>
                </div>
            ";
        } else {
            error(mysqli_error($conn));
        }
    }

?>