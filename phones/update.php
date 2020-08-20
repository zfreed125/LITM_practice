<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$phoneTypeId = $_REQUEST['phoneTypeId'];
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);

if (empty($venueId)){
  $sql = "UPDATE phones set contactId='$contactId', phoneTypeId='$phoneTypeId', phone='$phone' where id='$id';";
  $dst = "contacts";
}else{
  $sql = "UPDATE phones set venueId='$venueId', phoneTypeId='$phoneTypeId', phone='$phone' where id='$id';";
  $dst = "venues";
  
}

if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>