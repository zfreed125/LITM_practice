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
$sql1 = "CREATE TABLE link_email_types (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    emailId INT(6) NOT NULL,
    emailTypeId INT(6) NOT NULL
    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table link_email_types created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>