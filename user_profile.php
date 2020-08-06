<?php
    session_start();
    include "includes/header.inc.php";

    if(isset($_SESSION['id'])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <?php 
            $u_id = $_GET["u_id"];
            $sql = "SELECT username FROM users WHERE id=$u_id;";
            $run = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($run);
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
            <?php
                if(isset($_GET["u_id"])){
                    $u_id = $_GET["u_id"];
                }

                if($u_id < 0 || $u_id == ''){
                    header("Location: index.php");
                    exit();
                }
                else {
            ?>
            <div class='col-sm-12 p-0'>
                <?php 
                    if(isset($_GET["u_id"])){
                        global $con;
                        $user_id = $_GET["u_id"];

                        $sql = "SELECT * FROM users WHERE id='$user_id';";
                        $run = mysqli_query($conn, $sql);
                        if($row = mysqli_fetch_assoc($run)){
                            $id = $row["id"];
                            $user_name = $row["username"];
                            $first_name = $row["first_name"];
                            $last_name = $row["last_name"];
                            $describe_user = $row["describe_user"];
                            $register_date = $row['register_date'];
                            $profile_img = $row['profile_image'];
                            $cover_img = $row["cover_image"];

                            echo "
                                <div class='cover'>
                                    <img src='$cover_img' id='myImg' alt='cover-img'>
                                </div>
                                <div id='myModal' class='modal'>
                                    <span class='close'>&times;</span>
                                    <img class='modal-content' id='imgModal'>
                                </div>
                                <div class='profile'>
                                    <img src='$profile_img' alt='profile-img' height='200px' width='200px'>
                                </div>
                            ";
                        }
                    }
                ?>
            </div>
                <?php } ?>
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
                            <p class='text-black-50'>$describe_user</p>
                            <p>Member since: $new_date</p>
                            <a href='messages.php?u_id=$user_id&username=$user_name'><button class='btn btn-dark mt-2 rounded-0'>Send message</button></a>
                        </div>
                    ";
                ?>
            </div>
            <div class='col-lg-8'>
                <?php 
                    if(isset($_GET["u_id"])){
                        $u_id = $_GET["u_id"];
                    }

                    $sql = "SELECT * FROM posts WHERE user_id=$u_id ORDER BY 1 DESC;";
                    $run = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($run)){
                        $post_id = $row['post_id'];
                        $user_id = $row['user_id'];
                        $content = $row["post_content"];
                        $upload_img = $row["upload_image"];
                        $post_date = substr($row["post_date"], 0, 16);

                        $user = "SELECT * FROM users WHERE id=$user_id;";
                        $run_u = mysqli_query($conn, $user);
                        $row_u = mysqli_fetch_assoc($run_u);

                        $user_name = $row_u["username"];
                        $user_img = $row_u["profile_image"];

                        $sql = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$post_id";
                        $num = mysqli_query($conn, $sql);
                        $rows = mysqli_fetch_assoc($num);
                        $comNum = $rows['SUM'];

                        echo "
                        <div class='row width-90'>
                            <div class='home-card'>
                                <div class='home-card-icons'>
                                    <a href='single.php?post_id=$post_id&username=$user_name&status=view' title='View'>
                                        <button class='btn btn-primary' style='border-radius: 0'><i class='fa fa-eye'></i>
                                        </button>
                                    </a>
                                </div>
                                <div class='home-card-flex'>
                                    <img class='home-card-profile' src='$user_img' alt='profile' height='100px' width='100px'>
                                    <div class='home-card-flex-user'>
                                        <h4><a href='profile.php?u_id=$user_id&username=$user_name'>$user_name</a></h4>
                                        <h5><small>Posted on: $post_date</small></h5>
                                    </div>
                                </div>
                                <p class='home-card-content'>$content</p>
                                <img class='home-card-img' src='./image-post/$upload_img' alt=''>
                                <a href='single.php?post_id=$post_id&username=$user_name' title='View comments'>
                                    <button class='btn btn-warning w-100' style='border-radius: 0px;'>Comment<span class='comNum'>$comNum</span></button>
                                </a>
                            </div>
                        </div>
                        ";
                    }
                ?>
            </div>
        </div>
        <script src='view_img.js'></script>
    </body>
</html>