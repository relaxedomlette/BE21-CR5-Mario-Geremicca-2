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

$sqlUsers = "SELECT * FROM user";
$resultUsers = mysqli_query($conn, $sqlUsers);
$rowUser = mysqli_fetch_assoc($resultUsers);

if (isset($_POST["create"])) {   
    $location = $_POST['location'];
    $petName = $_POST['petName'];
    $description = $_POST['description'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $vaccinated = $_POST['vaccinated'];
    $status = $_POST['status'];
    $size = $_POST['size'];
   
    $uploadError = '';
    //this function exists in the service file upload.
    $picture = file_upload($_FILES['picture'], 'animal');  
    
        $sql = "INSERT INTO `animal`( `location`, `petName`, `description`, `breed`, `age`, `picture`, `status`, `size`, `vaccinated`) VALUES ('$location','$petName','$description','$breed','$age','$picture->fileName','$status','$size','$vaccinated')";
   
    

    if (mysqli_query($conn, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'><tr>
            <td> $petName </td>
            <td> $location </td>
            </tr></table><hr>";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br>" . $conn->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage :'';
    }
    mysqli_close($conn);}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a pet to the Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
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
    </style>
</head>

<body>
    <div class="container">
        <h2>Add a pet to the Database</h2>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-<?= $class; ?>" role="alert">
                <p><?= $message ?></p>
                <p><?= $uploadError ?></p>
                <a href='dashboard.php'><button class="btn btn-primary" type='button'>Home</button></a>
            </div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="petName">Pet Name</label>
            <input type="text" id="petName" name="petName" placeholder="Type in pet name">
            <label for="type">Type</label>
            <input type="text" id="type" name="type" placeholder="Type of pet">
            <label for="breed">Breed</label>
            <input type="text" id="breed" name="breed" placeholder="Breed of pet">
            <label for="age">Age</label>
            <input type="text" name="age" placeholder="Age of pet">
            <label for="location">Location</label>
            <input type="text"  name="location" placeholder="Pet location">
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="adopted">Adopted</option>
                <option value="unclaimed">Unclaimed</option>
            </select>
            <label for="size">Size</label>
            <select id="size" name="size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
            <label for="vaccinated">Vaccinated</label>
            <select id="vaccinated" name="vaccinated">
                <option value="vaccinated">Vaccinated</option>
                <option value="not vaccinated">Not Vaccinated</option>
            </select>
            <label for="picture">Upload your picture</label>
            <input type="file" name="picture">
            <br>
            <br>
            <input type="submit" name="create" value="Create">

            </select>
            

</body>

</html>