<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$venueId = $_REQUEST['venueId'];
$venues_sql = "DELETE from venues where id='$venueId';";
// $address_sql = "DELETE from addresses where contactId='$contactId';";
// $emails_sql = "DELETE from emails where contactId='$contactId';";
// $phones_sql = "DELETE from phones where contactId='$contactId';";
// $account_sql = "DELETE from accounts where contactId='$contactId';";
// $genre_sql = "DELETE from genres where contactId='$contactId';";
// $note_sql = "DELETE from notes where contactId='$contactId';";
// $messaging_services_sql = "DELETE from messaging_services where contactId='$contactId';";

mysqli_autocommit($conn, FALSE);


$query1 = mysqli_query($conn, $venues_sql);
// $query2 = mysqli_query($conn, $address_sql);
// $query3 = mysqli_query($conn, $emails_sql);
// $query4 = mysqli_query($conn, $phones_sql);
// $query5 = mysqli_query($conn, $account_sql);
// $query6 = mysqli_query($conn, $genre_sql);
// $query7 = mysqli_query($conn, $note_sql);
// $query8 = mysqli_query($conn, $messaging_services_sql);

if ($query1){
    mysqli_commit($conn);
    header("location: view.php");
    
}else{
    mysqli_rollback($conn);
    echo "An Error has Occurred!" . mysqli_error($conn) . "<br><a href='view.php'>Back</a>";
}
mysqli_close($conn);


?>