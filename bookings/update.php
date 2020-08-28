<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_REQUEST['id'];
$bookingTypeId = $_REQUEST['bookingTypeId'];
$bookingDateStart = $_REQUEST['bookingDateStart'];
$bookingTimeStart = $_REQUEST['bookingTimeStart'];
$bookingDateEnd = $_REQUEST['bookingDateEnd'];
$bookingTimeEnd = $_REQUEST['bookingTimeEnd'];
$timezoneId = $_REQUEST['timezoneId'];
$bookingLength = $_REQUEST['bookingLength'];
$clientNameId = $_REQUEST['clientNameId'];
$clientConfirm = (isset($_POST['clientConfirm'])) ? 1 : 0;
$venueNameId = $_REQUEST['venueNameId'];
$venueConfirm = (isset($_POST['venueConfirm'])) ? 1 : 0;
$bookingStatus = $_REQUEST['bookingStatus'];

$timezone_sql = "SELECT timezone from timezones where id='$timezoneId';";
$timezone_result = mysqli_query($conn, $timezone_sql);
if(mysqli_num_rows($timezone_result) > 0) {
    $row = mysqli_fetch_assoc($timezone_result);
    $tz = $row['timezone'];
}

function convertTimeDateTimezone($date,$time,$tz){
    $datetime ="$date $time";
    $tz = new DateTimeZone($tz);
    $dt = new DateTime("$datetime", $tz);
    $bookingDateTimeUtc = gmdate("Y-m-d H:i", $dt->getTimestamp());
    return $bookingDateTimeUtc;
}


(empty($bookingDateStart)) ? $bookingDateTimeStart = 'NULL': $bookingDateTimeStart = "'" .convertTimeDateTimezone($bookingDateStart,$bookingTimeStart,$tz). "'";
(empty($bookingDateEnd)) ? $bookingDateTimeEnd = 'NULL': $bookingDateTimeEnd = "'" .convertTimeDateTimezone($bookingDateEnd,$bookingTimeEnd,$tz). "'";
if (strpos($clientNameId, 'contact') !== false) {
    // echo 'Contact';
    $contactId = explode("contact", $clientNameId)[1];
    $sql = "UPDATE bookings set bookingTypeId='$bookingTypeId', bookingDateTimeStart=".$bookingDateTimeStart.", bookingDateTimeEnd=".$bookingDateTimeEnd.", timezoneId='$timezoneId', bookingLength='$bookingLength', 
        clientNameId='$clientNameId', contactId='$contactId', clientConfirm='$clientConfirm', venueNameId='$venueNameId', venueConfirm='$venueConfirm', bookingStatus='$bookingStatus' where id='$id';";
    }else if (strpos($clientNameId, 'venue') !== false)
    {
        // echo 'Venue';
        $venueId = explode("venue", $clientNameId)[1];
        $sql = "UPDATE bookings set bookingTypeId='$bookingTypeId', bookingDateTimeStart=".$bookingDateTimeStart.", bookingDateTimeEnd=".$bookingDateTimeEnd.", timezoneId='$timezoneId', bookingLength='$bookingLength', 
            clientNameId='$clientNameId', venueId='$venueId', clientConfirm='$clientConfirm', venueNameId='$venueNameId', venueConfirm='$venueConfirm', bookingStatus='$bookingStatus' where id='$id';";
    }
if($clientNameId == '0'){
    $sql = "UPDATE bookings set bookingTypeId='$bookingTypeId', bookingDateTimeStart=".$bookingDateTimeStart.", bookingDateTimeEnd=".$bookingDateTimeEnd.", timezoneId='$timezoneId', bookingLength='$bookingLength', 
        clientConfirm='$clientConfirm', venueNameId='$venueNameId', venueConfirm='$venueConfirm', bookingStatus='$bookingStatus' where id='$id';";
}else{
    $sql = "UPDATE bookings set bookingTypeId='$bookingTypeId', bookingDateTimeStart=".$bookingDateTimeStart.", bookingDateTimeEnd=".$bookingDateTimeEnd.", timezoneId='$timezoneId', bookingLength='$bookingLength', 
        clientNameId='$clientNameId', clientConfirm='$clientConfirm', venueNameId='$venueNameId', venueConfirm='$venueConfirm', bookingStatus='$bookingStatus' where id='$id';";
}


if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
?>