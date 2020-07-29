<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// contact post
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$active = (isset($_POST['active'])) ? 1 : 0;
// address post
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
$zip2 = $_REQUEST['zip2'];
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
// Attempt insert query execution
$contacts_sql = "INSERT INTO contacts (firstname, lastname, active) VALUES ('$first_name', '$last_name', '$active')";
if(mysqli_query($conn, $contacts_sql)){
    $contactId = mysqli_insert_id($conn); 
} else{
    echo "ERROR: Not able to execute $contacts_sql. " . mysqli_error($conn);
}
$address_sql = "INSERT INTO address (contactId, street1, street2, city, shortState, zip1, zip2, country) VALUES ('$contactId', '$street1', '$street2', '$city', '$shortState', '$zip1', '$zip2','$country')";
if(mysqli_query($conn, $address_sql)){
    $address_Id = mysqli_insert_id($conn); 
    header("location: edit.php?id=$contactId");
} else{
    echo "ERROR: Not able to execute $address_sql. " . mysqli_error($conn);
}
    $conn->close();
?>