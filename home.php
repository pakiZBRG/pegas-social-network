<?php
    session_start();
    include "includes/header.inc.php";

    if(isset($_SESSION['id'])){
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
        <title>Pegas | Home</title>
    </head>

    <body>
        <div class="row width-80">
            <div class='home-post'>
                <form action='home.php?u_id=<?php echo $user_id ?>&name=<?php echo $user_name ?>' method='POST' enctype='multipart/form-data' id='postForm'>
                    <textarea rows='2' placeholder='What are you thinking about?' name='content'></textarea>
                    <div class='home-post-btn'>
                        <label class='btn btn-danger' title='Choose an image'>
                            <i class="fa fa-folder-open" style='font-size: 1.4rem'></i>
                            <input type='file' name='upload_img' size='30' style='display: none'>
                        </label>
                        <button name='sub' class='btn btn-success' style='margin-top: -8px;'>Post</button>
                    </div>
                </form>
                <?php insertPost(); ?>
            </div>
        </div>

        <div class='row width-80'>
            <div class="col-md-11 col-sm-12 mx-auto">
                <h1 class='home-feed'>News Feed</h1>
                <?php get_posts(); ?>
            </div>
        </div>
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </body>
</html>