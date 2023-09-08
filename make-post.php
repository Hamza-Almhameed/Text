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
    <link rel="stylesheet" href="make-post.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>عمل منشور</title>
</head>
<body dir="rtl">
    
    <div id="loader"><img src="resources/loader.gif"></div>


    <form action="make-post.php" method="post">
        <h1>منشور جديد</h1>

        <div>
            <h2>اكتب منشورك</h2>
            <textarea name="content" placeholder="اكتب هنا (الحد الأقصى ألف حرف)"></textarea>
        </div>
        
        <input type="submit" name="submit" value="نشر !">

        <p style="color: red;"><?php
            if (isset($_GET['errID'])) {
                if($_GET['errID'] == 1){
                    echo 'المنشور لا يمكن ان يكون فارغ';
                }
            }
            
        ?></p>
    </form>


    <script>
        let loader = document.getElementById('loader');
            window.onload = function () {
            loader.style.display = 'none';
        }
    </script>
</body>
</html>


<?php

if (isset($_POST['submit'])) {
    $poster = $user['id'];
    $content = $_POST['content'];
    if ($content !== "") {
        mysqli_query($db_connection,"INSERT INTO `posts`(`poster_id`,`content`) VALUES('$poster','$content')");
        header('Location: index.php');
    }else{
        header('Location: make-post.php?errID=1');
    }
    
}

?>