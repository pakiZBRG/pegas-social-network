<?php
    session_start();
    require "includes/header.inc.php";

    if(isset($_SESSION['email'])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src='main.js'></script>  
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Profile</title>
    </head>

    <body>
        <div class="row width-80">
            <div class='col-sm-12 p-0'>
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
                            <img src='$profile_image' alt='profile-img'>
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
            <div class="col-sm-3 p-0">
                <?php
                    $new_date = substr($register_date, 0, 10);
                    echo"
                        <div class='about'>
                            <h2 class='text-center pb-3'><strong>About</strong></h2>
                            <h4>$user_name</h4>
                            <h4><span>Name:</span> $first_name $last_name</h4>
                            <p class='text-black-50'>$describe_user</p>
                            <p>Member since: $new_date</p>
                        </div>
                    ";
                ?>
            </div><!-- Get the number of typed characters and limit it to 750 -->
        </div>
    </body>
</html>