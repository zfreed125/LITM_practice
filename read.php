<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
$sql = "select * from Test1;";
$result = mysqli_query($conn, $sql);
// print_r($result);
// echo '<pre>'; print_r($result); echo '</pre>';
// echo "hello";
// die();
// echo $result;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "Email: " . $row["email"] . "<br>";
    }
  } else {
    echo "0 results";
  }

// if(mysqli_query($conn, $sql)){
//     echo "Records added successfully.";
// } else{
//     echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
// }
    
    $conn->close();

?>