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

$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id != 0) {
    $sql = "SELECT * FROM animal WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "No ID parameter provided.";
    exit;
}

if (isset($_POST["update"])) {
    $petName = $_POST["petName"];
    $type = $_POST["type"];
    $breed = $_POST["breed"];
    $size = $_POST["size"];
    $location = $_POST["location"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $age = $_POST["age"];
    $vaccinated = $_POST["vaccinated"];

    $picture = file_upload($_FILES["picture"], 'animal');
    $pictureArray = file_upload($_FILES['picture']);
    $picture = $pictureArray->fileName;

    if ($pictureArray->error == 4) {
        $sql = "UPDATE `animal` SET `petName`='$petName', `breed`='$breed', `age`='$age', `type`='$type', `location`='$location', `vaccinated`='$vaccinated', `status`='$status', `size`='$size' WHERE id = $id";
    } else {
        $sql = "UPDATE `animal` SET `petName`='$petName', `breed`='$breed', `picture`='{$pictureArray->fileName}', `age`='$age', `type`='$type', `location`='$location', `vaccinated`='$vaccinated', `status`='$status', `size`='$size' WHERE id = $id";
    }

    if (mysqli_query($conn, $sql) === true) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $conn->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
        <h2>Edit Entry:</h2>
        <?php if (!empty($message)) : ?>
            <div class="<?= $class; ?>" role="alert">
                <p><?= $message ?></p>
                <p><?= $uploadError ?></p>
                <a href='<?= $goBack ?>'><button class="btn btn-primary" type='button'>Back</button></a>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="petName">Pet Name</label>
            <input type="text" id="petName" name="petName" placeholder="Type in pet name" value="<?= isset($row["petName"]) ? $row["petName"] : '' ?>">

            <label for="type">Type</label>
            <input type="text" id="type" name="type" placeholder="Type of pet" value="<?= isset($row["type"]) ? $row["type"] : '' ?>">

            <label for="breed">Breed</label>
            <input type="text" id="breed" name="breed" placeholder="Breed of pet" value="<?= isset($row["breed"]) ? $row["breed"] : '' ?>">

            <label for="age">Age</label>
            <input type="text" id="age" name="age" placeholder="Age of pet" value="<?= isset($row["age"]) ? $row["age"] : '' ?>">

            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Pet location" value="<?= isset($row["location"]) ? $row["location"] : '' ?>">

            <label for="description">Description</label>
            <textarea id="description" name="description"><?= isset($row["description"]) ? $row["description"] : '' ?></textarea>

            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="adopted" <?= isset($row["status"]) && $row["status"] == "adopted" ? 'selected' : '' ?>>Adopted</option>
                <option value="unclaimed">unclaimed</option></select>
        
           
                <label for="vaccinated" class="form-label">Vaccinated</label>
                <select  name="vaccinated" value="<?= $row["vaccinated"] ?>">
                <option value="vaccinated">vaccinated</option>
                <option value="not vaccinated">not vaccinated</option>
                </select>
          
                <label for="size" class="form-label">Size</label>
                <select  name="size" value="<?= $row["size"] ?>">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
                </select>
                <label for="picture">Upload your picture</label>
            <input type="file"  name="picture" value="picture">
                <input type="submit" name="update" value="Update">
        </form> 
    </div>
            
               <br><br>
           

            
          <!--  <div class="mb-4">
                <label for="picture" class="form-label">Picture:</label>
                <input type = "file" class="form-control" id="picture" aria-describedby="picture"   name="picture">
            </div>
            <button name="update" type="submit" class="btn text-white mb-5" id="upBtn">Update entry</button>
            <a href="manage.php" class="btn btn-dark mb-5">Back to Admin</a>
        </form>
    </div>
    <footer class="mt-5">
        <div class="card text-center" id="foBg">
            <div class="card-header p-3">
                <a class="btn btn-dark p-1 m-1" style="width: 3%;" href="#" role="button"><img src="../imag/Facebook.png" width="40%" class="m-1"></a>
                <a class="btn btn-dark p-1 m-1" style="width: 3%;" href="#" role="button"><img src="../images/twitter.png" width="90%" class="m-1"></a>
                <a class="btn btn-dark p-1 m-1" style="width: 3%;" href="#" role="button"><img src="../images/instagram.png" width="75%"  class="m-1"></a>
                <a class="btn btn-dark p-1 m-1" style="width: 3%;" href="#" role="button"><img src="../images/google.png" width="75%"  class="m-1"></a>
            </div>
            <span class="card-body input-group input-group-sm  mx-auto p-3" style="width: 40%;" >
                <span class="input-group-text bg-black border-black text-white">Sign up for our newsletter</span>
                <input type="text" name="email" autocomplete="email" class="form-control bg-black border-black" placeholder="example@gmail.com">
                <button class=" btn rounded-end bg-black text-white" type="button" id="button-addon1"> Subscripe</button>
            </span>
            <div class="card-footer text-body-secondary p-1">
                &copy; Stefanie Sarközi
            </div>
        </div>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>