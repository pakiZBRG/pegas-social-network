<?php

    include "../db.inc.php";

    if($_POST["comment"]){
        $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
        $userId = mysqli_real_escape_string($conn, $_POST["userId"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $postId = mysqli_real_escape_string($conn, $_POST["postId"]);
        $date = date("d-m-Y H:i");

        $sql = "INSERT INTO comments (post_id, user_id, comment, author, date) VALUES(?, ?, ?, ?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $postId, $userId, $comment, $username, $date);
        mysqli_stmt_execute($stmt);
        if(!$stmt){
            error(mysqli_error($conn));
        }
    }

?>