<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
$sql = "CREATE TABLE addresses (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactId INT(6) NULL,
    venueId INT(6) NULL,
    addressTypeId INT(6) NULL,
    street1 VARCHAR(64) NOT NULL,
    street2 VARCHAR(64) NULL,
    city VARCHAR(64) NOT NULL,
    shortState VARCHAR(64) NOT NULL,
    zip1 VARCHAR(5) NOT NULL,
    zip2 VARCHAR(4) NULL,
    country VARCHAR(64) NULL,
    regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table addresses created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>