<?php 
include('inc/connections.php');
if(isset($_POST["submit"])) {
    $username = stripslashes(strtolower($_POST["username"]));
    $email = stripslashes($_POST["email"]);
    $password = stripslashes($_POST["password"]);

    if(isset($_POST["birthday_month"]) && isset($_POST["birthday_day"]) && isset($_POST["birthday_year"])) {
        $birthday_month = (int)$_POST["birthday_month"];
        $birthday_day = (int)$_POST["birthday_day"];
        $birthday_year = (int)$_POST["birthday_year"];
        $birthday = htmlentities(mysqli_real_escape_string($conn, $birthday_day."-".$birthday_month."-".$birthday_year));
    }

    $username = htmlentities(mysqli_real_escape_string($conn, $_POST['username']));
    $email = htmlentities(mysqli_real_escape_string($conn, $_POST['email']));
    $password = htmlentities(mysqli_real_escape_string($conn, $_POST['password']));
    $md5_pass = md5($password);

    // $err_s = 0; // Initialize error flag

    if(isset($_POST["gender"])) {
        $gender = ($_POST['gender']);
        $gender = htmlentities(mysqli_real_escape_string($conn, $_POST['gender']));
        if(!in_array($gender, ["Male", "Female"])) {
            $gender_error = "<p id='error'> Please choose a valid gender! </p><br>";
            $err_s = 1;
        }
    } else {
        $gender_error = "<p id='error'> Please choose gender </p>";
        $err_s = 1;
    }

    $check_user = "SELECT * FROM `users` WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_user);
    $num_rows = mysqli_num_rows($check_result);
    if($num_rows != 0) {
        $user_error = '<p id="error"> Sorry, username already exists. Please choose another one. </p><br>';
        $err_s = 1;
    }

    if(empty($username)) {
        $user_error = "<p id='error'> Please enter username </p>";
        $err_s = 1;
    } elseif(strlen($username) < 6) {
        $user_error = " <p id='error'> Your username needs to have a minimum of 6 letters </p>"; 
        $err_s = 1;
    } elseif(filter_var($username, FILTER_VALIDATE_INT)) {
        $user_error = "<p id='error'> Please enter a valid username, not a number </p>"; 
        $err_s = 1;
    }

    if(empty($email)) {
        $email_error = "<p id='error'> Please insert email </p>";
        $err_s = 1;
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "<p id='error'> Please insert a valid email </p>";
        $err_s = 1;
    }
    if(empty($gender)) {
        $gender_error = "<p id='error'> Please insert gender </p>";
        $err_s = 1;
    }

    if(empty($birthday)) {
        $birthday_error = "<p id='error'> Please insert date of birth </p>";
        $err_s = 1;
    }

    if(empty($password)) {
        $pass_error = "<p id='error'> Please insert password </p>";
        $err_s = 1;
        include('register.php');
    } elseif(strlen($password) < 6) {
        $pass_error = "<p id='error'> Your password needs to have a minimum of 6 letters </p>";
        $err_s = 1;
        include('register.php');
    }
else{
    if($err_s == 0 && $num_rows == 0) {
        if($gender == 'Male'){
            $profile_picture = 'no-profile-picture-male.png';
        } elseif($gender == 'Female'){
            $profile_picture = 'no-profile-picture-female.png';
        }

        $sql = "INSERT INTO users(username, email, password, birthday, gender, md5_pass, profile_picture)
                VALUES ('$username', '$email', '$password', '$birthday', '$gender', '$md5_pass', '$profile_picture')";
        mysqli_query($conn, $sql);
        header("Location:index copy.php");
        exit();
    } else {
        include("register.php");
    }
}
}
?>
