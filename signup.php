<?php include './includes/header.php' ?>
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
        <div class="col-sm-12">
            <div class='signup'>
                <div class="signup-header">
                    <h2>Create an account</h2>
                </div>
                <div id="message">
                    <?php include 'includes/functions/insert_user.inc.php' ?>
                </div>
                <form method="POST" class='signup-form'>
                    <input type="text" id='first_name' placeholder="First Name">
                    <input type="text" id='last_name' placeholder="Last Name">
                    <input type="email" id='email' placeholder="E-mail">
                    <input type="text" id='username' placeholder="Username">
                    <p>Minimum 4 characters.</p>
                    <input type="password" id='pwd' placeholder="Password">
                    <p>Minimum 8 characters.</p>
                    <input type="password" id='pwd_repeat' placeholder="Repeat Password">
                    <button onclick="insertUser(); return false;" class='signup-form-btn' name='signup'>Signup</button>
                    <a class='signup-form-login' href='/pegas'>Already have an account?</a>
                </form>
            </div>
        </div>
    </div>
<?php include './includes/footer.php' ?>