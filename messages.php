<?php
    session_start();
    include "includes/header.inc.php";

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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Messages</title>
    </head>

    <body>
        <div class="row width-90">
            <?php 
                if(isset($_GET["u_id"])){
                    global $conn;

                    // Who is recieving msg
                    $get_id = $_GET["u_id"];
                    $sql = "SELECT * FROM users WHERE id='$get_id';";
                    $run = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($run);
                    $user_to_msg = $row['id'];
                    $user_to_name = $row['username'];
                }

                // Who is sending msg
                $user = $_SESSION['userId'];
                $sql = "SELECT * FROM users WHERE id='$user';";
                $run = mysqli_query($conn, $sql);
                if($row = mysqli_fetch_array($run)){
                    $user_from_msg = $row['id'];
                    $user_from_name = $row["username"];
                }
            ?>
            <div class='col-md-8'>
                <?php 
                    if(isset($_GET["u_id"])){
                        global $conn;

                        $get_id = $_GET["u_id"];
                        $username = $_GET["username"];

                        $sql = "SELECT * FROM users WHERE id='$get_id';";
                        $run = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($run);

                        $user_id = $row["id"];
                        $user_name = $row["username"];
                        $first_name = $row["first_name"];
                        $last_name = $row["last_name"];
                        $user_img = $row["profile_image"];
                        $userId = $_SESSION['userId'];
                    }

                    if($get_id != $userId){
                        echo "
                            <div class='messages-info'>
                                <img src='$user_img' width='120px' height='120px' alt='profile'>
                                <a href='user_profile.php?u_id=$user_id&username=$user_name'>
                                    <p class='messages-info-name'>$first_name $last_name</p>
                                </a>
                                <p class='messages-info-username'>$user_name</p>
                            </div>
                        ";
                    }
                    ?>
                <?php 
                    if($username != '') {
                    echo "<div class='messages-msg' id='scroll_messages'>";

                        $sql = "SELECT * FROM messages WHERE (user_to='$user_to_msg' AND user_from='$user_from_msg') OR (user_from='$user_to_msg' AND user_to='$user_from_msg') ORDER BY 1 ASC;";
                        $run = mysqli_query($conn, $sql);
                        $username = $_GET['username'];
                        while($row = mysqli_fetch_assoc($run)){
                            $user_to = $row["user_to"];
                            $user_from = $row["user_from"];
                            $msg_body = $row["msg_body"];
                            $msg_date = substr($row["date"], 0, 16);
                            $seen = $row['msg_seen'];                            
                        ?>
                        <div>
                            <p>
                                <?php 
                                    if($user_to == $user_to_msg && $user_from == $user_from_msg){
                                        echo "
                                            <div class='messages-msg-sender' title='$msg_date'>
                                                <p>$msg_body</p>
                                            </div>
                                        ";
                                    }
                                    else if($user_from == $user_to_msg && $user_to == $user_from_msg){
                                        echo "
                                            <div class='messages-msg-reciever' title='$msg_date'>
                                                <p>$msg_body</p>
                                                <i class='fa fa-check-circle'></i>
                                            </div>
                                        ";
                                    }
                                ?>
                            </p>
                        </div>
                    <?php } } ?>
                </div>
                <?php
                    if(isset($_GET["u_id"])){
                        $username = $_GET['username'];
                        $u_id = $_GET['u_id'];
                        $userId = $_SESSION['userId'];

                        if($username != '' && $u_id != $userId){
                            echo '
                                <form action="" method="POST" class="messages-form">
                                    <input id="msg" type="text" placeholder="Insert message" name="msg_box" autocomplete="off" required>
                                    <input type="submit" class="btn btn-dark" value="Send" name="send_msg">
                                </form>
                            ';
                        } 
                    }

                    if(isset($_POST["send_msg"])){
                        $msg = $_POST["msg_box"];

                        if(!$msg == ''){
                            $sql = "INSERT INTO messages(user_to, user_from, msg_body, date, msg_seen) VALUES('$user_to_msg', '$user_from_msg', '$msg', NOW(), 'no');";
                            $run = mysqli_query($conn, $sql);
                        }
                    } 
                ?>
            </div>
            <div class='col-md-4 messages-users' style='background: #e4e4e4; border-radius: 10px'>
                <?php 
                    $sql = "SELECT * FROM users";
                    $run = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($run)){
                        $user_id = $row["id"];
                        $userId = $_SESSION['userId'];
                        $user_name = $row['username'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $profile_img = $row['profile_image'];

                        $sql_u = "SELECT COUNT(*) AS SUM FROM messages WHERE msg_seen='no' AND user_from='$user_id' AND user_to='$userId' ORDER BY msg_seen DESC";
                        $run_u = mysqli_query($conn, $sql_u);
                        $row_u = mysqli_fetch_assoc($run_u);
                        $seen = $row_u['SUM'];

                        // Display users that sent you msg
                        if($user_id != $userId && $seen){
                            echo "
                                <a class='messages' href='messages.php?u_id=$user_id&username=$user_name'>
                                    <div class='messages-heads' id='red'>
                                        <img src='$profile_img' alt='profile' width='70px' height='70px' title='$user_name'>
                                        <p class='messages-heads-name'>$first_name $last_name</p>
                                        <p class='new'></p> 
                                    </div> 
                                </a>
                            ";
                        }

                        // Display users who did not send you msg
                        else if($user_id != $userId && !$seen){
                            echo "
                                <a class='messages' href='messages.php?u_id=$user_id&username=$user_name'>
                                    <div class='messages-heads'>
                                        <img src='$profile_img' alt='profile' width='70px' height='70px' title='$user_name'>
                                        <p class='messages-heads-name'>$first_name $last_name</p>
                                    </div> 
                                </a>
                            ";
                        }

                        // Set msg_seen to yes when clicked on user, who sent you previously
                        else if(isset($_GET["u_id"])){
                            $u_id = $_GET["u_id"];

                            $sql = "UPDATE messages SET msg_seen='yes' WHERE user_from='$u_id' AND user_to='$userId';";
                            $run_m = mysqli_query($conn, $sql);

                            if($u_id == $user_id){
                                echo "
                                    <a class='messages' href='messages.php?u_id=$user_id&username=$user_name'>
                                        <div class='messages-heads' id='red'>
                                            <img src='$profile_img' alt='profile' width='70px' height='70px' title='$user_name'>
                                            <p class='messages-heads-name'>$first_name $last_name</p>
                                            <p class='new'></p> 
                                        </div> 
                                    </a>
                                ";
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <script>
            var div = document.getElementById("scroll_messages");
            div.scrollTop = div.scrollHeight;

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            $(document).ready(function(){
                $("#msg").focus();
            })
        </script>
    </body>
</html>