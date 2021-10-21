<?php

    include '../db.inc.php';

    if(isset($_POST)) {
        $sender = $_POST["sender"];
        $reciever = $_POST["reciever"];
        $msg = mysqli_real_escape_string($conn, $_POST["msg"]);
        $date = date("d-m-Y H:i");
        $seen = 'no';

        if(trim($msg) != '') {
            $sql = "INSERT INTO messages (sender, reciever, message, date, seen) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $sender, $reciever, $msg, $date, $seen);
            mysqli_stmt_execute($stmt);
            if($stmt) {
                $get_msg = "SELECT * FROM messages WHERE sender=$sender AND reciever=$reciever ORDER BY 1 DESC";
                $stmt = mysqli_prepare($conn, $get_msg);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)) {
                    $message = $row["message"];
                    $date = $row["date"];
                    $formatDate = substr(date_format(date_create($date), DATE_RFC1123), 17, 5);
                    
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
            
        }
    }

?>