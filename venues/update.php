<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = $_REQUEST['id'];
$venueName = mysqli_real_escape_string($conn, $_REQUEST['venueName']);
$venueTypeId = $_REQUEST['venueTypeId'];
$contactNameId =  $_REQUEST['contactNameId'];
$hostNameId =  $_REQUEST['hostNameId'];
$showLength = mysqli_real_escape_string($conn, $_REQUEST['showLength']);
$venueDateStart = mysqli_real_escape_string($conn, $_REQUEST['venueDateStart']);
$venueTimeStart = $_REQUEST['venueTimeStart'];
$venueDateEnd = mysqli_real_escape_string($conn, $_REQUEST['venueDateEnd']);
$venueTimeEnd = $_REQUEST['venueTimeEnd'];
$active = (isset($_POST['active'])) ? 1 : 0;
// Attempt insert query execution
$sql = "UPDATE venues set venueName='$venueName', venueTypeId='$venueTypeId', contactNameId='$contactNameId', hostNameId='$hostNameId', venueDateStart='$venueDateStart', venueTimeStart=CONVERT('$venueTimeStart', TIME) , venueDateEnd='$venueDateEnd', venueTimeEnd=CONVERT('$venueTimeEnd', TIME) , showLength='$showLength', active='$active' where id='$id';";
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    header("location: view.php");
    die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>