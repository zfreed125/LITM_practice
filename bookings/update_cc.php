<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$cc = $_REQUEST['cc'];
$clientName = $_REQUEST['clientName'];
$litmStartDate = $_REQUEST['litmStartDate'];
$venue = $_REQUEST['venue'];
// 7086506200@messaging.sprintpcs.com
$to = "8472711481@messaging.sprintpcs.com";
// $to = "7086506200@tmomail.net";
$subject = "LITM Booking Confirmed";
$message = "$clientName has confirmed their booking on $litmStartDate for $venue!";
$sql = "UPDATE bookings set clientConfirm='$cc' where id='$id';";

// echo "$to, $subject, $message";
// die();
mail($to, $subject, $message);
if(mysqli_query($conn, $sql)){
    header("location: http://litmmedia.com");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>
