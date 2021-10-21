<?php

    // liking system
    $like_sql = "SELECT * FROM likes WHERE post_id=?";
    $stmt_l = mysqli_prepare($conn, $like_sql);
    mysqli_stmt_bind_param($stmt_l, "s", $post_id);
    mysqli_stmt_execute($stmt_l);
    $result_l = mysqli_stmt_get_result($stmt_l);
    if($row_l = mysqli_fetch_array($result_l)){
        $likedUser = $row_l["user_id"];
        $likedPost = $row_l["post_id"];
    } else {
        $likedUser = '';
        $likedPost = '';
    }

    $likes = number_format((int) $likes, 0, '.', ',');
    
    // If the post is like by logged User and what post    
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
    } else if($likedPost == $post_id) {
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