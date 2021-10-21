<?php

    // Production Connection
    $serverName = "remotemysql.com";
    $dbName = "9RvI79tIZ1";
    $dbUsername = "9RvI79tIZ1";
    $dbPassword = "abtiFfuSKx";

    // Development Connection
    // $serverName = "localhost:3308";
    // $dbName = "pegas";
    // $dbUsername = "root";
    // $dbPassword = "";

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }

?>