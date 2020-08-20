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
$author = mysqli_real_escape_string($conn, $_REQUEST['author']);
$topic = mysqli_real_escape_string($conn, $_REQUEST['topic']);
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);

if (empty($venueId)){
    $note_sql = "INSERT INTO notes (contactId, author, topic, note) VALUES ('$contactId', '$author', '$topic', '$note')";
    $dst = "contacts";
}else{
    $note_sql = "INSERT INTO notes (venueId, author, topic, note) VALUES ('$venueId', '$author', '$topic', '$note')";
    $dst = "venues";
    
}

if(mysqli_query($conn, $note_sql)){
    // $noteId = mysqli_insert_id($conn); 
    header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $note_sql. " . mysqli_error($conn);
}
    $conn->close();

?>