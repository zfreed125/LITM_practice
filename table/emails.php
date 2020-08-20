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
$sql1 = "CREATE TABLE emails (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactId INT(6) NULL,
    venueId INT(6) NULL,
    emailTypeId INT(6) NOT NULL,
    email VARCHAR(60) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table emails created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>