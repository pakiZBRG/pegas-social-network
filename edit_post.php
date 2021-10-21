<?php
    include "./includes/header.php";
    include "./includes/nav.php";
    include './includes/db.inc.php';

    if(isset($_GET)) {
        $postId = mysqli_real_escape_string($conn, $_GET["post_id"]);
        
        $sql = "SELECT * FROM posts WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $postId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
            $content = $row["post_content"];
            $imageUrl = $row["upload_image"];
            $date = $row['post_date'];
            $formatDate = substr(date_format(date_create($date), DATE_RFC1123), 4, 18);
        }
    }
?>

    <div class="row width-90 mx-auto">
        <div class='col-sm-12'>
            <h1 class='my-4 text-center'>Edit Post</h1>
            <div id="message" class='mb-3'></div>
            <form method='POST' enctype='multipart/form-data' id='updatePost' class='edit-form mx-auto'>
                <div class='form_control'>
                    <textarea name='content' id='content' rows='4'><?php echo $content ?></textarea>
                </div>
                <div class='limit'>
                    <div id='length'></div>
                </div>
                <div class="home-card-img">
                    <?php echo ($imageUrl ? "<img class='home-card-img' name='image' id='showImg' src='/pegas/$imageUrl'>" : null) ?>
                    <label class='chooseImgBtn' title='Choose an image'>
                        <i class="fa fa-folder-open" style='padding: 0.3rem'></i>
                        <input type='file' name='image' onchange="loadFile(event)">
                    </label>
                </div>
                <input type="hidden" name="postId" value="<?php echo $postId; ?>">
                <div class='home-card-footer mt-4'>
                    <span class='card m-1'>
                        <button id='editPost' class='card-btn accept'>
                            <i class='fa fa-check'></i>
                        </button>
                    </span>
                    <span class='card m-1' href='/pegas/profile/<?php echo $user_name; ?>'>
                        <button class='card-btn decline'>
                            <i class='fa fa-times'></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <script>
        textLimit('#content', 500, '#editPost');
    </script>

<?php include "./includes/footer.php";?>