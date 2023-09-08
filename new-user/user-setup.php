<?php
require '../config.php';

if(!isset($_SESSION['login_id'])){
    header('Location: ../login/login.php');
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
    <link rel="stylesheet" href="setupStyle.css">

    
    <title>تعديل البيانات</title>
</head>
<body dir='rtl'>
    <form action="user-setup.php" method="post">

        <div>
            <img src="../resources/logo.png">
            <h1>مرحبا في مجتمع <span>نص</span></h1>
        </div>
        

        <div>
            <input type="text" placeholder="اسمك" name="name" class="textinp">
            <input type="text" placeholder="اسم المستخدم" name="username" class="textinp" id="username">
            <p style="text-align: center;">اسم المستخدم يجب ان يكوم بأحرف انجليزية <br> وارقام فقط</p>
        </div>
        
        <input type="submit" value="حفظ" name="submit" id="submit">
        <p style="color: red;"><?php
            if (isset($_GET['errID'])) {
                if($_GET['errID'] == 1){
                    echo 'اسمك لا يمكن ان يكون فارغ';
                }elseif($_GET['errID'] == 2){
                    echo 'اسم المستخدم لا يوافق المعايير';
                }
            }
            
        ?></p>
    </form>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $id = $user['id'];
    $regex = '/^[A-Za-z][A-Za-z0-9][A-Za-z_][A-Za-z0-9_]{1,31}$/';
    $username = $_POST['username'];
    $errID;
    if($name == ""){
        $errID = "1";
        header("Location: user-setup.php?errID=1");
    }elseif(!preg_match($regex, $username)){
        $errID = "2";
        header("Location: user-setup.php?errID=2");
    }else{
        mysqli_query($db_connection,"update `users` set name='$name', username='$username' where id='$id'");
        header('Location: ../index.php');
    }
    
}
?>