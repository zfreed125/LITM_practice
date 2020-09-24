<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$jobTitle = mysqli_real_escape_string($conn, $_REQUEST['jobTitle']);
$birthdate = $_REQUEST['birthdate'];
$timezoneId = $_REQUEST['timezoneId'];
$active = (isset($_POST['active'])) ? 1 : 0;
$accountTypeId = $_REQUEST['accountTypeId'];
$dst = "contacts";

(empty($birthdate)) ? $birthdate = 'NULL': $birthdate = "'" .$birthdate. "'";
$sql = "INSERT INTO contacts (firstname, lastname, jobTitle, birthdate, timezoneId, active) VALUES ('$first_name', '$last_name', '$jobTitle', ".$birthdate.", '$timezoneId', '$active')";
if(mysqli_query($conn, $sql)){
    $contactId = mysqli_insert_id($conn);
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}

if($accountTypeId != '-1'){
    $account_sql = "INSERT INTO accounts (contactId, accountTypeId) VALUES ('$contactId', '$accountTypeId')";
    if(mysqli_query($conn, $account_sql)){
        header("location: ../$dst/view.php");
    } else{
        echo "ERROR: Not able to execute $account_sql. " . mysqli_error($conn);
    }
    
}else{
    header("location: ../$dst/view.php");

}


    $conn->close();
