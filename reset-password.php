<?php
    require "/app/includes/db.inc.php";
    
    $selector = $_GET["selector"];
    $validator = explode("/", $_SERVER["REQUEST_URI"])[4];
    $currentDate = date("U");
    
    // if token  is expired or invalid redirect to forgot-password page
    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=?;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $selector);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        header("Location: /forgot-password/invalid");
    } else if($row["pwdResetExpires"] < $currentDate){
        // Remove token if expired
        header("Location: /forgot-password/invalid");
        $sql = "DELETE FROM pwdreset WHERE pwdResetExpires < ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $currentDate);
        mysqli_stmt_execute($stmt);
    }
?>
<?php include '/app/includes/header.php' ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="logo">
                <img src="/img/pegas.png" alt="logo" class='logo-img'>
                <h1 class='logo-name'>pegas</h1>
                <h1 class='logo-name'>network</h1>
            </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-12 main'>
            <div class='mt-2' id="message"></div>
            <form method='POST' class='main-form mt-3'>
                <?php
                    $selector = $_GET["selector"];
                    $validator = explode("/", $_SERVER["REQUEST_URI"])[4];
                ?>
                <input type='hidden' id='selector' value='<?php echo $selector; ?>'>
                <input type='hidden' id='validator' value='<?php echo $validator; ?>'>
                <input type='password' id='pwd' placeholder='New password'>
                <input type='password' id='pwd-repeat' placeholder='Repeat password'>
                <button onclick='resetPassword(); return false;' name='reset-password-submit' class='main-form-login'>Reset password</button>
                <a class='main-form-forgot' href="/forgot-password">Forgotten password?</a>
            </form>
        </div>
    </div>
<?php include '/app/includes/footer.php' ?>