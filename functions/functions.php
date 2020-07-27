<?php

include "./includes/database.inc.php";

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

        $fileExt = explode(".", $fileName);
        $fileAcutalExt = strtolower(end($fileExt));
    
        $allowed = array('jpg', 'jpeg', 'png', 'svg', 'webp');
    
        if(in_array($fileAcutalExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 2000000){
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
                    echo "The file is to big, upto 2MB!";
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
            echo "You can not upload files of these type!";
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
    $num_page = 4;

    if(isset($_GET["page"])){
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $num_page;
    $sql = "SELECT * FROM posts ORDER BY 1 DESC LIMIT $start_from, $num_page";
    $run = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($run)){
        $post_id = $row["post_id"];
        $user_id = $row["user_id"];
        $content = $row["post_content"];
        $upload_img = $row['upload_image'];
        $post_date = substr($row["post_date"], 0, 16);

        $sql= "SELECT * FROM users WHERE id='$user_id' AND posts='yes';";
        $run = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($run);
        $user_name = $row["username"];
        $user_image = $row["profile_image"];
        

        if(strlen($upload_img) >= 1 || strlen($content) >= 1){
            echo "
                <div class='row width-80'>
                    <div class='home-card'>
                        <div class='home-card-flex'>
                            <img class='home-card-profile' src='$user_image' alt='profile'>
                            <div class='home-card-flex-user'>
                                <h4><a href='profile.php?u_id=$user_id&username=$user_name'>$user_name</a></h4>
                                <h5><small>Posted on: $post_date</small></h5>
                            </div>
                        </div>
                        <p class='home-card-content'>$content</p>
                        <img class='home-card-img' src='./image-post/$upload_img' alt=''>
                        <a href='single.php?post_id=$post_id'>
                            <button class='btn btn-warning>Comment</button>
                        </a>
                    </div>
                </div>
            ";
        }
    }
}