<?php
    session_start();
    include "includes/header.inc.php";

    if(isset($_SESSION['email'])){
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel='shortcut icon' href="img/pegas.png">
        <link rel='icon' href="img/pegas.png">
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='style/style.css'>
        <title>Pegas | Find People</title>
    </head>

    <body>
        <div class="row width-80 pb-4">
            <div class="col-sm-12">
                <h2 class='text-center p-4'>Connect with people, or bots</h2>
                <form class='connect-form' action=''>
                    <input type='text' placeholder='Search people by username or first and last name' name='search_user'>
                    <button type='submit' class='btn btn-info' name='search_btn'>Search</button>
                </form>
            </div>
            <?php search_user(); ?>
        </div>
    </body>
</html>