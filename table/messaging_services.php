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
$sql1 = "CREATE TABLE messaging_services (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    serviceName VARCHAR(64) NULL,
    userAccount VARCHAR(64) NULL,
    notes TEXT NULL,
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table messaging_services created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>