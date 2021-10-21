<?php

    include "../helpers/Messages.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require realpath($_SERVER["DOCUMENT_ROOT"]) . "\\vendor\autoload.php";

    if (file_exists(__DIR__ . '/.env')) { 
        $dotenv = Dotenv\Dotenv::createImmutable(realpath($_SERVER["DOCUMENT_ROOT"]))->load();
        $user_email = $_ENV["USER_EMAIL"];
        $user_pass = $_ENV["USER_PASS"];
    } else {
        $user_email = getenv("USER_EMAIL");
        $user_pass = getenv("USER_PASS");
    }

    if(isset($_GET['forgotPassword'])){
        require "../db.inc.php";

        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        
        $url = "http://".$_SERVER["HTTP_HOST"]."/reset/$selector/".bin2hex($token);

        $expires = date("U") + 1800;
        $email = mysqli_real_escape_string($conn, $_GET["email"]);
        if($email == '') {
            warning('Fill in the email');
        } else {
            // Find user with email
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $numRow = mysqli_stmt_num_rows($stmt);
            if($numRow > 0){
                // Delete tokens for emails, if they exist in 30min span
                $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
            
                $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_prepare($conn, $sql);
                $hashToken = password_hash($token, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashToken, $expires);
                mysqli_stmt_execute($stmt);
            
                mysqli_stmt_close($stmt);
                
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $user_email;
                    $mail->Password   = $user_pass;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;
            
                    //Recipients
                    $mail->setFrom('pavlovicnikola511@gmail.com', 'Pegas Network');
                    $mail->addAddress($email);
                    $mail->addReplyTo('no-reply@gmail.com', 'No reply');
            
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password Request';
                    $mail->Body    = "<h2>You requested a password reset</h2>
                                        Click <a href='$url'>this link</a> to reset your password";
            
                    $mail->send();
                    success("Mail sent to $email");
                } 
                catch (Exception $e) {
                    warning('Message could not be sent. Error: '.$mail->ErrorInfo);
                }
            } else {
                warning('No user with given email');
            }
        }
    } else {
        header('Location: /');
    }