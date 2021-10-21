<?php include './includes/header.php' ?>
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
            <?php
                if(isset($_GET['msg'])){
                    echo "<p class='msg danger'><i class='fa fa-exclamation-circle'></i> 
                    Token has expired or is invalid. Send another one.</p>";
                }
            ?>
            <p></p>
            <h3 class='mt-5'>Recover your account</h3>
            <p>An e-mail will be sent to you with instructions on how to reset your password. You have <b>30min</b> to reset your password.</p>
            <div class='mt-3' id="message"></div>
            <form method='POST' class='main-form mt-2'>
                <input type='text' id='email' placeholder='E-mail'>
                <button onclick='forgotPassword(); return false;' name='reset-request-submit' class='main-form-login'>Request new password</button>
                <a class='main-form-signup' href="/">Home</a>
            </form>
        </div>
    </div>
<?php include './includes/footer.php' ?>