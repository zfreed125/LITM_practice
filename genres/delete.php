<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$dst = $_REQUEST['src'];
$id =  $_REQUEST['id'];
$sql = "DELETE from genres where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}
$conn->close();

?>