<?php
    session_start();
    $pageName = $_SERVER["PHP_SELF"];
    $name = '';

    if(str_contains($pageName, 'signup')) {
        $name = "| Signup";
    } else if(str_contains($pageName, 'forgot')) {
        $name = '| Forgot Password';
    } else if(str_contains($pageName, 'reset')) {
        $name = '| Reset Password';
    } else if(str_contains($pageName, 'home')) {
        $name = '| Home';
    } else if(str_contains($pageName, 'profile')) {
        $name = "| ".$_GET['username'];
    } else if(str_contains($pageName, 'members')) {
        $name = "| Members";
    } else if(str_contains($pageName, 'edit_post')) {
        $name = "| Edit post";
    } else if(str_contains($pageName, 'messages')) {
        $name = "| Messages";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Join my new social network in which you can connect with various people, post content and chat">
        <title>Pegas <?php echo $name ?></title>
        <link rel='shortcut icon' href="/pegas/img/pegas.png">
        <link rel='icon' href="/pegas/img/pegas.png">
        <link rel='stylesheet' href='/pegas/style/style.css'>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
        <script src="https://use.fontawesome.com/3111f6741a.js"></script>
        <script src="/pegas/js/ajax.js"></script>
        <script src="/pegas/js/displayImg.js"></script>
        <script src="/pegas/js/viewPostImg.js"></script>
        <script src='/pegas/js/textLimit.js'></script>
        <script src='/pegas/js/mobileNav.js'></script>
        <script>
            // Prevent resending forms on page refresh
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </head>

    <body>