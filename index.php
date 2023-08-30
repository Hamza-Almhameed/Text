<?php
require 'config.php';

if(!isset($_SESSION['login_id'])){
    header('Location: login/login.php');
    exit;
}

$id = $_SESSION['login_id'];

$get_user = mysqli_query($db_connection, "SELECT * FROM `users` WHERE `google_id`='$id'");

if(mysqli_num_rows($get_user) > 0){
    $user = mysqli_fetch_assoc($get_user);
}
else{
    header('Location: logout.php');
    exit;
}

if($user['username'] == ''){
    header('Location: logout.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="shortcut icon" href="resources/logo.png" type="image/x-icon">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    
    <!-- global css file -->
    <link rel="stylesheet" href="global/style-global.css">

    <!-- local css file -->
    <link rel="stylesheet" href="style.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title><?php echo $user['name']; ?> - نص</title>
</head>
<body dir='rtl'>

    <div id="loader"><img src="resources/loader.gif"></div>
    
    <!-- <div id="info">
        <img src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>">
        <h1><?php echo $user['name']; ?></h1>
        <p><?php echo $user['username']; ?></p>
        <a href="logout.php">تسجيل خروج</a>
    </div> -->

    <div id="header">
        <img id="profile" src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>">
        <img id="logo" src="resources/logo.png">
        <i class="fa-solid fa-bars"></i>
    </div>

    <div id="posts"></div>

    <div id="make-post">
        <i class="fa-solid fa-plus"></i>
    </div>

    <script src="script.js"></script>
</body>
</html>