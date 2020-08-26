<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id =  $_REQUEST['id'];
$dst = $_REQUEST['src'];
$primary_tbl_sql = "SELECT id,primaryAddressId from $dst where primaryAddressId='$id';";
$primary_tbl_results = mysqli_query($conn, $primary_tbl_sql);

while ($row = mysqli_fetch_assoc($primary_tbl_results)) {
        $primaryTblId = $row["id"];
        $primaryAddressId = $row["primaryAddressId"];
    }
if (!empty($primaryAddressId)){
    $primary_update_sql = "UPDATE $dst set primaryAddressId=NULL where id='$primaryTblId';";

  if(mysqli_query($conn, $primary_update_sql)){
  } else{
      echo "ERROR: Not able to execute $primary_update_sql. " . mysqli_error($conn);
  }
}

$sql = "DELETE from addresses where id='$id';";
if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}

$conn->close();

?>