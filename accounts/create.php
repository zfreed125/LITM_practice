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
$venueId = $_REQUEST['venueId'];
$accountTypeId = $_REQUEST['accountTypeId'];
if (empty($venueId)){
    $account_sql = "INSERT INTO accounts (contactId, accountTypeId) VALUES ('$contactId', '$accountTypeId')";
    $dst = "contacts";
}else{
    $account_sql = "INSERT INTO accounts (venueId, accountTypeId) VALUES ('$venueId', '$accountTypeId')";
    $dst = "venues";
    
}
if(mysqli_query($conn, $account_sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $account_sql. " . mysqli_error($conn);
}
    $conn->close();

?>