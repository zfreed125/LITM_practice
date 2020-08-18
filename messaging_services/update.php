<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$contactId = $_REQUEST['contactId'];
$serviceName = mysqli_real_escape_string($conn, $_REQUEST['serviceName']); 
$userAccount = mysqli_real_escape_string($conn, $_REQUEST['userAccount']);
$notes = mysqli_real_escape_string($conn, $_REQUEST['notes']);
//Attempt insert query execution
$sql = "UPDATE messaging_services set contactId='$contactId', serviceName='$serviceName', userAccount='$userAccount', notes='$notes' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>