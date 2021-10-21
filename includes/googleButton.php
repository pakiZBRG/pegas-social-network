<?php

    require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');    
    $dotenv = Dotenv\Dotenv::createImmutable(realpath($_SERVER["DOCUMENT_ROOT"]))->load();
    $API_KEY = $_ENV["GOOGLE_API_KEY"];
    $API_SECRET = $_ENV["GOOGLE_API_SECRET"];
    $redirectUrl = "https://pegas.herokuapp.com/home";

    $client = new Google\Client();

    $client->setClientId($API_KEY);
    $client->setClientSecret($API_SECRET);
    $client->setRedirectUri($redirectUrl);
    $client->addScope("profile");
    $client->addScope("email");

    // echo($_GET["code"]);
    if(isset($_GET["code"])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        print_r($token);
        $client->setAccessToken($token);

        $auth = new Google_Service_Oauth2($client);
        $google_info = $auth->userinfo->get();
        
        $email = $google_info->email;
        $_SESSION["userEmail"] = $email;
        header("Location: $redirectUrl");
    } else {
        if(str_contains($_SERVER["PHP_SELF"], "index")) {
            echo "
                <a href='".$client->createAuthUrl()."' class='main-form-google'>
                    <i class='fa fa-google'></i> Login with google
                </a>";
        }
    }
?>