<?php

    require "../db.inc.php";

    if(isset($_POST["userId"])) {
        $userId = $_POST["userId"];
        // Delete user messages
        $delete_messages = "DELETE FROM messages WHERE sender=$userId OR reciever=$userId";
        $stmt_msg = mysqli_prepare($conn, $delete_messages);
        mysqli_stmt_execute($stmt_msg);

        // Delete multiple post image from /assets folder
        $query = "SELECT upload_image FROM posts WHERE user_id=$userId;";
        $img_result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($img_result)) {
            $filename = $row["upload_image"];
            if($filename) {
                $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$filename";
                if (file_exists($deleteimg)) {
                    unlink($deleteimg);
                }
            }
        }

        // Delete user posts
        $delete_posts = "DELETE FROM posts WHERE user_id=$userId";
        $stmt_posts = mysqli_prepare($conn, $delete_posts);
        mysqli_stmt_execute($stmt_posts);

        // Delete user comments
        $delete_cmnt = "DELETE FROM comments WHERE user_id=$userId";
        $stmt_cmnt = mysqli_prepare($conn, $delete_cmnt);
        mysqli_stmt_execute($stmt_cmnt);

        // Decrement all users followers if the follower was deleted user
        $select_foll = "SELECT followed FROM followers WHERE follower=$userId";
        $stmt_foll = mysqli_prepare($conn, $select_foll);
        mysqli_stmt_execute($stmt_foll);
        $result = mysqli_stmt_get_result($stmt_foll);
        while($row = mysqli_fetch_assoc($result)) {
            $followed = $row["followed"];
            $get_foll = "SELECT * FROM users WHERE id=$followed";
            $stmt_get = mysqli_prepare($conn, $get_foll);
            mysqli_stmt_execute($stmt_get);
            $result_get = mysqli_stmt_get_result($stmt_get);
            while($row_get = mysqli_fetch_assoc($result_get)) {
                $followers = $row_get["followers"] - 1;
                // Decremnt following for followed user
                $update_foll = "UPDATE users SET followers=$followers WHERE id=$followed";
                $stmt_upd = mysqli_prepare($conn, $update_foll);
                mysqli_stmt_execute($stmt_upd);
            }
        }

        // Decrement all users following if the followed was deleted user
        $select_foll = "SELECT follower FROM followers WHERE followed=$userId";
        $stmt_foll = mysqli_prepare($conn, $select_foll);
        mysqli_stmt_execute($stmt_foll);
        $result = mysqli_stmt_get_result($stmt_foll);
        while($row = mysqli_fetch_assoc($result)) {
            $follower = $row["follower"];
            $get_foll = "SELECT * FROM users WHERE id=$follower";
            $stmt_get = mysqli_prepare($conn, $get_foll);
            mysqli_stmt_execute($stmt_get);
            $result_get = mysqli_stmt_get_result($stmt_get);
            while($row_get = mysqli_fetch_assoc($result_get)) {
                $following = $row_get["following"] - 1;
                // Decremnt following for followed user
                $update_foll = "UPDATE users SET following=$following WHERE id=$follower";
                $stmt_upd = mysqli_prepare($conn, $update_foll);
                mysqli_stmt_execute($stmt_upd);
            }
        }

        // Delete user followers
        $delete_foll = "DELETE FROM followers WHERE follower=$userId OR followed=$userId";
        $stmt_foll = mysqli_prepare($conn, $delete_foll);
        mysqli_stmt_execute($stmt_foll);

        // Decrement likes for all posts which deleted user liked
        $select_posts = "SELECT post_id FROM likes WHERE user_id=$userId";
        $stmt_posts = mysqli_prepare($conn, $select_posts);
        mysqli_stmt_execute($stmt_posts);
        $result = mysqli_stmt_get_result($stmt_posts);
        while($row = mysqli_fetch_assoc($result)) {
            $postId = $row["post_id"];
            $get_likes = "SELECT likes FROM posts WHERE id=$postId";
            $stmt_likes = mysqli_prepare($conn, $get_likes);
            mysqli_stmt_execute($stmt_likes);
            $result_get = mysqli_stmt_get_result($stmt_likes);
            while($row_get = mysqli_fetch_assoc($result_get)) {
                $likes = $row_get["likes"] - 1;
                // Decremnt following for followed user
                $update_likes = "UPDATE posts SET likes=$likes WHERE id=$postId";
                $stmt_upd = mysqli_prepare($conn, $update_likes);
                mysqli_stmt_execute($stmt_upd);
            }
        }

        // Delete user likes
        $delete_like = "DELETE FROM likes WHERE user_id=$userId";
        $stmt_like = mysqli_prepare($conn, $delete_like);
        mysqli_stmt_execute($stmt_like);

        // Delete cover image, if changed, in /assets
        $query = "SELECT profile_image FROM users WHERE id=$userId;";
        $img_result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($img_result)) {
            $filename = $row["profile_image"];
            if($filename != 'img/user.jpg') {
                $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$filename";
                if (file_exists($deleteimg)) {
                    unlink($deleteimg);
                }
            }
        }

        // Delete profile image, if changed, in /assets
        $query = "SELECT cover_image FROM users WHERE id=$userId;";
        $img_result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($img_result)) {
            $filename = $row["cover_image"];
            if($filename != 'img/default.jpg') {
                $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/$filename";
                if (file_exists($deleteimg)) {
                    unlink($deleteimg);
                }
            }
        }

        // Delete user
        $delete_user = "DELETE FROM users WHERE id=$userId";
        $stmt_user = mysqli_prepare($conn, $delete_user);
        mysqli_stmt_execute($stmt_user);

        session_start();
        session_unset();
        session_destroy();

        header("Location: /");
    }

?>