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
// $contactId = 7;
$serviceName = mysqli_real_escape_string($conn, $_REQUEST['serviceName']);
$userAccount = mysqli_real_escape_string($conn, $_REQUEST['userAccount']);
$notes = mysqli_real_escape_string($conn, $_REQUEST['notes']);

if (empty($venueId)){
    $messaging_services_sql = "INSERT INTO messaging_services (contactId, serviceName, userAccount, notes) VALUES ('$contactId', '$serviceName', '$userAccount', '$notes')";
    $dst = "contacts";
}else{
    $messaging_services_sql = "INSERT INTO messaging_services (venueId, serviceName, userAccount, notes) VALUES ('$venueId', '$serviceName', '$userAccount', '$notes')";
    $dst = "venues";
    
}

if(mysqli_query($conn, $messaging_services_sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $messaging_services_sql. " . mysqli_error($conn);
}
    $conn->close();

?>