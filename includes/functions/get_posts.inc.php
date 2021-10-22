<?php

    require "/app/includes/db.inc.php";

    // Post data
    if(isset($_GET["limit"], $_GET["start"])){
        $start = $_GET["start"];
        $limit = $_GET["limit"];
        $loggedUser = $_GET["userId"];
        $sql = "SELECT * FROM posts ORDER BY 1 DESC LIMIT $start, $limit";
    } else {
        $sql = "SELECT * FROM posts ORDER BY 1 DESC LIMIT 0, 5";
        $loggedUser = $_SESSION["userId"];
    }
    $run = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($run)){
        $post_id = $row['id'];
        $user_id = $row['user_id'];
        $content = $row["post_content"];
        $upload_img = $row["upload_image"];
        $post_date = $row["post_date"];
        $formatDate = substr(date_format(date_create($post_date), DATE_RFC1123), 4, 18);
        $likes = $row["likes"];
        if($likes != 0){
            $likes = $row['likes'];
        } else {
            $likes = '';
        }

        // User data
        $user = "SELECT * FROM users WHERE id=?;";
        $stmt_u = mysqli_prepare($conn, $user);
        mysqli_stmt_bind_param($stmt_u, "s", $user_id);
        mysqli_stmt_execute($stmt_u);
        $result_u = mysqli_stmt_get_result($stmt_u);
        if($row_u = mysqli_fetch_array($result_u)) {
            $user_name = $row_u["username"];
            $user_img = $row_u["profile_image"];
            $first_name = $row_u["first_name"];
            $last_name = $row_u["last_name"];
        }

        // Number of comments
        $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $comNum = $rows['SUM'];
        if($comNum != 0){
            $comNum = $rows['SUM'];
        } else {
            $comNum = '';
        }
        $comNum =  number_format((int) $comNum, 0, '.', ',');

        include 'liking_system.inc.php';

        echo "
            <div class='home-card'>
                <div class='home-card-flex'>
                    <a href='/profile/$user_name' title='$first_name $last_name'>
                        <img class='home-card-profile' src='/$user_img' alt='profile'>
                    </a>
                    <div class='home-card-flex-user' id='tooltipPlace$post_id'>
                        <h5><a onmouseenter='displayTooltip($user_id, $post_id);' onmouseleave='removeTooltip($post_id);' href='/profile/$user_name' title='$first_name $last_name'>$user_name</a></h4>
                        <h6><small>$formatDate</small></h5>
                    </div>
                    <input type='hidden' id='postId' value='$post_id'>
                </div>
                ".($content ? "<p class='home-card-content'>$content</p>" : null)."
                ".($upload_img ? "
                    <a href='/post/$user_name/$post_id'>
                        <img class='home-card-img' src='/$upload_img' alt=''>
                    </a>" : null)."
                <div class='home-card-footer'>
                    <div id='like$post_id' class='card'>
                        $btn
                    </div>
                    <a class='card' href='/post/$user_name/$post_id' title='View comments'>
                        <button class='card-btn cmt'>
                            <i class='fa fa-comments'></i>
                            <span class='comNum' id='comNum'>
                                $comNum
                            </span>
                        </button>
                    </a>
                </div>
            </div>
        ";
    }
