<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>        
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Login</title>
    </head>

    <body>
        <div class="row">
            <div class="col-sm-12">
                <div class="logo">
                    <img src="img/pegas.png" alt="logo" class='logo-img'>
                    <h1 class='logo-name'>pegas</h1>
                    <h1 class='logo-name'>network</h1>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 main">
                <h2 class='main-join'>Join the Pegas</h2>
                <?php
                    if(isset($_GET["error"])){
                        if($_GET["error"] === "wrong_password"){
                            echo "<p class='signup-errmsg'>Wrong password!</p>";
                        }
                        else if($_GET["error"] === "no_user"){
                            echo "<p class='signup-errmsg'>No user with giver username!</p>";
                        }
                    }
                ?>
                <?php
                    if(isset($_GET["newpwd"])){
                        if($_GET["newpwd"] == 'pass_updated'){
                            echo "<p style='color: teal; font-size: 1.1rem; text-align: center'>Your password has been reseted!</p>";
                        }
                    }
                ?>
                <form action='login.php' method="POST" class='main-form'>
                    <input type='text' name='mailuid' placeholder="Username or E-mail" required>
                    <input type='password' name='pwd' placeholder="Password" required>
                    <a class='main-form-forgot' href="forgot-password.php">Forgotten password?</a>
                    <button class="main-form-login" name='login'>Login</button>
                    <a class='main-form-signup' href='signup.php'>Create an account</a>
                </form>
            </div>
        </div>
    </body>
</html>