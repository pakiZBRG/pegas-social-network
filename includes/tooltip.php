<?php

    include "./db.inc.php";

    if(isset($_GET["userId"])) {
        $userId = $_GET["userId"];

        $sql = "SELECT * FROM users WHERE id=$userId";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $username = $row["username"];
            $profileImg = $row["profile_image"];
            $coverImg = $row["cover_image"];
            $following = $row["following"];
            $followers = $row["followers"];

            echo "
                <div class='user-tooltip'>
                    <img class='user-tooltip-cover' src='$coverImg'>
                    <img class='user-tooltip-profile' src='$profileImg'>
                    <div class='user-tooltip-content'>
                        <p>$first_name $last_name</p>
                        <p style='opacity: .6'>$username</p>
                    </div>
                    <div class='user-tooltip-flex'>
                        <h5>$followers <small>followers</small></h5>
                        <h5>$following <small>following</small></h5>
                    </div>
                </div>
            ";
        }
    }

?>