<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = $_REQUEST['id'];
$is_client = $_REQUEST['is_client'];
$firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
$birthdate = $_REQUEST['birthdate'];
$timezoneId = $_REQUEST['timezoneId'];
if ($is_client){
    $bookingAuto = (isset($_POST['bookingAuto'])) ? 1 : 0;
    $bookingCount = $_REQUEST['bookingCount'];
    $bookingColor = $_REQUEST['bookingColor'];
    
}else{
    $bookingAuto = 0;
    $bookingCount = 0;
    $bookingColor = 0;

}
$active = (isset($_POST['active'])) ? 1 : 0;
// Attempt insert query execution
if (empty($birthdate)){
$sql = "UPDATE contacts set firstname='$firstname', lastname='$lastname', timezoneId='$timezoneId', bookingAuto='$bookingAuto', bookingCount='$bookingCount', bookingColor='$bookingColor', active='$active' where id='$id';";
}else{
$sql = "UPDATE contacts set firstname='$firstname', lastname='$lastname', birthdate='$birthdate' , timezoneId='$timezoneId', bookingAuto='$bookingAuto', bookingCount='$bookingCount', bookingColor='$bookingColor', active='$active' where id='$id';";
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