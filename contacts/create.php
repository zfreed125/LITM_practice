<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$active = mysqli_real_escape_string($conn, $_REQUEST['active']);
$active = (isset($_POST['active'])) ? 1 : 0;
// Attempt insert query execution
$sql = "INSERT INTO contact (firstname, lastname, active) VALUES ('$first_name', '$last_name', '$active')";
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    echo "New record has id: " . mysqli_insert_id($conn); 
    header("location: view.php");
    // die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>