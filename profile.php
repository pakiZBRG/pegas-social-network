<?php
    session_start();
    require "includes/header.inc.php";

    if(isset($_SESSION['id'])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <?php 
            $u_id = $_SESSION['userId'];
            $sql = "SELECT username FROM users WHERE id='$u_id';";
            $run = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($run);
            $username = $row["username"];
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> 
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | <?php echo $username; ?></title>
    </head>

    <body>
        <div class="row width-80">
            <div class='col-lg-12 p-0'>
                <?php
                    echo "
                        <div class='cover'>
                            <img src='$cover_image' alt='cover-img'>
                            <form action='profile.php?u_id=$user_id' method='POST' enctype='multipart/form-data' class='cover-form'>
                                <label class='btn btn-danger'>Select Image
                                    <input type='file' name='u_cover' size='60'>
                                </label>
                                <button class='btn btn-success' name='c_submit'>Update cover</button>
                            </form>
                        </div>
                        <div class='profile'>
                            <img src='$profile_image' alt='profile-img' height='200px' width='200px'>
                            <form action='profile.php?u_id='$user_id'' method='POST' enctype='multipart/form-data' class='profile-form'>
                                <label class='btn btn-danger'>Select Image
                                    <input type='file' name='u_profile' size='60'>
                                </label>
                                <button class='btn btn-success' name='p_submit'>Update profile</button>
                            </form>
                        </div>
                    ";
                ?>
                <?php
                    // Insert and change COVER image
                    if(isset($_POST["c_submit"])){
                        $file = $_FILES["u_cover"];
                    
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
                                    $fileDestination = "cover/".$fileNewName;
                                    move_uploaded_file($fileTmpName, $fileDestination);
                                    $sql = "UPDATE users SET cover_image='$fileDestination' WHERE id='$user_id';";
                                    $run = mysqli_query($conn, $sql);
                                }
                                else {
                                    echo "The file is to big, upto 2MB!";
                                }
                            }
                            else {
                                echo "There was an error!";
                            }
                        }
                        else {
                            echo "You can not upload files of these type!";
                        }
                    }

                    // Insert and change PROFILE image
                    else if(isset($_POST["p_submit"])){
                        $file = $_FILES["u_profile"];
                    
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
                                    $fileDestination = "users/".$fileNewName;
                                    move_uploaded_file($fileTmpName, $fileDestination);
                                    $sql = "UPDATE users SET profile_image='$fileDestination' WHERE id='$user_id';";
                                    $run = mysqli_query($conn, $sql);
                                }
                                else {
                                    echo "The file is to big, upto 2MB!";
                                }
                            }
                            else {
                                echo "There was an error!";
                            }
                        }
                        else {
                            echo "You can not upload files of these type!";
                        }
                    }
                ?>
            </div>
        </div>
        <div class='row width-80'>
            <div class="col-lg-3 p-0">
                <?php
                    $new_date = substr($register_date, 0, 10);
                    echo"
                        <div class='about'>
                            <h2 class='text-center pb-3'><strong>About</strong></h2>
                            <h4>$user_name</h4>
                            <h4><span>Name:</span> $first_name $last_name</h4>
                            <p class='about-text'>$describe_user</p>
                            <p><span>Member since:</span> $new_date</p>
                        </div>
                    ";
                ?>
            </div>
            <div class='col-lg-9'>
                <?php
                    global $conn;
                    if(isset($_GET["user_id"])){
                        $user_id = $_GET["user_id"];
                    }

                    $sql = "SELECT * FROM posts WHERE user_id=? ORDER BY 1 DESC;";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: profile.php?error=sql_error");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $user_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while($row = mysqli_fetch_assoc($result)){
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

                            include "includes/delete_post.inc.php";
                            include "includes/edit_post.inc.php";

                            $sql = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
                            $num = mysqli_query($conn, $sql);
                            $rows = mysqli_fetch_assoc($num);
                            $comNum = $rows['SUM'];

                            echo "
                                <div class='row width-80'>
                                    <div class='home-card'>
                                        <div class='home-card-icons'>
                                            <a href='single.php?post_id=$post_id&username=$user_name&status=view' title='View'>
                                                <button class='btn btn-primary' style='border-radius: 0'><i class='fa fa-eye'></i>
                                                </button>
                                            <a>
                                            <a href='includes/edit_post.inc.php?post_id=$post_id&username=$user_name&status=edit' title='Edit'>
                                                <button class='btn btn-secondary' style='border-radius: 0'><i class='fa fa-pencil-square-o'></i>
                                                </button>
                                            <a>
                                            <a href='includes/delete_post.inc.php?post_id=$post_id&username=$user_name&status=deleted' title='Delete'>
                                                <button class='btn btn-dark' style='border-radius: 0'><i class='fa fa-trash'></i></button>
                                            </a>
                                        </div>
                                        <div class='home-card-flex'>
                                            <img class='home-card-profile' src='$user_img' alt='profile' width='100px' height='100px'>
                                            <div class='home-card-flex-user'>
                                                <h4><a href='profile.php?u_id=$user_id&username=$user_name'>$user_name</a></h4>
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
                ?>
            </div>
        </div>
    </body>
</html>