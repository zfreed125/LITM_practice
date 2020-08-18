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
$accountTypeId = $_REQUEST['accountTypeId'];
//Attempt insert query execution
$sql = "UPDATE accounts set contactId='$contactId', accountTypeId='$accountTypeId' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>