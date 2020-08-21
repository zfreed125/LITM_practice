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



$venues_id = $_GET["id"];
// $id = 1;
// $firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
// $lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
// $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
// $sql = "select id, first_name, last_name, email from contact where id='$id';";
$venues_sql = "SELECT * FROM venues where id='$venues_id';";
$venues_result = mysqli_query($conn, $venues_sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($venues_result)) {
        $active = $row["active"];
        $venueName = $row["venueName"];
        $venueTypeId = $row["venueTypeId"];
        $contactNameId = $row["contactNameId"];
        $hostNameId = $row["hostNameId"];
        $venueDateStart = strtotime($row["venueDateStart"]);
        $venueTimeStart = $row["venueTimeStart"];
        $venueDateEnd = strtotime($row['venueDateEnd']);
        $venueTimeEnd = $row['venueTimeEnd'];
        $showLength = $row['showLength'];
    }

 
    $conn->close();
?>
<!-- // HTML Form -->
<!DOCTYPE html>

<html lang="en">
            <head>
                <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Record</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                                <input type="text" name="venueName" class="form-control" value="<?php echo $venueName; ?>">
                            </div>
                            <div class="form-group">
                                <select name="venueTypeId">
                                    <option selected="selected">Select Venue Type</option>
                                        <?php foreach($venue_type_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"
                                        <?php if($item['id'] == $venueTypeId){ echo "selected"; } ?> >
                                    <?php echo $item['venueType']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <select name="contactNameId">
                                    <option selected="selected">Select Contact Name</option>
                                        <?php foreach($contacts_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"
                                        <?php if($item['id'] == $contactNameId){ echo "selected"; } ?> >
                                    <?php echo $item['fullname']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <select name="hostNameId">
                                    <option selected="selected">Select Host Name</option>
                                        <?php foreach($contacts_array as $item){ ?>
                                    <option value="<?php echo strtolower($item['id']); ?>"
                                        <?php if($item['id'] == $hostNameId){ echo "selected"; } ?> >
                                    <?php echo $item['fullname']; ?></option>
                                        <?php } ?>
                                </select> 
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                                <input type="date" name="venueDateStart" class="form-control" value="<?php echo date("Y-m-d",$venueDateStart); ?>">
                                <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                                <input type="time" name="venueTimeStart" class="form-control" value="<?php echo $venueTimeStart; ?>">
                            </div>
                            <span class="input-group-addon">&nbsp</span>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                                <input type="date" name="venueDateEnd" class="form-control" value="<?php echo date("Y-m-d",$venueDateEnd); ?>">
                                <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                                <input type="time" name="venueTimeEnd" class="form-control" value="<?php echo $venueTimeEnd; ?>">
                            </div>
                            <div class="form-group">
                                <label>Show Length</label>
                                <input type="number" name="showLength" class="form-control" value="<?php echo $showLength; ?>">
                            </div>
                            <div class="form-group">
                                <label>active</label>
                                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
                            </div>
                                <input type="hidden" name="id" value="<?php echo $venues_id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $venues_id;?>">Delete</a>
                                <br>
                                <br>
                                <a class="btn btn-default" href="view.php">Cancel</a>
                            </form>
                </div>
    </body>
        </html>