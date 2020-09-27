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
$sql1 = "CREATE TABLE venues (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    active INT(1) DEFAULT 1,
    venueName VARCHAR(64) NULL,
    venueTypeId INT(6) NULL,
    contactNameId INT(6) NULL,
    hostNameId INT(6) NULL,
    venueDateTimeStart DATETIME NULL,
    venueDateTimeEnd DATETIME NULL,
    timezoneId INT(3) NULL,
    showLength INT(8) NULL,
    bookingCount INT(3) NULL,
    bookingAuto INT(1) NULL,
    bookingColor VARCHAR(32) NULL,
    primaryAddressId INT(6) NULL,
    primaryEmailId INT(6) NULL,
    primaryPhoneId INT(6) NULL,
    primaryServiceId INT(6) NULL,
    primaryNoteId INT(6) NULL,
    bookingLiveRecorded INT(1) NULL,
    bookingAudioOnly INT(1) NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql1) === TRUE) {
      echo "Table venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }



?>
