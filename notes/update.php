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
$venueId = $_REQUEST['venueId'];
$author = mysqli_real_escape_string($conn, $_REQUEST['author']);
$topic = mysqli_real_escape_string($conn, $_REQUEST['topic']);
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);

if (empty($venueId)){
  $sql = "UPDATE notes set contactId='$contactId', author='$author', topic='$topic', note='$note' where id='$id';";
  $dst = "contacts";
}else{
  $sql = "UPDATE notes set venueId='$venueId', author='$author', topic='$topic', note='$note' where id='$id';";
  $dst = "venues";
  
}

if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>