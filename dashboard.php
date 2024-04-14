<?php

session_start();
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
    header("Location: login.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}

require_once "db_connect.php";

$sql = "SELECT * from user WHERE id = {$_SESSION["admin"]}";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);


$readQuery = "SELECT * from animal";
$readResult = mysqli_query($conn, $readQuery);

$layout = "";


if (mysqli_num_rows($readResult) == 0) {
    $layout = "No animals found!";
} else {
    $rows = mysqli_fetch_all($readResult, MYSQLI_ASSOC);
    foreach ($rows as $value) {
        $layout .= "<tr>
        <td>{$value["petName"]}</td>
        <td>{$value["breed"]}</td>
        <td>{$value["age"]}</td>
        
        <td><a href='details.php?id={$value["id"]}' class='btn btn-success'>Details</a></td> 
        <td><a href='updateanimal.php?id={$value["id"]}' class='btn btn-primary'>Update</a></td>
        <td><a href='/crud/delete.php?id={$value["id"]}' class='btn btn-danger'>Delete</a></td>

    </tr>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello <?= $row["firstName"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>


.hero {
  position: relative;}
  .heroimg {
    width: 100%;
    margin-bottom: 10px;
    opacity: 70%;
  }
  .overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100px;
    background-color: rgba(0, 0, 0, 0.456);
  }
  .title {
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: black;
    background-color: white;
    
  }

.grid-container {
  display: grid;
  grid-template-columns: auto auto;
  align-items: center;}
  h4 {
    text-align: center;
  }
  p {
    text-align: center;
    margin-left: 10%;
    margin-right: 10%;
  }
  .cont{
    display: flex;
    justify-content: center;
    align-content: center;
}
.center{
    display: flex;
    justify-content: center;
    align-content: center;
    margin-bottom: 2rem;
}
.grid{
    
    width: 100%;
    align-content: center;
    justify-content: center;
}
.card{
    
    width: 100%;
    align-content: center;
    justify-content: center;}

@media screen and (max-width: 750px) {
  .small-screen {
    grid-template-columns: 1fr;
  }
  .big-screen {
    display: none;
  }
}
@media screen and (min-width: 751px) {
  .big-screen {
    grid-template-columns: 1fr 1fr;
  }
  .small-screen {
    display: none;
  }
}
@media screen and (min-width: 1050px) {
  .big-screen {
    grid-template-columns: 1fr 1fr;
  }
  .small-screen {
    display: none;
  }
  p {
    font-size: 130%;
  }
  h4 {
    font-size: 130%;
  }
}






</style>
</head>
<body>
<nav class="navbar bg-body-tertiary">
        <div class="container">
            
            <a class="navbar-brand" href="addanimal.php">
                Add pet
            </a>
            <a class="navbar-brand" href="logout.php?logout">
                Logout
            </a>
        </div>
    </nav>

    <img src="../CRUD_Login/pictures/museum1.jpg" width="100%" alt="">
    <br><br>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Details</th>
                    <th>Update</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody>
                <?= $layout ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>