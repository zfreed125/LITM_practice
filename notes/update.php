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
$author = mysqli_real_escape_string($conn, $_REQUEST['author']);
$topic = mysqli_real_escape_string($conn, $_REQUEST['topic']);
// $created = mysqli_real_escape_string($conn, $_REQUEST['created']);
$modified = mysqli_real_escape_string($conn, $_REQUEST['modified']);
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
//Attempt insert query execution
$sql = "UPDATE notes set contactId='$contactId', author='$author', topic='$topic', modified='$modified', note='$note' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>