<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$contact_type_sql = "SELECT * FROM contact_types;";
$result = mysqli_query($conn, $contact_type_sql);
$contact_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $contact_type_array[] = array('id' => $row['id'], 'contactType' => $row['contactType']);
}


$id = $_GET["id"];
// $id = 1;
// $firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
// $lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
// $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
// $sql = "select id, first_name, last_name, email from contact where id='$id';";
$sql = "select id, firstname, lastname, birthdate, jobTitle, active from contacts where id='$id';";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $contactId = $row["id"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $birthdate = $row["birthdate"];
        $jobTitle = $row['jobTitle'];
        $active = $row["active"];
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
            <script>
                window.addEventListener('load', (event) => {

                    var x = document.getElementById("active").value; 
                    if (x == 1) {
                        document.getElementById("active").checked = true;
                    }else{
                        document.getElementById("active").checked = false;
                    }




                });
                    
            </script>
    </head>
        <body>
                <div class="wrapper">
                        <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form action="update.php" method="post">
                              
                            <div class="form-group">
                                <label>Contact Id</label>
                                <label type="text" name="contactId" class="form-control"><?php echo $contactId; ?></label>
                            </div>
                            <div class="form-group">
                                <label>firstname</label>
                                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            </div>
                            <div class="form-group">
                                <label>lastname</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            </div>
                            <div class="form-group">
                                <label>Birthdate</label>
                                <input type="date" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>">
                            </div>
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" name="jobTitle" class="form-control" value="<?php echo $jobTitle; ?>">
                            </div>
                            <div class="form-group">
                                <label>active</label>
                                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
                            </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                                <br>
                                <br>
                                <a class="btn btn-default" href="view.php">Cancel</a>
                            </form>
                </div>
    </body>
        </html>