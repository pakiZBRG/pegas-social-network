<?php 

    require realpath($_SERVER["DOCUMENT_ROOT"]) . "/includes/db.inc.php";
    require realpath($_SERVER["DOCUMENT_ROOT"]) . "/includes/helpers/Messages.php";

    if(sizeof($_GET) == 0) {
        $sql = "SELECT * FROM users";
        $stmt = mysqli_prepare($conn, $sql);
    } else {
        if(array_key_exists("search", $_GET)){
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $search = "$search%";
            $sql = "SELECT * FROM users WHERE first_name LIKE ? OR last_name LIKE ? OR username LIKE ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
        }
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $user_id = $row["id"];
        $first_name = $row['first_name'];
        $last_name = $row["last_name"];
        $username = $row["username"];
        $img = $row["profile_image"];
        $followers = $row["followers"];

        echo "
            <div class='row width-80'>
                <div class='col-sm-12 connect-card'>
                    <div class='connect-card-row'>
                        <a href='/profile/$username'>
                            <img src='$img' alt='profile' title='$username'>
                        </a>
                        <div class='connect-card-col'>
                            <h5><a href='/profile/$username'>$username</a></h5>
                            <h6>$first_name $last_name</h6>
                        </div>
                        <p>Followers <span>$followers</span></p>
                    </div>
                </div>
            </div>
        ";
    }

?>