<?php

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: ../login.php");
}

if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
}


require_once "../db_connect.php";

$id = $_GET["id"];

$sqlDeletePetAdoption = "DELETE FROM `pet_adoption` WHERE fk_pet_id = {$id}";
$resultDeletePetAdoption = mysqli_query($conn, $sqlDeletePetAdoption);

if (!$resultDeletePetAdoption) {
    echo "Error deleting records from pet_adoption table: " . mysqli_error($conn);
    exit;
}

$sql = "DELETE FROM `animal` WHERE id = {$id}";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error deleting record from animal table: " . mysqli_error($conn);
    exit;
}

// $sqlread = "SELECT * FROM animal WHERE id = {$id}";

// $resultRead = mysqli_query($conn, $sqlread);

// $row = mysqli_fetch_assoc($resultRead);



// $sql = "DELETE FROM `animal` WHERE id = {$id}";

// $result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 100px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.message {
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<div class="container">
        <div class="message">
            <h1>Entry Deleted Successfully</h1>
            <p>Thank you for maintaining the database!</p>
            <div class="navigation">
                <a href="../dashboard.php" class="btn">Back to Dashboard</a>
               
            </div>
        </div>
    </div>
</body>
</html>