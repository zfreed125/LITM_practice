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
$email_sql = "INSERT INTO emails (contactId, emailTypeId, email) VALUES ('$contactId', '$emailTypeId', '$email')";
if(mysqli_query($conn, $email_sql)){
    // $emailId = mysqli_insert_id($conn); 
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $email_sql. " . mysqli_error($conn);
}
    $conn->close();

?>