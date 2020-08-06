<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Signup</title>
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
            <div class="col-sm-12">
                <div class='signup'>
                    <div class="signup-header">
                        <h2>Create an account</h2>
                    </div>
                    <?php
                        if(isset($_GET["error"])){
                            if($_GET["error"] === "pwd_min_8_char"){
                                echo "<p class='signup-errmsg'>Password: minimum 8 characters!</p>";
                            }
                            else if($_GET["error"] === "password_check"){
                                echo "<p class='signup-errmsg'>Your passwords don't match!</p>";
                            }
                            else if($_GET["error"] === "username_taken"){
                                echo "<p class='signup-errmsg'>Username is taken!</p>";
                            }
                            else if($_GET["error"] === "email_taken"){
                                echo "<p class='signup-errmsg'>Email is taken!</p>";
                            }
                            else if($_GET["error"] === "sql_error"){
                                echo "<p class='signup-errmsg'>Error occured. Try again!</p>";
                            }
                            else if($_GET["error"] === "user_min_4_char"){
                                echo "<p class='signup-errmsg'>Username: minimum 4 characters!</p>";
                            }
                        }
                        if(isset($_GET["signup"])){
                            if($_GET["signup"] === "success"){
                                echo "<p class='signup-sucmsg'>Signup successful!</p>";
                            }
                        }
                    ?>
                    <form action="insert_user.php" method="POST" class='signup-form'>
                        <input type="text" name='first_name' placeholder="First Name" required>
                        <input type="text" name='last_name' placeholder="Last Name" required>
                        <input type="email" name='email' placeholder="E-mail" required>
                        <input type="text" name='username' placeholder="Username" required>
                        <p>Minimum 4 characters.</p>
                        <input type="password" name='pwd' placeholder="Password" required>
                        <p>Minimum 8 characters.</p>
                        <input type="password" name='pwd-repeat' placeholder="Repeat Password" required>
                        <button type="submit" class='signup-form-btn' name='signup'>Signup</button>
                        <a class='signup-form-login' href='index.php'>Already have an account?</a>
                    </form>
                </div>
            </div>
        </div>   
    </body>
</html>