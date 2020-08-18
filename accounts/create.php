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
// $contactId =11;
$accountTypeId = $_REQUEST['accountTypeId'];
$account_sql = "INSERT INTO accounts (contactId, accountTypeId) VALUES ('$contactId', '$accountTypeId')";
if(mysqli_query($conn, $account_sql)){
    // $accountId = mysqli_insert_id($conn); 
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $account_sql. " . mysqli_error($conn);
}
    $conn->close();

?>