
<?php 
session_start();
include('inc/connections.php');
if(isset($_SESSION['id']) && isset($_SESSION['username']))
{

    $id = $_SESSION['id'];
    $user = $_SESSION['username'];

$info = mysqli_query($conn,"select * from users where username='$user'");
while($date = mysqli_fetch_array($info)){

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="home.css">
</head>

<body>
<div class="home">
   <h2> <a href="logout.php">Déconnectez-vous</a></h2>
    <h1>Bienvenue :
        <?php echo $date['username']  ?>
    </h1>

    <div class="photo">
        <?php echo "<img src='images/" .$date['profile_picture']."'  alt='image not found !'>"; ?>
    

    <?php if(isset($error)) { echo $error ;} ?>

    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
        <br>
    <input type="file" name="file" id="file"><br>
    <br>
    <input type="submit" name="submit" value="UPLOAD"><br>
    </form>
    </div>

</div>   





</body>

</html>






<?php
}
}else{
    header('Location:index copy.php');
    exit();
}



?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <style>
        .body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        table {
            width: 60%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-items: center;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .view-btn {
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .download-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Le numéro</th>
                <th>Customer name</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>INV01</td>
                
                <td>VALSAD, GUJARAT</td>
                <td class="action-buttons">
                    <a href="path/to/view/invoice1.pdf" class="view-btn" target="_blank">View PDF</a>
                    <a href="path/to/download/invoice1.pdf" class="download-btn" download>Download PDF</a>
                </td>
            </tr>
            <tr>
                <td>INV02</td>
               
                <td>CHIKHLI, GUJARAT</td>
                <td class="action-buttons">
                    <a href="path/to/view/invoice2.pdf" class="view-btn" target="_blank">View PDF</a>
                    <a href="path/to/download/invoice2.pdf" class="download-btn" download>Download PDF</a>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
