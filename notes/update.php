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
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
//Attempt insert query execution
$sql = "UPDATE notes set contactId='$contactId', note='$note' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>