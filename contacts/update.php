<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = mysqli_real_escape_string($conn, $_REQUEST['id']);
$firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
$active = (isset($_POST['active'])) ? 1 : 0;
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
$sql = "UPDATE contact set firstname='$firstname', lastname='$lastname', active='$active' where id='$id';";
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    header("location: view.php");
    die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>