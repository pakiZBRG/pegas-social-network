<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['reset-request-submit'])){
    require "database.inc.php";

    // PHPMailer
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    
    $url = "http://" .$_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/create-new-password.php?selector=$selector&validator=".bin2hex($token);

    $expires = date("U") + 1800;
    $userEmail = $_POST["email"];

    //Delete tokens for emails, if they exist in 30min span
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error on our side. Try again later!";
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error on our side. Try again later!";
        exit();
    }
    else {
        $hashToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nasa.nase72@gmail.com';
        $mail->Password   = 'Jasamnikola1';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('pavlovicnikola511@gmail.com', 'Pegas Network');
        $mail->addAddress($userEmail);
        $mail->addReplyTo('no-reply@gmail.com', 'No reply');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Request';
        $mail->Body    = "<h2>You requested a password reset</h2>
                            Click <a href='$url'>this link</a> to reset your password";

        $mail->send();
        header("Location: ../forgot-password.php?reset=success");
    } 
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else {
    header('Location: ../index.php');
}