<?php
session_start();

require "db_connect.php";




if($_GET["id"]) {
    $id = $_GET["id"];
    $sql= "SELECT * FROM animal WHERE id = {$id}";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
    } else {
        header("location: error.php");
    }
    mysqli_close($conn);
} else {
    header("location: error.php");
}

// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: login.php");
// }




// $id = $_GET["id"];

// $sql = "SELECT * FROM `animal` WHERE id = {$id}";


// $result = mysqli_query($conn, $sql);

// $rows = mysqli_fetch_assoc($result);


foreach($rows as $row) {

$layout = '<div class=" mb-5 col col-12 d-flex align-items-stretch">
<div class="row g-1 container-fluid card shadow-lg bg-card-color">
<img style="width:500px; height:600px; object-fit: cover; margin:auto" src=../img/'.$row["picture"].' class="card-img-top" alt="...">
<div class="card-body">
  <h5 class="card-title">'.$row["petName"].'</h5>
  <hr>
  <p class="card-text">Location : '.$row["location"].'</p>
  <p class="card-text">Description: '.$row["description"].'</p>
  <p class="card-text">Type: '.$row["type"].'</p>
  <p class="card-text">Breed: '.$row["breed"].'</p>
  <p class="card-text">Age: '.$row["age"].'</p>
  <p class="card-text">Vaccinated: '.$row["vaccinated"].'</p>
  <p class="card-text">Status: '.$row["status"].'</p>
  <p class="card-text">Size: '.$row["size"].'</p>
  <a href="adoptme.php?id='.$id.'" class="btn btn-success form-control">Take me home</a>
  
     
  
  
</div>
</div>
</div>
';
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
       .detailsProp{
        justify-content: center;
        align-items: center;
        text-align: center;
        border: black solid 2px;
       }
       .textRow{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
       }
       .card-text, .card-title{
        text-align: center;
       }
    </style>
    

</head>

<body>
    <div class="container" >

        <?= $layout ?>

    </div>
    <a class="btn btn-danger" href="dashboard.php">Back</a>
</body>

</html>