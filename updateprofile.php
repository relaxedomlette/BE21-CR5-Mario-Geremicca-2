<?php

session_start();

require_once "db_connect.php";
require_once "file_upload.php";

$session = 0;
$goBack = "";

if (isset($_SESSION["admin"])) {
    $session = $_SESSION["admin"];
    $goBack = "dashboard.php";
} else {
    $session = $_SESSION["user"];
    $goBack = "home.php";
}

$sql = "SELECT * FROM user WHERE id = {$session}";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if (isset($_POST["update"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $birthDate = $_POST["birthDate"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];
    $picture = file_upload($_FILES["picture"]);


    $pictureArray = file_upload($_FILES['picture']); 
    $picture = $pictureArray->fileName;

    if ($pictureArray->error == 4) {
        $update = "UPDATE `user` SET `firstName`='{$firstName}',`lastName`='{$lastName}',`birthDate`='{$birthDate}',`email`='{$email}',`address`='{$address}',`phoneNumber`='{$phoneNumber}' WHERE id = {$session}";
    } else {
        if ($row["picture"] != "../img/account.png") {
            unlink("../img{$row["picture"]}");
        }
        $update = "UPDATE `user` SET `firstName`='{$firstName}',`lastName`='{$lastName}',`birthDate`='{$birthDate}',`email`='{$email}',`address`='{$address}',`phoneNumber`='{$phoneNumber}', `picture`='{$pictureArray->fileName}' WHERE id = {$session}";
    }

    if (mysqli_query($conn, $sql) === true) {     
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=home.php?id={$id}");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
    }


    $result = mysqli_query($conn, $update);

    header("Location: {$goBack}");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style> .container {
            max-width: 600px;
            margin: auto;
            padding-top: 50px;
        }

        form {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="4"><path fill="%23666" d="M2 0l6 4 6-4"/></svg>') no-repeat right 10px center/8px 4px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            width: auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }
        #date{
            width: 100%; 
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px; box-sizing: border-box;
        }
        
        </style>
</head>

<body>
<div class="container">
        <h2>Update Profile</h2>
        <?php if (!empty($message)) : ?>
           <!-- ' updateError & massage noch bearbeiten' -->
            <div class="alert alert-<?= $class; ?>" role="alert">
                <p><?= $message ?></p>
                <p><?= $updateError ?></p> 
                <a href='dashboard.php'><button class="btn btn-primary" type='button'>Home</button></a>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
    <label for="firstName">First Name</label>
    <input type="text" name="firstName" placeholder="Change first name" value="<?= isset($row["firstName"]) ? $row["firstName"] : '' ?>">
    <label for="lastName">Last Name</label> 
    <input type="text" name="lastName" placeholder="Change last name" value="<?= isset($row["lastName"]) ? $row["lastName"] : '' ?>">
    <label for="email">E-mail</label>
    <input type="text" name="email" placeholder="Change email" value="<?= isset($row["email"]) ? $row["email"] : '' ?>">
    <label for="password">Password</label>
    <input type="text" name="password" placeholder="Change password" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" >
    <label for="birthDate">Birth Date</label>
    <input type="date" id="date" name="birthDate" placeholder="Change birth date" value="<?= isset($row["birthDate"]) ? $row["birthDate"] : '' ?>">
    <br> <br>
    <label for="phoneNumber">Phone Number</label>
    <input type="text" name="phoneNumber" placeholder="Change phone Number" value="<?= isset($row["phoneNumber"]) ? $row["phoneNumber"] : '' ?>">
    <label for="address">Address</label>
    <input type="text" name="address" placeholder="Change address" value="<?= isset($row["address"]) ? $row["address"] : '' ?>"></input>
    <br><br>
    <label for="picture">Change your profile picture</label>
    <input type="file" id="picture" name="picture">
    <br>
    <br>
    <input type="submit" name="update" value="Update">
</form>
</body>

</html>