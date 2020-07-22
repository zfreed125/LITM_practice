<?php

require_once 'config.php';

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
$sql = "select id, firstname, lastname, email from Test1 where id='$id';";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
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
                                <label>firstname</label>
                                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            </div>
                            <div class="form-group">
                                <label>lastname</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            </div>
                            <div class="form-group">
                                <label>email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
                                <!-- <a href=""></a> -->
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </form>
                </div>
    </body>
        </html>