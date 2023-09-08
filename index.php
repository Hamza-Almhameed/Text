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

    <div id="header">
        <a href="profile.php"><img id="profile" src="<?php echo $user['profile_image']; ?>" alt="<?php echo $user['name']; ?>"></a>
        <img id="logo" src="resources/logo.png">
        <i class="fa-solid fa-bars"></i>
    </div>

    <div id="posts">


        <?php
        //loading posts
        $readposts = mysqli_query($db_connection, "SELECT * FROM posts ORDER BY rand()");
        $result = mysqli_fetch_array($readposts);
        if ($readposts->num_rows > 0) {
            for ($i = 0; $i < $readposts->num_rows; $i++) {
                $readposter = mysqli_query($db_connection, "SELECT * FROM users WHERE id = ".$result['poster_id']);
                $poster = mysqli_fetch_assoc($readposter);
                $likes = $result['likes'];
                $comments = $result['comments'];

                echo '<div class="post">
                <div class="info">
                    <div class="head">
                        <img class="postProfile" src="'.$poster['profile_image'].'" alt="'.$poster['name'].'">
                        <div>
                            <h3>'.$poster['name'].'</h3>
                            <p>'.$result['date'].'</p>
                        </div>
                    </div>
                    <button>متابعة</button>
                </div>

                <p class="post-content">'.$result['content'].'</p>

                <div class="interact">
                    <div class="likes">
                        <i class="fa-regular fa-heart"></i>
                        <span>'.$result['likes'].'</span>
                    </div>
                    <div class="comments">
                        <i class="fa-regular fa-comment"></i>
                        <span>'.$result['comments'].'</span>
                    </div>
                    <div class="copy">
                        <i class="fa-regular fa-copy"></i>
                        <span>نسخ</span>
                    </div>
                </div>
            </div>
            <div class="sep"></div>';
            }

        }
        ?>


    </div>

    <div id="make-post">
        <a style="color: white;" href="make-post.php"><i class="fa-solid fa-plus"></i></a>
    </div>

    <script src="script.js"></script>
</body>
</html>