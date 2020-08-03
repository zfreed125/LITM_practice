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
$sql1 = "CREATE TABLE link_contacts_venues(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contactId INT(6) NOT NULL,
    venueId INT(6) NOT NULL,

    )";
    
    if ($conn->query($sql1) === TRUE) {
      echo "Table link_contacts_venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>