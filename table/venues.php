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
    active INT(1) DEFAULT 1,
    venueName VARCHAR(64) NULL,
    venueTypeId INT(6) NULL,
    contactNameId INT(6) NULL,
    hostNameId INT(6) NULL,
    venueDateStart DATETIME NULL,
    venueTimeStart TIME NULL,
    venueDateEnd DATETIME NULL,
    venueTimeEnd TIME NULL,
    showLength INT(8) NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP     
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>