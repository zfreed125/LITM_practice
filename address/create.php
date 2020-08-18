<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




$contactId = $_REQUEST['contactid'];    
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
// if(isset($_REQUEST['zip2'])) {
//     $zip2 = 0000;
// }else{
//     $zip2 = $_REQUEST['zip2'];
// }

// Attempt insert query execution
$sql = "INSERT INTO addresses (contactId, street1, street2, city, shortState, zip1, country) VALUES ('$contactId', '$street1', '$street2', '$city', '$shortState', '$zip1', '$country')";
if(mysqli_query($conn, $sql)){
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>