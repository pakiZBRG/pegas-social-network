<?php

$get_id = $_GET["post_id"];
$sql = "SELECT * FROM comments WHERE post_id=? ORDER BY 1 DESC;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: single.php?error=sql_error");
    exit();
}
else{
    mysqli_stmt_bind_param($stmt, "s", $get_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $com_id = $row["com_id"];
        $user_id = $row["user_id"];
        $com = $row['comment'];
        $post_id = $row["post_id"];
        $name = $row['author'];
        $date = substr($row['date'], 0, 16);

        $sql = "SELECT * FROM users WHERE id='$user_id';";
        $run = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($run);
        $img = $row["profile_image"];
        $user_name = $row["username"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];

        echo "
            <div class='row width-50'>
                <div class='col-md-12 comment'>
                    <a href='includes/delete_comment.inc.php?post_id=$post_id&com_id=$com_id&username=$user_name' class='comment-delete' title='Delete'>
                        <i class='fa fa-trash'></i>
                    </a>
                    <div class='comment-info'>
                        <img class='comment-profile' src='$img' alt='profile'>
                        <h5><a href='user_profile.php?u_id=$user_id&username=$user_name' title='$first_name $last_name'>$user_name</a>  <small>$date</small></h5>
                    </div>
                    <p class='comment-content'>$com</p>
                </div>
            </div>
        ";
    }
}