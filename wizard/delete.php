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
$account_sql = "DELETE from accounts where contactId='$contactId';";
$genre_sql = "DELETE from genres where contactId='$contactId';";
$note_sql = "DELETE from notes where contactId='$contactId';";

mysqli_autocommit($conn, FALSE);


$query1 = mysqli_query($conn, $contacts_sql);
$query2 = mysqli_query($conn, $address_sql);
$query3 = mysqli_query($conn, $emails_sql);
$query4 = mysqli_query($conn, $phones_sql);
$query5 = mysqli_query($conn, $account_sql);
$query6 = mysqli_query($conn, $genre_sql);
$query7 = mysqli_query($conn, $note_sql);

if ($query1 && $query2 && $query3 && $query4 && $query5 && $query6 && $query7){
    mysqli_commit($conn);
    header("location: nested_sql.php");
    
}else{
    mysqli_rollback($conn);
    echo "An Error has Occurred!" . mysqli_error($conn) . "<br><a href='nested_sql.php'>Back</a>";
}
mysqli_close($conn);


?>