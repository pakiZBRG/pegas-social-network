<?php

include "database.inc.php";

function insertPost(){
    global $conn, $user_id;
    if(isset($_POST["sub"])){
        $content = $_POST["content"];
        $file = $_FILES["upload_img"];
    
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        $fileType = $file["type"];
        global $fileNewName;
        $fileExt = explode(".", $fileName);
        $fileAcutalExt = strtolower(end($fileExt));
    
        $allowed = array('jpg', 'jpeg', 'png', 'svg', 'webp');
    
        if(in_array($fileAcutalExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 3000000){
                    $fileNewName = uniqid("", true).".".$fileAcutalExt;
                    
                    $fileDestination = "image-post/".$fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sql = "INSERT INTO posts (user_id, post_content, upload_image, post_date) VALUES ('$user_id', '$content', '$fileNewName', NOW());";
                    $run = mysqli_query($conn, $sql);

                    if($run){
                        header("Location: ./home.php?upload=success");
                        $sql = "UPDATE users SET posts='yes' WHERE id='$user_id';";
                        $run = mysqli_query($conn, $sql);
                    }

                    exit();
                }
                else {
                    echo "The file is to big, upto 3MB!";
                }
            }
            else {
                echo "There was an error!";
            }
        }
        else if($content){
            $sql = "INSERT INTO posts (user_id, post_content, upload_image, post_date) VALUES ('$user_id', '$content', '$fileNewName', NOW());";
            $run = mysqli_query($conn, $sql);

            if($run){
                header("Location: ./home.php?upload=success");
                $sql = "UPDATE users SET posts='yes' WHERE id='$user_id';";
                $run = mysqli_query($conn, $sql);
            }
        }
        else {
            echo "Unrecognizable type. Allowed types: jpg, jpeg, png, svg, webp";
        }

        if($fileName == '' && $content == ''){
            header("Location: ./home.php?upload=failed");
            echo "Fields are empty. Try again!";
            exit();
        }
    }
}

function get_posts(){
    global $conn;
                    
    $sql = "SELECT * FROM posts ORDER BY 1 DESC;";
    $run = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($run)){
        $post_id = $row['post_id'];
        $user_id = $row['user_id'];
        $content = $row["post_content"];
        $upload_img = $row["upload_image"];
        $post_date = substr($row["post_date"], 0, 16);

        $user = "SELECT * FROM users WHERE id='$user_id';";
        $run_u = mysqli_query($conn, $user);
        $row_u = mysqli_fetch_array($run_u);

        $user_name = $row_u["username"];
        $user_img = $row_u["profile_image"];
        $first_name = $row_u["first_name"];
        $last_name = $row_u["last_name"];

        $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $comNum = $rows['SUM'];

        echo "
            <div class='row width-80'>
                <div class='home-card'>
                    <div class='home-card-icons'>
                        <a href='single.php?post_id=$post_id&username=$user_name' title='View'>
                            <button class='btn btn-primary' style='border-radius: 0'><i class='fa fa-eye'></i>
                            </button>
                        <a>
                    </div>
                    <div class='home-card-flex'>
                        <img class='home-card-profile' src='$user_img' alt='profile'>
                        <div class='home-card-flex-user'>
                            <h4><a href='./user_profile.php?u_id=$user_id&username=$user_name' title='$first_name $last_name'>$user_name</a></h4>
                            <h5><small>Posted on: $post_date</small></h5>
                        </div>
                    </div>
                    <p class='home-card-content'>$content</p>
                    ".($upload_img ? "<img class='home-card-img' src='./image-post/$upload_img' alt=''>" : null)."
                    <a href='single.php?post_id=$post_id&username=$user_name' title='View comments'>
                        <button class='btn btn-warning w-100' style='border-radius: 0px;'>Comment<span class='comNum'>$comNum</span></button>
                    </a>
                </div>
            </div>
        ";
    }  
}

function single_post(){
    if(isset($_GET["post_id"])){
        global $conn, $post_id;
        
        $get_id = $_GET["post_id"];

        $sql = "SELECT * FROM posts WHERE post_id=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: single.php?error=sql_error");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $get_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $post_id = $row["post_id"];
                $user_id = $row["user_id"];
                $content = $row["post_content"];
                $img = $row["upload_image"];
                $post_date = substr($row["post_date"], 0, 16);

                $sql = "SELECT * FROM users WHERE id=?;";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: single.php?error=sql_error");
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "s", $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        $profile_img = $row["profile_image"];
                        $user_name = $row["username"];
                        $first_name = $row["first_name"];
                        $last_name = $row["last_name"];
                        $username = $_SESSION["userName"];
                        $userId = $_SESSION["userId"];

                        if($get_id != $post_id){
                            header("Location: profile.php?u_id=$user_id&username=$user_name&view=error");
                        }
                        else {
                            $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
                            $result = mysqli_query($conn, $query);
                            $rows = mysqli_fetch_assoc($result);
                            $comNum = $rows['SUM'];
                            
                            echo "
                                <div class='row width-60'>
                                    <div class='home-card'>
                                        <div class='home-card-flex'>
                                            <img class='home-card-profile' src='$profile_img' alt='profile'>
                                            <div class='home-card-flex-user'>
                                                <h4><a href='user_profile.php?u_id=$user_id&username=$user_name' title='$first_name $last_name'>$user_name</a></h4>
                                                <h5><small>Posted on: $post_date</small></h5>
                                            </div>
                                        </div>
                                        <p class='home-card-content'>$content</p>
                                        <img class='home-card-full' id='myImg' src='./image-post/$img' alt=''>
                                        <div id='myModal' class='modal'>
                                            <span class='close'>&times;</span>
                                            <img class='modal-content' id='imgModal'>
                                        </div>
                                        <button class='btn btn-warning w-100' style='border-radius: 0px; position: relative;'>Comments<span class='comNum'>$comNum</span></button>
                                    </div>
                                </div>
                            ";  
                        }
                        echo "
                            <div class='row width-60'>
                                <div class='col-md-12 p-2'>
                                    <form action='' method='POST' class='comment-form'>
                                        <input type='text' placeholder='Type your comment...' name='comment' autocomplete='off' required>
                                        <input type='submit' class='btn btn-info ml-3' name='reply' value='Post'>
                                    </form>
                                </div>
                            </div>
                        ";
                        include "comments.php";

                        if(isset($_POST["reply"])){
                            $comment = $_POST["comment"];

                            $sql = "INSERT INTO comments (post_id, user_id, comment, author, date) VALUES('$post_id', '$userId', '$comment', '$username', NOW());";
                            $run = mysqli_query($conn, $sql);
                            if(!$run){
                                // header("Location: single.php?post_id=$post_id&username=$user_name&comment=sql_error");
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
}

function user_posts() {
    global $conn;

    $u_id = $_GET["u_id"];
    $sql = "SELECT * FROM posts WHERE user_id='$u_id' ORDER BY 1 DESC";
    $run = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($run)){
        $post_id = $row['post_id'];
        $user_id = $row['user_id'];
        $content = $row["post_content"];
        $upload_img = $row["upload_image"];
        $post_date = substr($row["post_date"], 0, 16);

        $user = "SELECT * FROM users WHERE id='$user_id';";
        $run_u = mysqli_query($conn, $user);
        $row_u = mysqli_fetch_array($run_u);

        $user_name = $row_u["username"];
        $user_img = $row_u["profile_image"];
        $first_name = $row_u["first_name"];
        $last_name = $row_u["last_name"];

        $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $comNum = $rows['SUM'];

        echo "
            <div class='row width-80'>
                <div class='home-card'>
                    <div class='home-card-icons'>
                        <a href='single.php?post_id=$post_id&username=$user_name' title='View'>
                            <button class='btn btn-primary' style='border-radius: 0'><i class='fa fa-eye'></i>
                            </button>
                        <a>
                    </div>
                    <div class='home-card-flex'>
                        <img class='home-card-profile' src='$user_img' alt='profile'>
                        <div class='home-card-flex-user'>
                            <h4><a href='./user_profile.php?u_id=$user_id&username=$user_name' title='$first_name $last_name'>$user_name</a></h4>
                            <h5><small>Posted on: $post_date</small></h5>
                        </div>
                    </div>
                    <p class='home-card-content'>$content</p>
                    ".($upload_img ? "<img class='home-card-img' src='./image-post/$upload_img' alt=''>" : null)."
                    <a href='single.php?post_id=$post_id&username=$user_name' title='View comments'>
                        <button class='btn btn-warning w-100' style='border-radius: 0px;'>Comment<span class='comNum'>$comNum</span></button>
                    </a>
                </div>
            </div>
        ";
    }
}

function search_user(){
    global $conn;
    if(isset($_GET["search_btn"])){
        $search_query = $_GET["search_user"];
        $sql = "SELECT * FROM users WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR username LIKE '%$search_query%'";
    }
    else {
        $sql = "SELECT * FROM users";
    }
    $run = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($run)){
        $user_id = $row["id"];
        $first_name = $row['first_name'];
        $last_name = $row["last_name"];
        $username = $row["username"];
        $img = $row["profile_image"];

        // Get the number of posts
        $query = "SELECT COUNT(*) AS SUM FROM posts WHERE user_id=$user_id";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $comNum = $rows['SUM'];

        echo "
            <div class='row width-80'>
                <div class='col-sm-12 connect-card'>
                    <div class='connect-card-row'>
                        <a href='user_profile.php?u_id=$user_id&username=$username'>
                            <img src='$img' alt='profile' title='$username'>
                        </a>
                        <div class='connect-card-col'>
                            <h4><a href='user_profile.php?u_id=$user_id&username=$username'>$username</a></h4>
                            <h5>$first_name $last_name</h5>
                        </div>
                        <p><span style='color: crimson; font-weight: bold;'>$comNum</span> posts</p>
                    </div>
                </div>
            </div>
        ";
    }
}

function results(){
    global $conn;

    if(isset($_GET['search'])){
        $search = $_GET["user_search"];

        $sql = "SELECT * FROM posts WHERE post_content LIKE '%$search%';";
        $run = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($run)){
            $post_id = $row['post_id'];
            $user_id = $row['user_id'];
            $content = $row["post_content"];
            $upload_img = $row["upload_image"];
            $post_date = substr($row["post_date"], 0, 16);

            $users = "SELECT * FROM users WHERE id='$user_id'";
            $run_users = mysqli_query($conn, $users);
            $row_users = mysqli_fetch_array($run_users);
            $first_name = $row_users['first_name'];
            $last_name = $row_users["last_name"];
            $user_name = $row_users["username"];
            $user_img = $row_users["profile_image"];

            $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
            $result = mysqli_query($conn, $query);
            $rows = mysqli_fetch_assoc($result);
            $comNum = $rows['SUM'];

            echo "
                <div class='row width-80'>
                    <div class='home-card'>
                        <div class='home-card-icons'>
                            <a href='single.php?post_id=$post_id&username=$user_name' title='View'>
                                <button class='btn btn-primary' style='border-radius: 0'><i class='fa fa-eye'></i>
                                </button>
                            <a>
                        </div>
                        <div class='home-card-flex' style='padding: 1.4rem 0.6rem;'>
                            <img class='home-card-profile' src='$user_img' alt='profile'>
                            <div class='home-card-flex-user'>
                                <h4><a href='./user_profile.php?u_id=$user_id&username=$user_name' title='$first_name $last_name'>$user_name</a></h4>
                                <h5><small>Posted on: $post_date</small></h5>
                            </div>
                        </div>
                        <p class='home-card-content'>$content</p>
                        ".($upload_img ? "<img class='home-card-img' src='./image-post/$upload_img' alt=''>" : null)."
                        <a href='single.php?post_id=$post_id&username=$user_name' title='View comments'>
                            <button class='btn btn-warning w-100' style='border-radius: 0px;'>Comment<span class='comNum'>$comNum</span></button>
                        </a>
                    </div>
                </div>
            ";
        }
    }
}