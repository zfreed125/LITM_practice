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
$accountTypeId = $_REQUEST['accountTypeId'];
if (empty($venueId)){
  $sql = "UPDATE accounts set contactId='$contactId', accountTypeId='$accountTypeId' where id='$id';";
  $dst = "contacts";
}else{
  $sql = "UPDATE accounts set venueId='$venueId', accountTypeId='$accountTypeId' where id='$id';";
  $dst = "venues";
  
}
if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>