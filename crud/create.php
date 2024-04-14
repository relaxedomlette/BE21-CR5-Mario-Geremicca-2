<?php

session_start();
    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ../index.php");
        exit;
    }
    if(isset($_SESSION["user"])){
        header("Location: ../home.php");
        exit;
    }

    require_once "../components/db_connect.php";
    require_once "../file_upload.php";

    $sql = "SELECT * from user";
    $result = mysqli_query($conn, $sql);
    $rows= mysqli_fetch_all($result, MYSQLI_ASSOC);
  
  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require_once '../components/boot.php'?>
        <title>PHP CRUD  |  Add Animal</title>
        <style>
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }       
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#FFA500">
    <div class="container-fluid" id="navbarNav">
        <p class="navbar-brand" style="color:black; font-size:1.8rem; font-weight:bold">Pet Pals Paradise</p>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="../index.php" style="font-size:1.0rem; font-weight:bold">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href= "index.php" style="font-size:1.0rem; font-weight:bold">Manage Animals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php?logout" style="font-size:1.0rem; font-weight:bold">Logout</a>
                </li>
            </ul>   
        </div>
    </div>
</nav>
        <fieldset>
            <legend class='h2'>Add Animal</legend>
            <form action="actions/a_create.php" method= "post" enctype="multipart/form-data">
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td><input class='form-control' type="text" name="name"  placeholder="Animal Name" /></td>
                    </tr>  
                    <tr>
                        <th>Location</th>
                        <td><input class='form-control' type="text" name="location"  placeholder="Location" /></td>
                    </tr>  
                    <tr>
                        <th>Description</th>
                        <td><input class='form-control' type="text" name= "description" placeholder="Description" /></td>
                    </tr>
                    <tr>
                        <th>Character</th>
                        <td><input class='form-control' type="text" name="character"  placeholder="Character" /></td>
                    </tr> 
                    <tr>
                        <th>Breed</th>
                        <td><input class='form-control' type="text" name="breed"  placeholder="Breed" /></td>
                    </tr> 
                    <tr>
                        <th>Age</th>
                        <td><input class='form-control' type="number" name="age"  placeholder="Age" /></td>
                    </tr> 
                    <tr>
                        <th>Picture</th>
                        <td><input class='form-control' type="file" name="picture" /></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><select name="status" selected>
                            <option selected value="none">Please select one</option>
                                <option value="available">available</option>
                                <option value="adopted">adopted</option>
                        </select></td>
                    </tr>
                    <tr>
                        <th>Vaccinated</th>
                        <td><select name="vaccinated" selected>
                            <option selected value="none">Please select one</option>
                                <option value="vaccinated">vaccinated</option>
                                <option value="not vaccinated">not vaccinated</option>
                        </select></td>
                    </tr>
                    <tr>
                    <th>Size</th>
                        <td><select name="size" selected>
                        <option selected value="none">Please select one</option>
                        <option value="extra small">extra small</option>
                                <option value="small">small</option>
                                <option value="medium">medium</option>
                                <option value="large">large</option>
                                <option value="extra large">extra large</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td><button class='btn btn-success' type="submit">Insert Animal</button></td>
                        <td><a href="index.php"><button class='btn btn-warning' type="button">Home</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
        <div class="d-flex footer text-center align-items-center justify-content-center text-white" style="background-color: #FFA500;
    height: 60px;">
    <h2 style="font-size:1.2rem">&copy; Copyright 2024 - Pet Pals Paradise</h2>
</div>
    </body>
</html>