<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = mysqli_real_escape_string($conn, $_REQUEST['id']);

$sql = "DELETE from Test1 where id='$id';";

if(mysqli_query($conn, $sql)){
    echo "Record id $id was successfully deleted.";
    header("location: http://192.168.1.223/read.php");
    die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}

$conn->close();

?>