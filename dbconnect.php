<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
// $sql = "CREATE TABLE Test1 (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     email VARCHAR(50),
//     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//     )";
    
//     if ($conn->query($sql) === TRUE) {
//       echo "Table Test1 created successfully";
//     } else {
//       echo "Error creating table: " . $conn->error;
//     }

    // Escape user inputs for security
    // $_REQUEST['first_name']
    // $_REQUEST['last_name']
    // $_REQUEST['email']
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
$sql = "INSERT INTO Test1 (firstname, lastname, email) VALUES ('$first_name', '$last_name', '$email')";
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}
    
    $conn->close();

?>