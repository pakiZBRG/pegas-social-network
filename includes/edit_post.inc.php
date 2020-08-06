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
        <link rel='stylesheet' href='../style/style.css'>
        <title>Pegas | Edit Post</title>
    </head>
    <body>
        <div class='row'>
            <div class='col-sm-12'>
                <?php
                    include "database.inc.php";
                    if(isset($_GET["post_id"])){
                        $get_post = $_GET["post_id"];
                        $username = $_GET["username"];
                        global $get_post, $username;

                        $sql = "SELECT * FROM posts WHERE post_id=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: profile.php?error=sql_error");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "s", $get_post);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if($row = mysqli_fetch_assoc($result)){
                                $post_con = $row["post_content"];
                                $post_img = $row["upload_image"];

                                echo "
                                    <form action='' method='POST' class='edit-form'>
                                        <h1 class='pt-4'>Edit Your Post</h1>
                                        <textarea rows='3' name='content'>$post_con</textarea><br>
                                        <img src='../image-post/$post_img' alt=''>                                        
                                        <button type='submit' name='update' class='btn btn-info mt-3'>Save</button>
                                    </form>
                                ";
                            }
                        }

                        if(isset($_POST["update"])){
                            $content = $_POST["content"];
    
                            $sql = "SELECT id FROM users WHERE username=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header("Location: edit_post.inc.php?error=sql_error");
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($stmt, "s", $username);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if($row = mysqli_fetch_assoc($result)){
                                    $id = $row["id"];
                                    $sql = "UPDATE posts SET post_content=? WHERE post_id=?;";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        header("Location: edit_post.inc.php?error=sql_error");
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($stmt, "ss", $content, $get_post);
                                        mysqli_stmt_execute($stmt);
                                        header("Location: ../profile.php?u_id=$id&username=$username&edit=success");
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>