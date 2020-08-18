<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
$venue_types_sql = "SELECT * FROM venue_types;";
$venue_types_result = mysqli_query($conn, $venue_types_sql);
$venue_type_array = array();
while ($row = mysqli_fetch_assoc($venue_types_result)) {
    $venue_type_array[] = array('id' => $row['id'], 'venueType' => $row['venueType']);
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
$sql = "SELECT * FROM venues where id='$id';";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $active = $row["active"];
        $venueName = $row["venueName"];
        $venueTypeId = $row["venueTypeId"];
        $contactNameId = $row["contactNameId"];
        $hostNameId = $row["hostNameId"];
        $venueDateStart = $row["venueDateStart"];
        $venueDateEnd = $row['venueDateEnd'];
        $showlength = $row['showlength'];
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
                                <label>Venue Name</label>
                                <label type="text" name="venueName" class="form-control"><?php echo $venueName; ?></label>
                            </div>
                            <div class="form-group">
                                <select name="venueTypeId">
                                    <option selected="selected">Select Venue Type</option>
                                        <?php foreach($venueType_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['venueType']; ?>
                                        <?php if($item['id'] == $venueTypeId){ echo "selected"; } ?> >
                                        <?php echo $item['venueType']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <select name="contactNameId">
                                    <option selected="selected">Select Contact Name</option>
                                        <?php foreach($contacts_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?>
                                        <?php if($item['id'] == $contactNameId){ echo "selected"; } ?> >
                                        <?php echo $item['fullname']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <select name="hostNameId">
                                    <option selected="selected">Select Host Name</option>
                                        <?php foreach($contacts_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?>
                                        <?php if($item['id'] == $hostNameId){ echo "selected"; } ?> >
                                        <?php echo $item['fullname']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label>Start Date/Time</label>
                                <input type="datetime" name="venueDateStart" class="form-control" value="<?php echo $venueDateStart; ?>">
                            </div>
                            <div class="form-group">
                                <label>End Date/Time</label>
                                <input type="datetime" name="venueDateEnd" class="form-control" value="<?php echo $venueDateEnd; ?>">
                            </div>
                            <div class="form-group">
                                <label>Show Length</label>
                                <input type="number" name="showLength" class="form-control" value="<?php echo $showLength; ?>">
                            </div>
                            <div class="form-group">
                                <label>active</label>
                                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
                            </div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                                <br>
                                <br>
                                <a class="btn btn-default" href="view.php">Cancel</a>
                            </form>
                </div>
    </body>
        </html>