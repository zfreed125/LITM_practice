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
$serviceName = mysqli_real_escape_string($conn, $_REQUEST['serviceName']);
$userAccount = mysqli_real_escape_string($conn, $_REQUEST['userAccount']);
$website = mysqli_real_escape_string($conn, $_REQUEST['website']);
$notes = mysqli_real_escape_string($conn, $_REQUEST['notes']);

if (empty($venueId)){
    $services_sql = "INSERT INTO services (contactId, serviceName, userAccount, website, notes) VALUES ('$contactId', '$serviceName', '$userAccount', '$website', '$notes')";
    $dst = "contacts";
}else{
    $services_sql = "INSERT INTO services (venueId, serviceName, userAccount, website, notes) VALUES ('$venueId', '$serviceName', '$userAccount', '$website', '$notes')";
    $dst = "venues";
    
}

if(mysqli_query($conn, $services_sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $services_sql. " . mysqli_error($conn);
}
    $conn->close();

?>