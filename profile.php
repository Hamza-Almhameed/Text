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
    <link rel="stylesheet" href="profile.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>نص - <?php echo $user['name']; ?></title>
</head>
<body dir='rtl'>
    
    <div id="loader"><img src="resources/loader.gif"></div>

    <div id="header"><img src="resources/logo.png"></div>

    <div id="profile">
        <img id="pfp" src="<?php echo $user['profile_image']; ?>">
        <div id="title">
            <h1 id="name"><?php echo $user['name']; ?></h1>
            <a href="#">تعديل الملف الشخصي</a>
        </div>
        
        <div id="user-followers">
            <p id="username"><?php echo $user['username']; ?></p>
            <span style="color: #CABBFF; font-weight: 800; font-size:larger">-</span>
            <p id="followers"><?php echo $user['followers']; ?> متابع</p>
        </div>
        <div id="badges">
            <?php echo $user['badges']; ?>
            
            <!-- <div class="badge" id="creator">المؤسس <i class="fa-solid fa-seedling"></i></div>
            <div class="badge" id="staff">الادارة <i class="fa-solid fa-shield-halved"></i></div>
            <div class="badge" id="active">نشط <i class="fa-solid fa-bolt"></i></div>
            <div class="badge" id="writer">كاتب <i class="fa-solid fa-pen"></i></div>
            <div class="badge" id="interractive">متفاعل <i class="fa-solid fa-fire"></i></div> -->
        </div>
        <div id="bio">
            <?php
                if($user['bio'] !== ""){
                    echo "<h1>نبذة تعريفية :</h1>";
                    echo "<p>" . $user['bio'] . "</p>";
                }
            ?>
        </div>


        <div id="sep"></div>

        <div id="posts">
            <h1>المشاركات (<?php echo $user['post_count']; ?>)</h1>
        </div>
    </div>




    <script>
        let loader = document.getElementById('loader');
        window.onload = function () {
        loader.style.display = 'none';
    }
    </script>
</body>
</html>