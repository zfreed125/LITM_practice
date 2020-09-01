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
$sql1 = "CREATE TABLE bookings (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bookingTypeId INT(6) NULL,
    bookingDateTimeStart DATETIME NULL,
    bookingDateTimeEnd DATETIME NULL,
    timezoneId INT(3) NULL,
    bookingLength INT(8) NULL,
    clientNameId VARCHAR(16) NULL,
    clientConfirm INT(1) NOT NULL,
    venueNameId INT(6) NULL,
    venueConfirm INT(1) NOT NULL,
    bookingStatus VARCHAR(32) DEFAULT 'Initialized',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table bookings created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>