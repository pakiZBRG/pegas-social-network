<?php

    include "../db.inc.php";

    if(isset($_GET)) {
        $userId = $_GET["userId"];
        $loggedUser = $_GET["loggedUser"];

        $user = "SELECT * FROM users WHERE id=$userId";
        $stmt = mysqli_prepare($conn, $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row_u = mysqli_fetch_assoc($result)) {
            $username = $row_u["username"];
            $first_name = $row_u["first_name"];
            $last_name = $row_u["last_name"];
            $profileImg = $row_u["profile_image"];
            $bio = $row_u["describe_user"];
            if(strlen($bio) > 80) {
                $bio = substr($bio, 0, 80)."...";
            } else if($bio == '') {
                $bio = '<span style="opacity: 0;">/</span>';
            }
            
            echo "
                <div class='follower-info'>
                    <img src='/$profileImg' alt='$first_name $last_name'>
                    <a href='/profile/$username'>$username</a>
                    <p>$first_name $last_name</p>
                    <small>$bio</small>
                </div>
            ";
        }

        echo "<div class='follower-table'>";
            echo "<div class='follower-messages' id='scrollTop'>";
            include "./load_messages.inc.php";
            echo "</div>";
            echo "
                <form method='POST' id='sendMsg'>
                    <input type='text' placeholder='Type message...' id='msg' class='send-message' autocomplete='off'>
                    <button onclick='sendMessage($userId, $loggedUser); return false' style='display: none'></button>
                </form>
            ";
        echo "</div>";

    }

?>