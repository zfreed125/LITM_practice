<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
// $sql2 = "DROP TABLE contacts;";
$sql1 = "CREATE TABLE link_notes(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    noteId INT(6) NOT NULL,
    contactId INT(6) NULL,
    venueId INT(6) NULL,
    bookingId INT(6) NULL,
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table link_notes created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>