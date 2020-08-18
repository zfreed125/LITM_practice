<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$src = $_REQUEST['src'];
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$genreTypeId = $_REQUEST['genreTypeId'];
//Attempt insert query execution
$sql = "UPDATE genres set contactId='$contactId', genreTypeId='$genreTypeId' where id='$id';";
if ($src != "venues"){
  // INSERT INTO genres (contactId, genreTypeId) VALUES ('', '3'). Incorrect integer value: '' for column 'contactId' at row 1
  $genre_sql = "UPDATE genres set contactId='$contactId', genreTypeId='$genreTypeId' where id='$id';";
  $dst = "contacts";
}else{
  $genre_sql = "UPDATE genres set venueId='$venueId', genreTypeId='$genreTypeId' where id='$id';";
  $dst = "venues";
  
}
if(mysqli_query($conn, $sql)){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>