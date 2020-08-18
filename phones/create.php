<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$contactId = $_REQUEST['contactId'];
// $contactId = 7;
$phoneTypeId = $_REQUEST['phoneTypeId'];
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);

$phone_sql = "INSERT INTO phones (contactId, phoneTypeId, phone) VALUES ('$contactId', '$phoneTypeId', '$phone')";
if(mysqli_query($conn, $phone_sql)){
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $phone_sql. " . mysqli_error($conn);
}
    $conn->close();
?>