<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$bookingTypeId = $_REQUEST['bookingTypeId'];
$bookingDateStart = $_REQUEST['bookingDateStart'];
$bookingTimeStart = $_REQUEST['bookingTimeStart'];
$bookingDateEnd = $_REQUEST['bookingDateEnd'];
$bookingTimeEnd = $_REQUEST['bookingTimeEnd'];
$timezoneId = $_REQUEST['timezoneId'];
$bookingLength = (empty($_REQUEST['bookingLength'])) ? 0 : $_REQUEST['bookingLength'];
$clientNameId = ($_REQUEST['clientNameId'] == '-1') ? 'NULL' : $_REQUEST['clientNameId'];
$clientConfirm = (isset($_POST['clientConfirm'])) ? 1 : 0;
$venueNameId = ($_REQUEST['venueNameId'] == '-1') ? 'NULL' : $_REQUEST['venueNameId'];
$venueConfirm = (isset($_POST['venueConfirm'])) ? 1 : 0;
$bookingStatus = $_REQUEST['bookingStatus'];
// echo $bookingDateStart;
// die();

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
(empty($bookingDateStart)) ? $bDateTimeStart = 'NULL': $bDateTimeStart =  convertTimeDateTimezone($bookingDateStart,$bookingTimeStart,$tz) ;
// (empty($bookingDateEnd)) ? $bookingDateTimeEnd = 'NULL': $bookingDateTimeEnd = "'" .convertTimeDateTimezone($bookingDateEnd,$bookingTimeEnd,$tz). "'";

$bookend =  date('Y-m-d H:i',strtotime("+{$bookingLength} minutes",strtotime($bDateTimeStart)));
$end = "'" .$bookend. "'";
(empty($bookingDateStart)) ? $end = 'NULL': $end = "'" .$bookend. "'";
// echo $end;
// die();
$sql = "INSERT INTO bookings (bookingTypeId, bookingDateTimeStart, bookingDateTimeEnd, timezoneId, bookingLength, clientNameId, clientConfirm, venueNameId, venueConfirm, bookingStatus)
    VALUES ('$bookingTypeId', ".$bookingDateTimeStart.", ".$end.", '$timezoneId', '$bookingLength', ".$clientNameId.", ".$clientConfirm.", ".$venueNameId.", '$venueConfirm', 'Initialized');";

if(mysqli_query($conn, $sql)){
    header("location: view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
    $conn->close();

?>
