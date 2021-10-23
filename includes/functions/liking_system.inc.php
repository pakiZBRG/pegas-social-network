<?php

    if(isset($_SESSION)){
        $userId = $_SESSION["userId"];
    } else {
        $userId = $_GET["userId"];
    }
    $likes = number_format((int) $likes, 0, '.', ',');
    $like_sql = "SELECT * FROM likes WHERE post_id=? AND user_id=?";
    $stmt_l = mysqli_prepare($conn, $like_sql);
    mysqli_stmt_bind_param($stmt_l, "ss", $post_id, $userId);
    mysqli_stmt_execute($stmt_l);
    mysqli_stmt_store_result($stmt_l);
    // if 1 it is liked by logger user, 0 is not liked
    $isLiked = mysqli_stmt_num_rows($stmt_l);
    if($loggedUser == $user_id) {
        if($likes == 1) {
            $text = "Like";
        } else {
            $text = "Likes";
        }
        $btn = "
            <button class='card-btn like' id='non-liked'>
                <span id='likes$post_id'>$likes</span>
                <span style='font-size: .8rem'>$text</span>
            </button>
        ";
    } else if($isLiked) {
        $btn = "
            <button class='card-btn like' id='liked' onclick='dislikePost($post_id)'>
                <div id='$post_id'></div>
                <i class='fa fa-thumbs-down'></i>
                <span id='likes$post_id'>$likes</span>
            </button>
        ";
    } else {
        $btn = "
            <button class='card-btn like' onclick='likePost($post_id)'>
                <div id='$post_id'></div>
                <i class='fa fa-thumbs-up'></i>
                <span id='likes$post_id'>$likes</span>
            </button>
        ";
    }

?>