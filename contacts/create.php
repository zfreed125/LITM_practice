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
// $birthdate = mysqli_real_escape_string($conn, $_REQUEST['birthdate']);
$jobTitle = mysqli_real_escape_string($conn, $_REQUEST['jobTitle']);
$birthdate = $_REQUEST['birthdate'];
$timezoneId = $_REQUEST['timezoneId'];
$active = (isset($_POST['active'])) ? 1 : 0;

(empty($birthdate)) ? $birthdate = 'NULL': $birthdate = "'" .$birthdate. "'";
$sql = "INSERT INTO contacts (firstname, lastname, jobTitle, birthdate, timezoneId, active) VALUES ('$first_name', '$last_name', '$jobTitle', ".$birthdate.", '$timezoneId', '$active')";
if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();
