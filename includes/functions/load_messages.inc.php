<?php

    include "../db.inc.php";

    if(isset($_GET)){
        $userId = $_GET["userId"];
        $loggedUser = $_GET["loggedUser"];
    }

    $sql = "SELECT * FROM messages WHERE sender=$userId AND reciever=$loggedUser OR sender=$loggedUser AND reciever=$userId";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)) {
        $sender = $row["sender"];
        $reciever = $row["reciever"];
        $message = $row["message"];
        $date = $row["date"];
        $formatDate = substr(date_format(date_create($date), DATE_RFC1123), 17, 5);
        
        if($sender == $userId && $reciever == $loggedUser) {
            echo "
                <div class='single left'>
                    <div class='reciever'>
                        <p>$message</p>
                    </div>
                    <small>$formatDate</small>
                </div>
            ";
        } else {
            echo "
                <div class='single right'>
                    <small>$formatDate</small>
                    <div class='sender'>
                        <p>$message</p>
                    </div>
                </div>
            ";
        }
    }

?>