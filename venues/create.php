<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$venueName = mysqli_real_escape_string($conn, $_REQUEST['venueName']);
$venueTypeId = $_REQUEST['venueTypeId'];
$contactNameId =  $_REQUEST['contactNameId'];
$hostNameId =  $_REQUEST['hostNameId'];
$showLength = mysqli_real_escape_string($conn, $_REQUEST['showLength']);
$venueDateStart = mysqli_real_escape_string($conn, $_REQUEST['venueDateStart']);
$venueDateEnd = mysqli_real_escape_string($conn, $_REQUEST['venueDateEnd']);
$active = (isset($_POST['active'])) ? 1 : 0;
// Attempt insert query execution
$sql = "INSERT INTO venues (venueName, venueTypeId, contactNameId, hostNameId, showLength, venueDateStart, venueDateEnd, active) 
VALUES ('$venueName', '$venueTypeId', '$contactNameId', '$hostNameId', '$showLength', '$venueDateStart', '$venueDateEnd', '$active')";

if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    echo "New record has id: " . mysqli_insert_id($conn); 
    header("location: view.php");
    // die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>