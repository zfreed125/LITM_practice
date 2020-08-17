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
$sql1 = "CREATE TABLE venues (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactId INT(6) NULL,
    venueName VARCHAR(64) NULL,
    showLength VARCHAR(64) NULL,
    active INT(1) DEFAULT 1,
    venueDate DATE NULL,
    regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>