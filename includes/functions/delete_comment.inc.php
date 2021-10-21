<?php

    include "../db.inc.php";

    if(isset($_GET["comId"])){
        $comId = mysqli_real_escape_string($conn, $_GET["comId"]);

        $sql = "DELETE FROM comments WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $comId);
        mysqli_stmt_execute($stmt);
    }
?>