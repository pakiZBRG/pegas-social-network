<?php 
    include './includes/header.php';

    if(sizeof($_SESSION) != 0){
        if($_SESSION["userEmail"]) {
            header("Location: /pegas/home");
        }
    }
?>
    <div class="row">
        <div class="col-sm-12">
            <div class="logo">
                <img src="img/pegas.png" alt="logo" class='logo-img'>
                <h1 class='logo-name'>pegas</h1>
                <h1 class='logo-name'>network</h1>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 main">
            <h2 class='main-join'>Join the Pegas</h2>
            <div id="message"></div>
            <form method="POST" class='main-form'>
                <input type='text' id='mailuid' placeholder="Username or E-mail">
                <input type='password' id='pwd' placeholder="Password">
                <a class='main-form-forgot' href="forgot-password">Forgotten password?</a>
                <button onclick="logIn(); return false;" class="main-form-login" name='login'>
                    Login
                </button>
                <?php include "./includes/googleButton.php" ?>
                <a class='main-form-signup' href='signup'>Create an account</a>
            </form>
        </div>
    </div>
<?php include "./includes/footer.php" ?>