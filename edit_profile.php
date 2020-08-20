<?php
    session_start();
    include "includes/header.inc.php";

    if(!isset($_SESSION['userName'])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Edit Profile</title>
    </head>

    <body>
        <div class="row width-90">
            <div class='col-sm-12'>
                <form action='' method='POST' enctype='multipart/form-data'>
                    <h1 class='text-center py-4'>Edit your profile</h1>
                    <table class='edit-table'>
                        <tr>
                            <td>Change your first name</td>
                            <td>
                                <input type='text' name='f_name' value='<?php echo $first_name; ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td>Change your last name</td>
                            <td>
                                <input type='text' name='l_name' value='<?php echo $last_name; ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td>Change your username</td>
                            <td>
                                <input type='text' title='You got prankd bro, hah' value='<?php echo $user_name; ?>' disabled>
                            </td>
                        </tr>
                        <tr>
                            <td>About you</td>
                            <td>
                                <input class='edit-table-describe' type='text' name='describe_user' value='<?php echo $describe_user; ?>'>
                            </td>
                        </tr>
                        <tr>
                            <td>Change password</td>
                            <td>
                                <input type='password' name='u_pass'>
                                <br><small>Minimum 8 characters</small>
                            </td>
                        </tr>
                        <tr>
                            <td>Repeat password</td>
                            <td>
                                <input type='password' name='r_pass'>
                            </td>
                        </tr>
                        <tr>    
                            <td style='border: none; justfiy-content-center'>
                                <input type='submit' class='btn btn-success' name='update' value='Update'>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>

<?php 
    if(isset($_POST['update'])){
        $f_name = $_POST["f_name"];
        $l_name = $_POST["l_name"];
        $describe_user = $_POST["describe_user"];
        $pwd = $_POST["u_pass"];
        $repeatPwd = $_POST['r_pass'];

        if(strlen($pwd) < 8 && !empty($pwd)){
            echo "<p>Minimum 8 characters for password</p>";
            exit();
        }

        else if($pwd !== $repeatPwd){
            echo "<p>Passwords do not match.</p>";
            exit();
        }


        $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET first_name='$f_name', last_name='$l_name', describe_user='$describe_user', password='$hashPwd' WHERE id='$user_id';";
        $run = mysqli_query($conn, $sql);
        if($run){
            echo "<p style='text-align: center; color: teal; font-size: 1.2rem'>Profile Updated</p>";
        }
        else {
            echo "<p style='text-align: center; color: crimson; font-size: 1.2rem'>Error! Try again.</p>";
        }
    }
?>