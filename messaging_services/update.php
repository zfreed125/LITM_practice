<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$dst = $_REQUEST['src'];
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$serviceName = mysqli_real_escape_string($conn, $_REQUEST['serviceName']); 
$userAccount = mysqli_real_escape_string($conn, $_REQUEST['userAccount']);
$notes = mysqli_real_escape_string($conn, $_REQUEST['notes']);
//Attempt insert query execution

if (empty($venueId)){
  $messaging_services_sql = "UPDATE messaging_services set contactId='$contactId', serviceName='$serviceName', userAccount='$userAccount', notes='$notes' where id='$id';";
  $dst = "contacts";
}else{
  $messaging_services_sql = "UPDATE messaging_services set venueId='$venueId', serviceName='$serviceName', userAccount='$userAccount', notes='$notes' where id='$id';";
  $dst = "venues";
  
}

if(mysqli_query($conn, $messaging_services_sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $messaging_services_sql. " . mysqli_error($conn);
}
$conn->close();
?>