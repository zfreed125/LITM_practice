<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = $_REQUEST['id'];
$addressid = $_REQUEST['addressid'];
$addressContactId = $_REQUEST['addressContactId'];
$firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
$active = (isset($_POST['active'])) ? 1 : 0;
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
$zip2 = mysqli_real_escape_string($conn, $_REQUEST['zip2']);
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
 
// Attempt insert query execution
$contacts_sql = "UPDATE contacts set firstname='$firstname', lastname='$lastname', active='$active' where id='$id';";
if(mysqli_query($conn, $contacts_sql)){
} else{
    echo "ERROR: Not able to execute $contacts_sql. " . mysqli_error($conn);
}
$address_sql = "UPDATE address set contactId='$addressContactId', street1='$street1', street2='$street2', city='$city', shortState='$shortState', zip1='$zip1', zip2='$zip2', country='$country' where id='$addressid';";
if(mysqli_query($conn, $address_sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $address_sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>