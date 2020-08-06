<style>
    .delete{
        font-size: 1.5rem;
        text-align: center;
    }
</style>

<?php
include "database.inc.php";

if(isset($_GET["post_id"])){
    $post_id = $_GET["post_id"];
    $username = $_GET["username"];

    $sql = "SELECT id FROM users WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: delete_post.inc.php?error=sql_error");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            $id = $row["id"];
            $sql = "DELETE FROM posts WHERE post_id=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: delete_post.inc.php?error=sql_error");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $post_id);
                mysqli_stmt_execute($stmt);
                header("Location: ../profile.php?u_id=$id&username=$username&status=deleted");
                exit();
            }
            
        }
    }    
}