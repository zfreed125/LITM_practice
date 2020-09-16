<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$phoneId = $_REQUEST['phoneId'];
$serviceId = $_REQUEST['serviceId'];
$addressId = $_REQUEST['addressId'];
$emailId = $_REQUEST['emailId'];
$noteId = $_REQUEST['noteId'];
$venueId = $_REQUEST['venueId'];
// echo $noteId;
// die();

if(!empty($emailId)){
  $sql = "UPDATE venues SET primaryEmailId='$emailId' WHERE id='$venueId';";
}
if(!empty($addressId)){
  $sql = "UPDATE venues SET primaryAddressId='$addressId' WHERE id='$venueId';";
}
if(!empty($serviceId)){
  $sql = "UPDATE venues SET primaryServiceId='$serviceId' WHERE id='$venueId';";
}
if(!empty($phoneId)){
  $sql = "UPDATE venues SET primaryPhoneId='$phoneId' WHERE id='$venueId';";
}
if(!empty($noteId)){
  $sql = "UPDATE venues SET primaryNoteId='$noteId' WHERE id='$venueId';";
}


if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}

    $conn->close();


?>
