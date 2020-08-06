<?php
include "database.inc.php";

if(isset($_GET["com_id"])){
    $com_id = $_GET["com_id"];
    $username = $_GET["username"];
    $post_id = $_GET["post_id"];

    $sql = "SELECT * FROM users WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: delete_comment.inc.php?error=sql_error");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            $id = $row["id"];
            print_r($post_id);
            $sql = "DELETE FROM comments WHERE com_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: delete_comment.inc.php?error=sql_error");
                exit(); 
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $com_id);
                mysqli_stmt_execute($stmt);
                header("Location: ../single.php?post_id=$post_id&username=$username&comment=deleted");
                exit();
            }
            
        }
    }    
}