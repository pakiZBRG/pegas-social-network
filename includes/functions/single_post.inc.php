<?php

    require realpath($_SERVER["DOCUMENT_ROOT"]) . "\\includes\db.inc.php";

    if(array_key_exists("userEmail", $_GET)){
        $userEmail = mysqli_real_escape_string($conn, $_GET["userEmail"]);
        $sql = "SELECT * FROM users WHERE email=? ORDER BY id DESC;";
        $stmt_a = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_a, "s", $userEmail);
        mysqli_stmt_execute($stmt_a);
        $result = mysqli_stmt_get_result($stmt_a);
        if($row = mysqli_fetch_assoc($result)) {
            $userId = $row["id"];
            $sql = "SELECT * FROM posts WHERE user_id=? ORDER BY id DESC;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $userId);
        }
    } else if(array_key_exists("search", $_GET)){
        $userEmail = '';
        $search = mysqli_real_escape_string($conn, $_GET["search"]);
        $search = "$search%";

        $sql = "SELECT * FROM posts WHERE post_content LIKE ? ORDER BY id DESC;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $search);
    } else {
        $sql = "SELECT * FROM users WHERE email=? ORDER BY id DESC;";
        $stmt_a = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_a, "s", $userEmail);
        mysqli_stmt_execute($stmt_a);
        $result = mysqli_stmt_get_result($stmt_a);
        if($row = mysqli_fetch_assoc($result)) {
            $userId = $row["id"];
            $sql = "SELECT * FROM posts WHERE user_id=? ORDER BY id DESC;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $userId);
        }
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $num = mysqli_num_rows($result);
    if($num == 0) {
        echo "<p class='no_post mx-auto my-3'>No post found</p>";
    } else {
        echo "<p class='no_post mx-auto my-3'>$num post found</p>";
    }
    while($row = mysqli_fetch_assoc($result)){
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

        $sql_user = "SELECT * FROM users WHERE id=$user_id";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);
        if($row_user = mysqli_fetch_assoc($result_user)){
            $first_name = $row_user["first_name"];
            $last_name = $row_user["last_name"];
            $user_name = $row_user['username'];
            $user_email = $row_user['email'];
            $profile_image = $row_user["profile_image"];
        }

        $sql = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
        $num = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($num);
        $comNum = $rows['SUM'];
        if($comNum != 0){
            $comNum = $rows['SUM'];
        } else {
            $comNum = '';
        }
        $comNum =  number_format((int) $comNum, 0, '.', ',');

        if(isset($_SESSION["userId"])) {
            $loggedUser = $_SESSION["userId"];
        } else {
            $loggedUser = $_GET["userId"];
        }

        include 'liking_system.inc.php';

        if($user_id == $userId) {
            $edit = "
                <div class='home-card-icons'>
                    <a href='/profile/$user_name/$post_id/edit'>
                        <button class='action edit'><i class='fa fa-pencil'></i>
                        </button>
                    <a>
                    <span onclick='deletePost($post_id, ".'"'.$user_email.'"'.", $loggedUser);'>
                        <button class='action delete'><i class='fa fa-trash'></i></button>
                    </span>
                </div>
            ";
        } else {
            $edit = '';
        }

        echo "
            <div class='home-card'>
                $edit
                <div class='home-card-flex'>
                    <a href='/profile/$user_name' title='$first_name $last_name'>
                        <img class='home-card-profile' src='/$profile_image' alt='$user_name' width='100px' height='100px'>
                    </a>
                    <div class='home-card-flex-user'>
                        <h5><a href='/profile/$user_name'>$user_name</a></h5>
                        <h6><small>$formatDate</small></h6>
                    </div>
                </div>
                ".($content ? "<p class='home-card-content'>$content</p>" : null)."
                ".($upload_img ? "<a href='/post/$user_name/$post_id'><img class='home-card-img' src='/$upload_img' alt=''></a>" : null)."
                <div class='home-card-footer'>
                    <div id='like$post_id' class='card'>
                        $btn
                    </div>
                    <a class='card' href='/post/$user_name/$post_id' title='View comments'>
                        <button class='card-btn cmt'>
                            <i class='fa fa-comments'></i><span class='comNum'>$comNum</span>
                        </button>
                    </a>
                </div>
            </div>
        ";
    }
    
?>