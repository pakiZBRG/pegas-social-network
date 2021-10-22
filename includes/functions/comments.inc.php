<?php

    require realpath($_SERVER["DOCUMENT_ROOT"]) . "/includes/db.inc.php";

    $postId = mysqli_real_escape_string($conn, $_GET["post_id"]);
    $sql = "SELECT * FROM comments WHERE post_id=? ORDER BY 1 DESC;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $com_id = $row["id"];
        $user_id = $row["user_id"];
        $com = $row['comment'];
        $post_id = $row["post_id"];
        $name = $row['author'];
        $date = $row['date'];
        $formatDate = substr(date_format(date_create($date), DATE_RFC1123), 4, 18);

        $sql = "SELECT * FROM users WHERE id=$user_id;";
        $run = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($run);
        $img = $row["profile_image"];
        $user_name = $row["username"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];

        if(isset($_SESSION)){
            $username = $_SESSION["userName"];
        } else {
            $username = $_GET["username"];
        }
        if ($user_name === $username){
            $delete = "
                <span onclick='deleteComment($com_id); return false;' class='comment-delete' title='Delete comment'>
                    <input type='hidden' value='$com_id' id='$com_id'/>
                    <input type='hidden' value='$user_name' id='username'/>
                    <p>Delete</p>
                </span>
            ";
        } else {
            $delete = '';
        }

        echo "
            <div class='row width-50'>
                <div class='col-md-12 comment'>
                    $delete
                    <div class='comment-info'>
                        <img class='comment-profile' src='/$img' alt='$username'>
                        <div class='comment-info-user'>
                            <a href='/profile/$user_name' title='$first_name $last_name'>$user_name</a>
                            <p>$formatDate</p>
                        </div>
                    </div>
                    <p class='comment-content'>$com</p>
                </div>
            </div>
        ";
    }