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
$note = mysqli_real_escape_string($conn, $_REQUEST['note']);
$note_sql = "INSERT INTO notes (contactId, note) VALUES ('$contactId', '$note')";
if(mysqli_query($conn, $note_sql)){
    // $noteId = mysqli_insert_id($conn); 
    header("location: ../wizard/nested_sql.php");
} else{
    echo "ERROR: Not able to execute $note_sql. " . mysqli_error($conn);
}
    $conn->close();

?>