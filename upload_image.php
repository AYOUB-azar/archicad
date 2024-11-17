<?php

include('inc/connections.php');
if(empty($_POST['file'])){
    $error = 'please choose photo to upload';
    include_once('home.php');
}else{
    session_start();
}


if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    $user = $_SESSION['username'];

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];
    $file_tmp = $file['tmp_name'];

    $file_ext = explode('.', $file_name);
    $file_actual_ext = strtolower(end($file_ext));
    $allowed = array('jpg', 'jpeg', 'png', 'svg');

    if(in_array($file_actual_ext, $allowed)) {
        if($file_error === 0) { // 10000 = 1mb
            if($file_size < 3000000) {
                $file_new_name = uniqid('', true) . '.' . $file_actual_ext;
                $target = 'images/' . $file_new_name;
                $username = $_SESSION['username'];
                $sql = "UPDATE users SET profile_picture='$file_new_name' WHERE username='$username'";
                mysqli_query($conn, $sql);
                move_uploaded_file($file_tmp, $target);
                header('Location:home.php');
            } else {
                $error = 'Your photo is too big!';
                include_once('home.php');
            }
        } else {
            $error = 'Error uploading photo';
            include_once('home.php');
        }
    } else {
        $error = 'You cannot upload this type of file';
        include_once('home.php');
    }
} else {
    $error = 'Please choose a photo';
    include_once('home.php');
}
}
?>