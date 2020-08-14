<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$contactId = $_REQUEST['contactId'];
// $contactId =11;
$genreTypeId = $_REQUEST['genreTypeId'];
$genre_sql = "INSERT INTO genres (contactId, genreTypeId) VALUES ('$contactId', '$genreTypeId')";
if(mysqli_query($conn, $genre_sql)){
    // $genreId = mysqli_insert_id($conn); 
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $genre_sql. " . mysqli_error($conn);
}
    $conn->close();

?>