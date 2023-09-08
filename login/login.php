<?php
require '../config.php';

if(isset($_SESSION['login_id'])){
    header('Location: ../index.php');
    exit;
}

require 'google-api/vendor/autoload.php';

// Creating new google client instance
$client = new Google_Client();

// Enter your Client ID
$client->setClientId('889247687559-46qdbc68l5dqs09g9a7fc3oq569neleh.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('http://localhost:8080/Text/login/login.php');

// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");


if(isset($_GET['code'])):

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if(!isset($token["error"])){

        $client->setAccessToken($token['access_token']);

        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
    
        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);

        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `google_id` FROM `users` WHERE `google_id`='$id'");
        if(mysqli_num_rows($get_user) > 0){

            $_SESSION['login_id'] = $id; 
            header('Location: ../index.php');
            exit;

        }
        else{

            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `users`(`google_id`,`name`,`email`,`profile_image`) VALUES('$id','$full_name','$email','$profile_pic')");

            if($insert){
                $_SESSION['login_id'] = $id; 
                header('Location: ../new-user/user-setup.php');
                exit;
            }
            else{
                echo "فشل في تسجيل الدخول";
            }

        }

    }
    else{
        header('Location: login.php');
        exit;
    }
    
else: 
    // Google Login Url = $client->createAuthUrl(); 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="shortcut icon" href="../resources/logo.png" type="image/x-icon">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    
    <!-- global css file -->
    <link rel="stylesheet" href="../global/style-global.css">

    <!-- local css file -->
    <link rel="stylesheet" href="./loginstyle.css">
    
    <title>نص - تسجيل دخول</title>
</head>


<body dir='rtl'>

    <div id="loader"><img src="../resources/loader.gif"></div>

    <div id="login">
        <img src="../resources/logo.png">
        <h1>مرحبا في مجتمع <span>نص</span></h1>

        <!-- <form action="loginProcess.php" method="post">
            <div>
                <input type="email" name="email" placeholder="البريد الالكتروني" class="input">
                <input type="password" name="password" placeholder="كلمة المرور" class="input">
            </div>
            
            <input type="submit" name="submit" value="تسجيل!" class="submit">
        </form>

        <div id="sep"></div> -->
        <a type="button" class="login-with-google-btn" href="<?php echo $client->createAuthUrl(); ?>">
            تسجيل باستخدام جوجل
        </a>
    </div>

    <script src="loginscript.js"></script>
</body>
</html>

<?php endif; ?>