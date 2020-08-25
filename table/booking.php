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
$sql1 = "CREATE TABLE booking (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bookingTypeId INT(6) NULL,
    bookingDateTime DATETIME NOT NULL,
    bookingLength INT(8) NULL,
    recurring INT(3) NOT NULL,
    autoMonthly INT(1) NOT NULL,
    clientNameId INT(6) NOT NULL,
    clientConfirm INT(1) NOT NULL,
    venueNameId INT(6) NOT NULL,
    venueConfirm INT(1) NOT NULL,
    bookingStatus INT(5) NOT NULL
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table booking created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>