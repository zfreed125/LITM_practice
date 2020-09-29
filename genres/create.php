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
    $genre_sql = "INSERT INTO genres (contactId, genreTypeId) VALUES ";
    foreach($genreTypeId as $value) {
        $genre_sql .=  "('$contactId', '$value'),";
    }
    $dst = "contacts";
}else{
    $genre_sql = "INSERT INTO genres (venueId, genreTypeId) VALUES ";
    foreach($genreTypeId as $value) {
        $genre_sql .=  "('$venueId', '$value'),";
    }
    $dst = "venues";
    
}
if(mysqli_query($conn, rtrim($genre_sql, ", "))){
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $genre_sql. " . mysqli_error($conn);
}
    $conn->close();

?>