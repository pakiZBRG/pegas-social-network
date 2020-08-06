<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='../style/style.css'>
        <title>Pegas | Reset Password</title>
    </head>

    <body>
        <div class="row">
            <div class="col-sm-12">
                <div class="logo">
                    <img src="../img/pegas.png" alt="logo" class='logo-img'>
                    <h1 class='logo-name'>pegas</h1>
                    <h1 class='logo-name'>network</h1>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-sm-12 main'>
                <?php
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];

                    if(empty($selector) || empty($validator)){
                        echo "Could not validate your request";
                    }
                    else {
                        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                            ?>

                                <form action='reset-password.inc.php' method='POST' class='main-form mt-5'>
                                    <input type='hidden' name='selector' value='<?php echo $selector; ?>'>
                                    <input type='hidden' name='validator' value='<?php echo $validator; ?>'>
                                    <input type='password' name='pwd' placeholder='New password'>
                                    <input type='password' name='pwd-repeat' placeholder='Repeat password'>
                                    <button type='submit' name='reset-password-submit' class='main-form-login'>Reset password</button>
                                </form>
                                <?php
                                    if(isset($_GET["newpwd"])){
                                        if($_GET["newpwd"] == 'min_8_char'){
                                            echo "<p style='color: crimson; font-size: 1.2rem;'>Minimun 8 characters!</p>";
                                        }
                                        else if($_GET["newpwd"] == "empty"){
                                            echo "<p style='color: crimson; font-size: 1.2rem;'>Empty password field!</p>";
                                        }
                                        else if($_GET["newpwd"] == "not_same"){
                                            echo "<p style='color: crimson; font-size: 1.2rem;'>Passwords do not match!</p>";
                                        }
                                    }
                                ?>

                            <?php
                        }
                    }
                ?>
            </div>
        </div>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </body>
</html>