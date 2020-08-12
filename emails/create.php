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
$emailTypeId = $_REQUEST['emailTypeId'];
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
$email_sql = "INSERT INTO emails (contactId, email) VALUES ('$contactId', '$email')";
if(mysqli_query($conn, $email_sql)){
    $emailId = mysqli_insert_id($conn); 
} else{
    echo "ERROR: Not able to execute $email_sql. " . mysqli_error($conn);
}
$link_email_types_sql = "INSERT INTO link_email_types (emailId, emailTypeId) VALUES ('$emailId', '$emailTypeId')";
if(mysqli_query($conn, $link_email_types_sql)){
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $link_email_types_sql. " . mysqli_error($conn);
}
    $conn->close();

?>