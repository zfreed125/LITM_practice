<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_REQUEST['id'];
$dst = $_REQUEST['src'];
$primary_tbl_sql = "SELECT id,primaryNoteId from $dst where primaryNoteId='$id';";
$primary_tbl_results = mysqli_query($conn, $primary_tbl_sql);

while ($row = mysqli_fetch_assoc($primary_tbl_results)) {
        $primaryTblId = $row["id"];
        $primaryNoteId = $row["primaryNoteId"];
    }
if (!empty($primaryNoteId)){
    $primary_update_sql = "UPDATE $dst set primaryNoteId=NULL where id='$primaryTblId';";
    header("location: ../$dst/view.php");

  if(mysqli_query($conn, $primary_update_sql)){
  } else{
      echo "ERROR: Not able to execute $primary_update_sql. " . mysqli_error($conn);
  }
}

$conn->close();

?>