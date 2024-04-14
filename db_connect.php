<?php

$localhost = "localhost";
$userName = "root";
$password = "";
$dbName = "be21_cr5_animal_adoption_mariogeremicca2";

$conn = mysqli_connect($localhost, $userName, $password, $dbName);

// check connection
// if($conn->connect_error) {
//     die("Connection failed: " . $connect->connect_error);
// }
//   else {
//     echo "Successfully Connected";
//  }
?>