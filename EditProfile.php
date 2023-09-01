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
    <link rel="stylesheet" href="EditProfile.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>تعديل الملف الشخصي</title>
</head>
<body dir='rtl'>

    <div id="loader"><img src="resources/loader.gif"></div>

    <h1>تعديل الملف الشخصي</h1>

    <form action="EditProfile.php" method="post">
        <div>
            <h2>الاسم :</h2>
            <input type="text" placeholder="اسمك" name="name" class="textinp">
        </div>

        <div>
            <h2>نبذة تعريفية :</h2>
            <textarea name="bio" placeholder="نبذة"></textarea>
        </div>
        
        <input type="submit" value="حفظ" name="submit" id="submit">

        <p style="color: red;"><?php
            if (isset($_GET['errID'])) {
                if($_GET['errID'] == 1){
                    echo 'اسمك لا يمكن ان يكون فارغ';
                }elseif($_GET['errID'] == 2){
                    echo 'لا يمكن للنبذة التعريفية ان تتجاوز 250 حرف';
                }
            }
            
        ?></p>
    </form>



    <script src="script.js"></script>
</body>
</html>


<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $id = $user['id'];
    $errID;
    if($name == ""){
        $errID = "1";
        header("Location: EditProfile.php?errID=1");
    }elseif(strlen($bio) >= 250){
        $errID = "2";
        header("Location: EditProfile.php?errID=2");
    }else{
        mysqli_query($db_connection,"update `users` set name='$name', bio='$bio' where id='$id'");
        header('Location: index.php');
    }
    
}
?>