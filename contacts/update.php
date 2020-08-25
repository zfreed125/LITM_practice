<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = $_REQUEST['id'];
// $contactid = mysqli_real_escape_string($conn, $_REQUEST['id']);
$firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
$birthdate = $_REQUEST['birthdate'];
$jobTitle = $_REQUEST['jobTitle'];
$active = (isset($_POST['active'])) ? 1 : 0;
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
 
// Attempt insert query execution
if (empty($birthdate)){
$sql = "UPDATE contacts set firstname='$firstname', lastname='$lastname', jobTitle='$jobTitle', active='$active' where id='$id';";
}else{
$sql = "UPDATE contacts set firstname='$firstname', lastname='$lastname', birthdate='$birthdate' , jobTitle='$jobTitle', active='$active' where id='$id';";
}
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    header("location: view.php");
    die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>