<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$contactId = $_REQUEST['contactId'];
$contacts_sql = "DELETE from contacts where id='$contactId';";
$address_sql = "DELETE from addresses where contactId='$contactId';";
$emails_sql = "DELETE from emails where contactId='$contactId';";
$phones_sql = "DELETE from phones where contactId='$contactId';";
if(mysqli_query($conn, $contacts_sql)){
    if(mysqli_query($conn, $emails_sql)){
        if(mysqli_query($conn, $phones_sql)){
            if(mysqli_query($conn, $address_sql)){
                header("location: nested_sql.php");
            } else{
                echo "ERROR: Not able to execute $address_sql. " . mysqli_error($conn);
            }
        } else{
            echo "ERROR: Not able to execute $phones_sql. " . mysqli_error($conn);
        }
    } else{
        echo "ERROR: Not able to execute $emails_sql. " . mysqli_error($conn);
    }
} else{
    echo "ERROR: Not able to execute $contacts_sql. " . mysqli_error($conn);
}


$conn->close();

?>