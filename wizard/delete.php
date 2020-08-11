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
$address_sql = "DELETE from addresses where id='$addressid';";
$contacts_sql = "DELETE from contacts where id='$id';";
if(mysqli_query($conn, $contacts_sql)){
    //echo "Record Deleted";
} else{
    echo "ERROR: Not able to execute $contacts_sql. " . mysqli_error($conn);
}
if(mysqli_query($conn, $address_sql)){
    header("location: nested_sql.php");
} else{
    echo "ERROR: Not able to execute $address_sql. " . mysqli_error($conn);
}

$conn->close();

?>