<?php 

    include "../db.inc.php";
    include "../helpers/Messages.php";

    if(isset($_GET)) {
        $postId = mysqli_real_escape_string($conn, $_GET["postId"]);

        $query = "SELECT upload_image FROM posts WHERE id=$postId;";
        $img_result = mysqli_query($conn, $query);
        if($row = mysqli_fetch_assoc($img_result)) {
            $filename = $row["upload_image"];
            if($filename) {
                $deleteimg = realpath($_SERVER["DOCUMENT_ROOT"]) . "/pegas/$filename";
                if (file_exists($deleteimg)) {
                    unlink($deleteimg);
                }
            }
        }

        $sql = "DELETE FROM posts WHERE id=$postId";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        if($stmt){
            success("Post deleted");
        } else {
            error('SQL error: '.mysqli_error($conn));
        }
    }

?>