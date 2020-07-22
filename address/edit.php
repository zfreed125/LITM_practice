<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




$id = $_GET["id"];
// $id = 1;
// $firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
// $lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
// $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
// $sql = "select id, first_name, last_name, email from Test1 where id='$id';";
$sql = "select id, street1, street2, city, shortState, zip1, zip2, country from Test1 where id='$id';";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $street1 = $row["street1"];
        $street2 = $row["street2"];
        $city = $row["city"];
        $shortState = $row["shortState"];
        $zip1 = $row["zip1"];
        $zip2 = $row["zip2"];
        $country = $row["country"];
    }

 
    $conn->close();
?>
<!-- // HTML Form -->
<!DOCTYPE html>

<html lang="en">
            <head>
                <meta charset="UTF-8">
            <title>Update Record</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
            <style type="text/css">
                .wrapper{
                        width: 500px;
                    margin: 0 auto;
                }
            </style>
    </head>
        <body>
                <div class="wrapper">
                        <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form action="update.php" method="post">
                              
                            <div class="form-group">
                                <label>street1</label>
                                <input type="text" name="street1" class="form-control" value="<?php echo $street1; ?>">
                            </div>
                            <div class="form-group">
                                <label>street2</label>
                                <input type="text" name="street2" class="form-control" value="<?php echo $street2; ?>">
                            </div>
                            <div class="form-group">
                                <label>city</label>
                                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                            </div>
                            <div class="form-group">
                                <label>shortState</label>
                                <input type="text" name="shortState" class="form-control" value="<?php echo $shortState; ?>">
                            </div>
                            <div class="form-group">
                                <label>zip1</label>
                                <input type="text" name="zip1" class="form-control" value="<?php echo $zip1; ?>">
                            </div>
                            <div class="form-group">
                                <label>zip2</label>
                                <input type="text" name="zip2" class="form-control" value="<?php echo $zip2; ?>">
                            </div>
                            <div class="form-group">
                                <label>country</label>
                                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </form>
                </div>
    </body>
        </html>