<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = mysqli_real_escape_string($conn, $_REQUEST['id']);
$contactId = mysqli_real_escape_string($conn, $_REQUEST['contactId']);
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
//Attempt insert query execution
$sql = "UPDATE emails set contactId='$contactId', email='$email' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>