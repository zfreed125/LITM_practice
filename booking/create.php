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
$emailTypeId = $_REQUEST['emailTypeId'];
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);

if (empty($venueId)){
    $email_sql = "INSERT INTO emails (contactId, emailTypeId, email) VALUES ('$contactId', '$emailTypeId', '$email')";
    $dst = "contacts";
}else{
    $email_sql = "INSERT INTO emails (venueId, emailTypeId, email) VALUES ('$venueId', '$emailTypeId', '$email')";
    $dst = "venues";
    
}

if(mysqli_query($conn, $email_sql)){
    // $emailId = mysqli_insert_id($conn); 
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $email_sql. " . mysqli_error($conn);
}
    $conn->close();

?>