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
$sql1 = "CREATE TABLE contact_types (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactType VARCHAR(30) NULL
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table contact_types created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>