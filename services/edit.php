<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$id = $_GET["id"];
$src = $_GET["src"];
//attempt insert query execution
$services_sql = "select id, contactId,venueId, serviceName, userAccount, website, notes from services where id='$id';";
$services_result = mysqli_query($conn, $services_sql);
    //output data of each row
    while ($row = mysqli_fetch_assoc($services_result)) {
        $contactId = $row["contactId"];
        $venueId = $row["venueId"];
        $serviceName = $row["serviceName"];
        $userAccount = $row["userAccount"];
        $website = $row["website"];
        $notes = $row["notes"];
    }
$conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Info</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
       <style type="text/css">
            .wrapper{
                    width: 500px;
                margin: 0 auto;
            }
        </style>
    </head> 
    <body>
        <div class="wrapper">
            <h2>Update Info</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Service Name</span></div>
                                        <input type="text" name="serviceName" class="form-control" value="<?php echo $serviceName; ?>">
                                    </div>
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">User Account</span></div>
                                        <input type="text" name="userAccount" class="form-control" value="<?php echo $userAccount; ?>">
                                    </div>
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Website</span></div>
                                        <input type="text" name="website" class="form-control" value="<?php echo $website; ?>">
                                    </div>
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Service Notes</span></div>
                                    <textarea class="form-control" name="notes" id="notes" rows="4" cols="50"><?php echo $notes; ?></textarea>
                                    </div>
                                    <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                                    <input type="hidden" name="venueId" value="<?php echo $venueId; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="src" value="<?php echo $src; ?>">

                            <div class="m-5">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <!-- </div> -->
                            <!-- <div class="mt-3 mb-1"> -->
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </div>
                    </form>
        </div>
    </body>       
</html>    