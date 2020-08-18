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
// $contactId = 7;
$author = mysqli_real_escape_string($conn, $_REQUEST['author']);
$topic = mysqli_real_escape_string($conn, $_REQUEST['topic']);
// $created = mysqli_real_escape_string($conn, $_REQUEST['created']);
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
$note_sql = "INSERT INTO notes (contactId, author, topic, note) VALUES ('$contactId', '$author', '$topic', '$note')";
if(mysqli_query($conn, $note_sql)){
    // $noteId = mysqli_insert_id($conn); 
    header("location: ../contacts/view.php");
} else{
    echo "ERROR: Not able to execute $note_sql. " . mysqli_error($conn);
}
    $conn->close();

?>