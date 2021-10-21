<?php

    include "../db.inc.php";

    if(isset($_GET)){
        $postId = mysqli_real_escape_string($conn, $_GET['postId']);
        $query = "SELECT COUNT(*) AS SUM FROM comments WHERE post_id=$postId";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_assoc($result);
        $comNum = $rows['SUM'];
        echo $comNum;
    }

?>