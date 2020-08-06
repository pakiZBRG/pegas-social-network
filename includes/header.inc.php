<?php
    include "database.inc.php";
    include 'functions.inc.php';
?>

<nav class='nav'>
    <div class='container-fluid nav-flex'>
        <div class="nav-header">
            <img src='img/pegas.png' logo="pegas" class='nav-header-logo'>
            <a href="home.php" class='nav-header-brand'>Pegas</a>
        </div>
        <div class='nav-article'>
            <ul class='nav-article-content'>
                <?php
                    $userId = $_SESSION['userId'];
                    $sql = "SELECT * FROM users WHERE id='$userId';";
                    $run_user = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($run_user);

                    $user_id = $row["id"];
                    $user_name = $row["username"];
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $email = $row["email"];
                    $password = $row["password"];
                    $describe_user = $row["describe_user"];
                    $profile_image = $row["profile_image"];
                    $cover_image = $row["cover_image"];
                    $register_date = $row["register_date"];

                    $user_sql = "SELECT * FROM posts WHERE user_id='$user_id';";
                    $run_posts = mysqli_query($conn, $user_sql);
                    $posts = mysqli_num_rows($run_posts);
                ?>
                <li><a href='profile.php?<?php echo "u_id=$user_id" ?><?php echo "&username=$user_name"; ?>' title='View profile'><?php echo "$user_name"; ?></a></li>
                <li><a href='home.php' title='View Feed'>Home</a></li>
                <li><a href='members.php?<?php echo "u_id=$user_id"; ?>'>Connect</a></li>
                <li><a href='messages.php?<?php echo "u_id=$user_id"; ?>&username='>Messages</a></li>
                <?php 
                    echo "
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria=haspopup='true' aria-expanded='false'></a>
                            <ul class='dropdown-menu'>
                                <li>
                                    <a href='my_post.php?u_id=$user_id'>My Posts <span class='dropdown-menu-badge'>$posts</span></a>
                                </li>
                                <li>
                                    <a href='edit_profile.php?u_id=$user_id'>Edit Account</a>
                                </li>
                                <li role='separator' class='divider'></li>
                                <li>
                                    <a href='logout.php'>Logout</a>
                                </li>
                            </ul>
                        </li>
                    ";
                ?>
            </ul>
        </div>
        <div class='nav-search'>
            <form action='results.php' class='nav-search-form' method='GET'>
                <input type='text' name='user_search' placeholder='Search posts'>
                <button type='submit' class='nav-search-btn' name='search' title='Search'><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</nav>