<?php
session_start();

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}


require_once "db_connect.php";
require_once "file_upload.php";
require_once "functions.php";



$error = false;
$fnameError = $firstName = $lnameError = $lastName = $emailError = $email = $passError = $dateError = $birthDate = $addressError = $address = $phoneError = $phoneNumber = "";



if (isset($_POST["register"])) {
    $firstName = cleanInput($_POST["firstName"]);
    $lastName = cleanInput($_POST["lastName"]);
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);
    $birthDate = cleanInput($_POST["birthDate"]);
    $phoneNumber = cleanInput($_POST["phoneNumber"]);
    $address = cleanInput($_POST["address"]);
    $picture = file_upload($_FILES["picture"]);


    

    if (empty($firstName)) {
        $error = true;
        $fnameError = "You can't leave the first name empty";
    } elseif (strlen($firstName) < 3) {
        $error = true;
        $fnameError = "First name must be at least 3 characters long";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $firstName)) {
        $error = true;
        $fnameError = "First name can only contain letters and spaces";
    }

    

    if (empty($lastName)) {
        $error = true;
        $lnameError = "You can't leave the last name empty";
    } elseif (strlen($lastName) < 3) {
        $error = true;
        $lnameError = "Last name must be at least 3 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lastName)) {
        $error = true;
        $lnameError = "Last name must contain only letters and spaces";
    }

   
    if (empty($email)) {
        $error = true;
        $emailError = "Email can't be empty";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "please, enter a valid email";
    } else {
        $sql = "SELECT email FROM `user` WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Email already exists!";
        }
    }
    
    if (empty($address)) {
        $error = true;
        $addressError = "Address can't be empty";
    
    } else {
        $sql = "SELECT address FROM `user` WHERE address = '{$address}'";
        $result = mysqli_query($conn, $sql);
    }

    if (empty($phoneNumber)) {
        $error = true;
        $phoneError = "Phone number can't be empty";
    
    } else {
        $sql = "SELECT phoneNumber FROM `user` WHERE phoneNumber = '{$phoneNumber}'";
        $result = mysqli_query($conn, $sql);
    }

   
    if (empty($password)) {
        $error = true;
        $passError = "You can't leave the password empty";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "password must be at least 6 chars";
    }

    $uploadResult = file_upload($_FILES["picture"]);

    if ($uploadResult->error === 0) {
        $picture = $uploadResult->fileName;
} else {
    $picture = '../img/account.png'; // oder einen Standardpfad für das Bild setzen
}



   

    if (empty($birthDate)) {
        $error = true;
        $dateError = "please select the date of birth";
    }

    if (!$error) {
        $password = hash("sha256", $password);

        $insertQuery = "INSERT INTO `user`( `firstName`, `lastName`, `password`, `birthDate`, `email`, `picture`) VALUES ('{$firstName}','{$lastName}', '{$password}', '{$birthDate}', '{$email}', '{$picture}')";


        $result = mysqli_query($conn, $insertQuery);

        if ($result) {
            echo "Success";
            $firstName = $lastName = $birthDate = $email = "";
            header("location: login.php");
        } else {
            echo "Error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
 .textCenter{
            text-align: center;
        }

</style>
</head>

<body>

<div class="container">
        <br>
        <h1 class="textCenter">Register now</h1>
        <br>
   
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="firstName" placeholder="What is your first name" class="form-control" value="<?= $firstName ?>">
            <p class="text-danger"><?= $fnameError ?></p>
            <input type="text" name="lastName" placeholder="What is your last name" class="form-control" value="<?= $lastName ?>">
            <p class="text-danger"><?= $lnameError ?></p>
            <input type="email" name="email" placeholder="What is your email" class="form-control" value="<?= $email ?>">
            <p class="text-danger"><?= $emailError ?></p>
            <input type="password" name="password" placeholder="What is your password" class="form-control">
            <p class="text-danger"><?= $passError ?></p>
            <input type="date" name="birthDate" class="form-control" value="<?= $birthDate ?>">
            <p class="text-danger"><?= $dateError ?></p>
            <input type="text" name="phoneNumber" placeholder="What is your phone number" class="form-control" value="<?= $phoneNumber ?>">
            <p class="text-danger"><?= $phoneError ?></p>
            <input type="text" name="address" placeholder="What is your address" class="form-control" value="<?= $address ?>">
            <p class="text-danger"><?= $addressError ?></p>

            <input type="file" name="picture" class="form-control">
            <br>
            <input class="btn form-control btn-light " type="submit" name="register" value="Register now" class="btn btn-primary">
            <br><br><p class="textCenter">or</p>
            <a href="login.php" class="btn btn-primary form-control">Login</a>
          
        </form>
    </div>
</body>

</html>