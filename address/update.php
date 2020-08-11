<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = mysqli_real_escape_string($conn, $_REQUEST['id']);
$contactId = mysqli_real_escape_string($conn, $_REQUEST['contactId']);
$street1 = mysqli_real_escape_string($conn, $_REQUEST['street1']);
$street2 = mysqli_real_escape_string($conn, $_REQUEST['street2']);
$city = mysqli_real_escape_string($conn, $_REQUEST['city']);
$shortState = mysqli_real_escape_string($conn, $_REQUEST['shortState']);
$zip1 = mysqli_real_escape_string($conn, $_REQUEST['zip1']);
$zip2 = mysqli_real_escape_string($conn, $_REQUEST['zip2']);
$country = mysqli_real_escape_string($conn, $_REQUEST['country']);
 
// Attempt insert query execution
$sql = "UPDATE addresses set contactId='$contactId', street1='$street1', street2='$street2', city='$city', shortState='$shortState', zip1='$zip1', zip2='$zip2', country='$country' where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>