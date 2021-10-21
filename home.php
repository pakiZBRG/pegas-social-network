<?php include './includes/header.php' ?>
<?php include './includes/nav.php' ?>
<?php

    include "./includes/googleButton.php";
    if(isset($_GET["code"])) {
        $email = $google_info->email;
        $_SESSION["userEmail"] = $email;
    } else {
        echo "";
    }

?>
    <div class="row width-80">
        <div class='home-post'>
            <form method='POST' enctype='multipart/form-data' id='postForm'>
                <input type="hidden" name='userId' id="userId" value="<?php echo $_SESSION["userId"]; ?>">
                <div class="form-group m-0">
                    <textarea rows='3' id='post' placeholder='What are you thinking about?' name='content'></textarea>
                    <div class='limit'>
                        <div id="length"></div>
                    </div>
                </div>
                <div class="show-img">
                    <img id="showImg">
                </div>
                <div class='home-post-btn'>
                    <label class='postBtn folder' title='Choose an image'>
                        <i class="fa fa-folder-open" style='padding: 0.3rem'></i>
                        <input type='file' name='image' onchange="loadFile(event)">
                    </label>
                    <button name='post' id='postBtn' class='postBtn button'>Post</button>
                </div>
            </form>
            <div id="message"></div>
        </div>
    </div>

    <div class='row width-80'>
        <div class="col-md-11 col-sm-12 mx-auto">
            <h1 class='home-feed'>News Feed</h1>
            <div class='row width-80' id='all-feeds'>
                <?php include './includes/functions/get_posts.inc.php' ?>
            </div>
        </div>
    </div>
    <script>
        textLimit('#post', 500, "#postBtn");
    </script>
<?php include './includes/footer.php' ?>