<?php

    include "../db.inc.php";

    if(isset($_GET["postId"])) {
        $postId = mysqli_real_escape_string($conn, $_GET["postId"]);
        $userId = mysqli_real_escape_string($conn, $_GET["userId"]);
        $likes = '';

        // Get likes from post
        $like_sql = "SELECT likes FROM posts WHERE id=?";
        $stmt_l = mysqli_prepare($conn, $like_sql);
        mysqli_stmt_bind_param($stmt_l, "s", $postId);
        mysqli_stmt_execute($stmt_l);
        $result_l = mysqli_stmt_get_result($stmt_l);
        if($row_l = mysqli_fetch_assoc($result_l)) {
            $likes = $row_l['likes'] + 1;
        }

        // Decrement like for one on that post
        $user = "UPDATE posts SET likes=? WHERE id=?";
        $stmt_u = mysqli_prepare($conn, $user);
        mysqli_stmt_bind_param($stmt_u, "ii", $likes, $postId);
        mysqli_stmt_execute($stmt_u);

        $likes =  number_format((int) $likes, 0, '.', ',');

        // Who liked and what
        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $postId, $userId);
        mysqli_stmt_execute($stmt);
        if($stmt_u && $stmt && $stmt_l) {
            echo "
                <button class='card-btn like' id='liked' onclick='dislikePost($postId)'>
                    <div id='$postId'></div>
                    <i class='fa fa-thumbs-down'></i>
                    <span id='likes$postId'>$likes</span>
                </button>
            ";
        } else {
            echo mysqli_error($conn);
        }
    }

?>