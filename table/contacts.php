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
$sql1 = "CREATE TABLE contacts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    jobTitle VARCHAR(30) NULL,
    active INT(1) DEFAULT 1,
    birthdate DATE NULL,
    bookingCount INT(3) NULL,
    bookingAuto INT(1) NULL,
    bookingColor VARCHAR(32) NULL,
    primaryAddressId INT(6) NULL,
    primaryEmailId INT(6) NULL,
    primaryPhoneId INT(6) NULL,
    primaryServiceId INT(6) NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table contacts created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>