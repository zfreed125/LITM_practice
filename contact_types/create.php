<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contactType = mysqli_real_escape_string($conn, $_REQUEST['contactType']);
$sql = "INSERT INTO contact_types (contactType) VALUES ('$contactType')";
if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    $conn->close();

?>