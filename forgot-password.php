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
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Forgotten Password</title>
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

        <div class='row'>
            <div class='col-sm-12 main'>
                <h3 class='mt-5'>Recover your account</h3>
                <p style='font-size: 1.2rem'>An e-mail will be sent to you with instructions on how to reset your password</p>
                <form action='includes/reset-request.inc.php' method='POST'  class='main-form mt-5'>
                    <input type='text' name='email' placeholder='E-mail' required>
                    <button type='submit' name='reset-request-submit' class='main-form-login'>Request new password</button> 
                </form>
                <?php 
                    if(isset($_GET["reset"])){
                        if($_GET['reset'] == "success"){
                            echo "<p style='color: teal; font-size: 1.1rem; padding-top: 0.6rem'>Check your email!</p>";
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