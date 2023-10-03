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


if(isset($_POST['liked'])){
    $postid = $_POST['postid'];
    $result = mysqli_query($db_connection, "SELECT * FROM posts WHERE id = $postid");
    $row = mysqli_fetch_array($result);
    $n = $row['likes'];

    mysqli_query($db_connection, "UPDATE posts SET likes=$n+1 WHERE id = $postid");
    mysqli_query($db_connection, "INSERT INTO likes (userid, postid) VALUES (".$user['id'].", $postid)");
}

if(isset($_POST['unliked'])){
    $postid = $_POST['postid'];
    $result = mysqli_query($db_connection, "SELECT * FROM posts WHERE id = $postid");
    $row = mysqli_fetch_array($result);
    $n = $row['likes'];

    mysqli_query($db_connection, "DELETE FROM likes WHERE postid = $postid");
    mysqli_query($db_connection, "UPDATE posts SET likes=$n-1 WHERE id = $postid");
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

    <title>نص</title>
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
        // $readposts = mysqli_query($db_connection, "SELECT * FROM posts ORDER BY id DESC LIMIT 1");
        // $result = mysqli_fetch_array($readposts);
        $getLastPost = mysqli_query($db_connection, "SELECT * FROM posts ORDER BY id DESC LIMIT 1");
        $lastPost = mysqli_fetch_array($getLastPost);
        // if ($readposts->num_rows > 0) {
            for ($i = $lastPost['id']+1; $i > 0; $i--) {
                $readposts = mysqli_query($db_connection, "SELECT * FROM posts WHERE id = '$i'");
                $result = mysqli_fetch_array($readposts);
                
                if ($readposts->num_rows > 0) {
                    $readposter = mysqli_query($db_connection, "SELECT * FROM users WHERE id = ".$result['poster_id']);
                    $poster = mysqli_fetch_assoc($readposter);
                    $readlikes = mysqli_query($db_connection, "SELECT * FROM likes WHERE userid = ".$user['id']." AND postid = ".$result['id']);
                    $likes = $result['likes'];
                    $comments = $result['comments'];
    
                    echo '<div class="post">
                    <div class="info">
                        <div class="head">
                            <a href="user.php?id='.$poster['id'].'"><img class="postProfile" src="'.$poster['profile_image'].'" alt="'.$poster['name'].'"></a>
                            <div>
                                <h3>'.$poster['name'].'</h3>
                                <p>'.$result['date'].'</p>
                            </div>
                        </div>
                        <button>متابعة</button>
                    </div>
    
                    <p class="post-content" id="p'.$result['id'].'">'.$result['content'].'</p>
    
                    <div class="interact">
                        <div class="likes">';

                        if(mysqli_num_rows($readlikes) !== 1){
                            echo '<a href="" class="like" id="'.$result['id'].'"><i class="fa-regular fa-heart"></i></a>
                            <span>'.$result['likes'].'</span>';
                        }else{
                            echo '<a href="" class="unlike" id="'.$result['id'].'"><i class="fa-solid fa-heart"></i></a>
                            <span>'.$result['likes'].'</span>';
                        }

                            


                        echo '</div>
                        <div class="comments">
                            <i class="fa-regular fa-comment"></i>
                            <span>'.$result['comments'].'</span>
                        </div>
                        <div class="copy" id="cp'.$result['id'].'">
                            <i class="fa-regular fa-copy"></i>
                            <span>نسخ</span>
                        </div>
                    </div>
                </div>
                <div class="sep"></div>';
                }
                
            }

        //}
        ?>


    </div>
    
    <div id="make-post">
        <a style="color: white;" href="make-post.php"><i class="fa-solid fa-plus"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>