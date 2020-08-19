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
   
$dst = $_REQUEST['src'];    
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
if (empty($venueId)){
    $address_sql = "INSERT INTO addresses (contactId, street1, street2, city, shortState, zip1, country) VALUES ('$contactId', '$street1', '$street2', '$city', '$shortState', '$zip1', '$country')";
    $dst = "contacts";
}else{
    $address_sql = "INSERT INTO addresses (venueId, street1, street2, city, shortState, zip1, country) VALUES ('$venueId', '$street1', '$street2', '$city', '$shortState', '$zip1', '$country')";
    $dst = "venues";
    
}
if(mysqli_query($conn, $address_sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>