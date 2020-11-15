<?php

// Production Connection
// $serverName = "remotemysql.com";
// $dbName = "7T7edyOVpr";
// $dbUsername = "7T7edyOVpr";
// $dbPassword = "ZY4HFpDtWb";

// Development Connection
$serverName = "localhost";
$dbName = "pegas";
$dbUsername = "root";
$dbPassword = "";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}