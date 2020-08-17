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
$serviceName = mysqli_real_escape_string($conn, $_REQUEST['serviceName']);
$userAccount = mysqli_real_escape_string($conn, $_REQUEST['userAccount']);
$notes = mysqli_real_escape_string($conn, $_REQUEST['notes']);
$messaging_services_sql = "INSERT INTO messaging_services (contactId, serviceName, userAccount, notes) VALUES ('$contactId', '$serviceName', '$userAccount', '$notes')";
if(mysqli_query($conn, $messaging_services_sql)){
    // $emailId = mysqli_insert_id($conn); 
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $messaging_services_sql. " . mysqli_error($conn);
}
    $conn->close();

?>