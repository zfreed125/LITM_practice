<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
// if(isset($_REQUEST['zip2'])) {
//     $zip2 = 0000;
// }else{
//     $zip2 = $_REQUEST['zip2'];
// }
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
$zip2 = $_REQUEST['zip2'];

// Attempt insert query execution
$sql = "INSERT INTO addresses (street1, street2, city, shortState, zip1, zip2, country) VALUES ('$street1', '$street2', '$city', '$shortState', '$zip1', '$zip2','$country')";
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    echo "New record has id: " . mysqli_insert_id($conn); 
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>