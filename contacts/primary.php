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
$contactId = $_REQUEST['contactId'];
$noteId = $_REQUEST['noteId'];

if(!empty($emailId)){
  $sql = "UPDATE contacts SET primaryEmailId='$emailId' WHERE id='$contactId';";
}
if(!empty($addressId)){
  $sql = "UPDATE contacts SET primaryAddressId='$addressId' WHERE id='$contactId';";
}
if(!empty($serviceId)){
  $sql = "UPDATE contacts SET primaryServiceId='$serviceId' WHERE id='$contactId';";
}
if(!empty($phoneId)){
  $sql = "UPDATE contacts SET primaryPhoneId='$phoneId' WHERE id='$contactId';";
}
if(!empty($noteId)){
  $sql = "UPDATE contacts SET primaryNoteId='$noteId' WHERE id='$contactId';";
}


if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}

    $conn->close();


?>
