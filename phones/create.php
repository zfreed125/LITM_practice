<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$primary = $_REQUEST['primary'];
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$phoneTypeId = $_REQUEST['phoneTypeId'];
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);

if (empty($venueId)){
    $phone_sql = "INSERT INTO phones (contactId, phoneTypeId, phone) VALUES ('$contactId', '$phoneTypeId', '$phone')";
    $dst = "contacts";
}else{
    $phone_sql = "INSERT INTO phones (venueId, phoneTypeId, phone) VALUES ('$venueId', '$phoneTypeId', '$phone')";
    $dst = "venues";
    
}

if(mysqli_query($conn, $phone_sql)){
    $primaryPhoneId = mysqli_insert_id($conn);
}else{
    echo "ERROR: Not able to execute $phone_sql. " . mysqli_error($conn);
}
if (empty($venueId)){
    $primary_sql = "UPDATE contacts set primaryPhoneId='$primaryPhoneId' where id='$contactId';";

}else{
    $primary_sql = "UPDATE venues set primaryPhoneId='$primaryPhoneId' where id='$venueId';";

}
if ($primary == 1) {
    if(mysqli_query($conn, $primary_sql)){
        header("location: ../$dst/view.php");
    }else{
        echo "ERROR: Not able to execute $primary_sql. " . mysqli_error($conn);
    }
}else{
    header("location: ../$dst/view.php");

}
    $conn->close();
?>