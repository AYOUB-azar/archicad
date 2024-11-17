<?php 
session_start();
include('inc/connections.php');

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = stripcslashes(strtolower($_POST['username']));
    $password = $_POST['password'];
    $md5_pass = md5($password);

    // تنظيف وإعداد المدخلات
    $username = htmlentities(mysqli_real_escape_string($conn, $username));
    $password = htmlentities(mysqli_real_escape_string($conn, $password));

    $err_s = 0; // Initialize error flag

    // التحقق من القيم المدخلة
    if(empty($username)){
        $user_error = '<p id="error"> please insert username </p>';
        $err_s = 1;
    }
    if(empty($password)){
        $pass_error = '<p id="error"> please insert password </p>';
        $err_s = 1;
    }

    // إذا لم تكن هناك أخطاء، تحقق من قاعدة البيانات
    if($err_s == 0){
        $sql = "SELECT id, username, md5_pass FROM users WHERE username='$username' AND md5_pass='$md5_pass'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // تحقق من وجود المستخدم
        if($row && $row['username'] === $username && $row['md5_pass'] === $md5_pass){
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            header('Location: home.php');
            exit();
        } else{
            $user_error = '<p id="error"> worng usrname or password !!</p>';
            include('index copy.php');
            exit();
        }
    }

}


?>
