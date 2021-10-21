<?php

    require realpath($_SERVER["DOCUMENT_ROOT"]) . "\\pegas\\includes\db.inc.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]) . "\\pegas\\includes\helpers\Messages.php";
    
    if(isset($_GET["post_id"])){
        $postId = mysqli_real_escape_string($conn, $_GET["post_id"]);
        $loggedUser = $_SESSION["userId"];

        // Get post data
        $sql = "SELECT * FROM posts WHERE id=?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $postId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            $post_id = $row["id"];
            $user_id = $row["user_id"];
            $content = $row["post_content"];
            $img = $row["upload_image"];
            $post_date = $row["post_date"];
            $formatDate = substr(date_format(date_create($post_date), DATE_RFC1123), 4, 18);
            $likes = $row["likes"];
            if($likes != 0){
                $likes = $row['likes'];
            } else {
                $likes = '';
            }

            // Get user data
            $sql = "SELECT * FROM users WHERE id=?;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $profile_img = $row["profile_image"];
                $user_name = $row["username"];
                $first_name = $row["first_name"];
                $last_name = $row["last_name"];
                $username = $_SESSION["userName"];
                if(isset($_SESSION)){
                    $userId = $_SESSION["userId"];
                } else {
                    $userId = $_GET["userId"];
                }

                // Get the total number of comments
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
                    <div class='row width-60'>
                        <div class='home-card'>
                            <div class='home-card-flex'>
                                <a href='/pegas/profile/$user_name' title='$first_name $last_name'>
                                    <img class='home-card-profile' src='/pegas/$profile_img' alt='$user_name'>
                                </a>
                                <div class='home-card-flex-user'>
                                    <h5><a href='/pegas/profile/$user_name' title='$first_name $last_name'>$user_name</a></h5>
                                    <h6><small>$formatDate</small></h6>
                                </div>
                            </div>
                            <p class='home-card-content'>$content</p>
                            <img class='home-card-full' id='myImg' src='/pegas/$img' alt=''>
                            <div id='myModal' class='modal'>
                                <img class='modal-content' id='imgModal'>
                            </div>
                            <div class='home-card-footer'>
                                <div id='like$post_id' class='card'>
                                    $btn
                                </div>
                                <a class='card' title='View comments'>
                                    <button class='card-btn cmt'>
                                        <i class='fa fa-comments'></i><span class='comNum'>$comNum</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class='col-md-12 p-2'>
                            <form method='POST' class='comment-form' id='commentForm'>
                                <input type='hidden' id='userId' value='$userId'>
                                <input type='hidden' id='username' value='$username'>
                                <input type='hidden' id='postId' value='$postId'>
                                <input type='text' placeholder='Type your comment...' id='comment' autocomplete='off'>
                                <button class='cmtBtn'>Post</button>
                            </form>
                        </div>
                        <div id='message'></div>
                    </div>
                ";
            }
        } else {
            echo "<p class='no_post'>No Post Found with id $postId</p>";
        }
    }

?>