<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
$sql = "CREATE TABLE address (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactId VARCHAR(32) NULL,
    addressTypeId INT(8) NULL,
    street1 VARCHAR(64) NOT NULL,
    street2 VARCHAR(64) NULL,
    city VARCHAR(64) NOT NULL,
    shortState VARCHAR(64) NOT NULL,
    zip1 VARCHAR(5) NOT NULL,
    zip2 VARCHAR(4) NULL,
    country VARCHAR(64) NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table address created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>