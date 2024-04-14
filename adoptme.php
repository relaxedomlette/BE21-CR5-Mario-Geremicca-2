<?php 

session_start();

include_once 'db_connect.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// if session is set to admin this will redirect to the home page
if (isset($_SESSION['adm'])) {
    header("Location: adopted.php");
    exit;
}

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal  WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);

        $animal_id = $data['id'];
        $location = $data['location'];
        $petName= $data['petName'];
        $description = $data['description'];
        $type = $data['type'];
        $age = $data['age'];
        $breed = $data['breed'];
        $picture = $data['picture'];
        $status = $data['status'];
        $size = $data['size'];
        $vaccinated = $data['vaccinated'];

        if ($status == 'adopted') {
            // Redirect to already_adopted.php
            header("Location: alreadyAdopted.php");
            exit;
        }
    } else {
        header("location: error.php");
        exit;
    }
} else {
    header("location: error.php");
    exit;
}

$user_id = $_SESSION['user'];

// Proceed with adoption
$query = "INSERT INTO pet_adoption (fk_pet_id, fk_user_id, adoption) VALUES ('$animal_id','$user_id', CURDATE())";
if (mysqli_query($conn, $query) === true) {
    $query2 = "UPDATE `animal` SET `status` = 'adopted' WHERE `animal`.`id` = '$animal_id'";
    if (mysqli_query($conn, $query2) === true) {
        $class = "success";
        $message = "<h2>Congratulations! You adopted: </h2><br>";
        $body =$petName . "<img style='width:100%; height:300px; object-fit: contain;' src='img/$picture'>" ."Location: " . $location . "<br>".$petName ." will be a perfect friend"  ;
    } else {
        $class = "danger";
        $message = "The pet was not adopted due to: <br>" . $connect->error;
    }
} else {
    $class = "danger";
    $message = "The pet was not adopted due to: <br>" . $connect->error;
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Adopt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container text-center">
        <div class="row justify-content-evenly py-5">
            <div class="d-flex flex-column align-items-center mt-3 mb-3">
                <h1>Adoption:</h1>
            </div>
            <div class="alert alert-<?=$class;?> d-flex flex-column align-items-center" role="alert">
                <?=$message;?>
                <h2><?=$body;?></h2>
                <a href='home.php' class="btn btn-success form-control">Back</a>
            </div>
        </div>
    </div>
   </div>
</body>
</html>
