<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$id = $_REQUEST['id'];
$is_client = $_REQUEST['is_client'];
$venueName = mysqli_real_escape_string($conn, $_REQUEST['venueName']);
$venueTypeId = $_REQUEST['venueTypeId'];
$contactNameId =  $_REQUEST['contactNameId'];
$hostNameId =  $_REQUEST['hostNameId'];
$showLength = mysqli_real_escape_string($conn, $_REQUEST['showLength']);
$venueDateStart = mysqli_real_escape_string($conn, $_REQUEST['venueDateStart']);
$venueTimeStart = $_REQUEST['venueTimeStart'];
$venueDateEnd = mysqli_real_escape_string($conn, $_REQUEST['venueDateEnd']);
$venueTimeEnd = $_REQUEST['venueTimeEnd'];
$timezoneId = $_REQUEST['timezoneId'];
if ($is_client){
    $bookingAuto = (isset($_POST['bookingAuto'])) ? 1 : 0;
    $bookingCount = $_REQUEST['bookingCount'];
    $bookingColor = $_REQUEST['bookingColor'];
    
}else{
    $bookingAuto = 0;
    $bookingCount = 0;
    $bookingColor = 0;

}
$bookingLiveRecorded = (isset($_POST['bookingLiveRecorded'])) ? 1 : 0;
$bookingAudioOnly = (isset($_POST['bookingAudioOnly'])) ? 1 : 0;
$active = (isset($_POST['active'])) ? 1 : 0;

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
    $venueDateTimeUtc = gmdate("Y-m-d H:i", $dt->getTimestamp());
    return $venueDateTimeUtc;
}

// $venueDateTimeStart = convertTimeDateTimezone($venueDateStart,$venueTimeStart,$tz);
// $venueDateTimeEnd = convertTimeDateTimezone($venueDateEnd,$venueTimeEnd,$tz);

$end = date('Y-m-d H:i',strtotime("+{$showLength} minutes",strtotime($venueDateTimeStart)));


(empty($venueDateStart)) ? $venueDateTimeStart = 'NULL': $venueDateTimeStart = "'" .convertTimeDateTimezone($venueDateStart,$venueTimeStart,$tz). "'";
(empty($venueDateStart)) ? $vDateTimeStart = 'NULL': $vDateTimeStart =  convertTimeDateTimezone($venueDateStart,$venueTimeStart,$tz) ;

$venueend =  date('Y-m-d H:i',strtotime("+{$showLength} minutes",strtotime($vDateTimeStart)));

$end = "'" .$venueend. "'";

(empty($venueDateStart)) ? $end = 'NULL': $end = "'" .$venueend. "'";

// Attempt insert query execution
$sql = "UPDATE venues set venueName='$venueName', venueTypeId='$venueTypeId', contactNameId='$contactNameId', hostNameId='$hostNameId', 
venueDateTimeStart=".$venueDateTimeStart.", venueDateTimeEnd=".$end.", timezoneId='$timezoneId', showLength='$showLength', bookingAuto='$bookingAuto', bookingCount='$bookingCount', bookingColor='$bookingColor', bookingLiveRecorded='$bookingLiveRecorded',bookingAudioOnly='$bookingAudioOnly',active='$active' where id='$id';";
if(mysqli_query($conn, $sql)){
    // echo "Records added successfully.";
    header("location: view.php");
    die();
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    
    $conn->close();

?>