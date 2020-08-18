<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$genreTypeId = $_REQUEST['genreTypeId'];
if (empty($venueId)){
    // INSERT INTO genres (contactId, genreTypeId) VALUES ('', '3'). Incorrect integer value: '' for column 'contactId' at row 1
    $genre_sql = "INSERT INTO genres (contactId, genreTypeId) VALUES ('$contactId', '$genreTypeId')";
    $dst = "contacts";
}else{
    $genre_sql = "INSERT INTO genres (venueId, genreTypeId) VALUES ('$venueId', '$genreTypeId')";
    $dst = "venues";
    
}
if(mysqli_query($conn, $genre_sql)){
    // $genreId = mysqli_insert_id($conn); 
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $genre_sql. " . mysqli_error($conn);
}
    $conn->close();

?>