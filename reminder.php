<?php
require_once 'config.php';
function get_timezone_abbreviation($timezone_id)
{
    if($timezone_id){
        $abb_list = timezone_abbreviations_list();

        $abb_array = array();
        foreach ($abb_list as $abb_key => $abb_val) {
            foreach ($abb_val as $key => $value) {
                $value['abb'] = $abb_key;
                array_push($abb_array, $value);
            }
        }

        foreach ($abb_array as $key => $value) {
            if($value['timezone_id'] == $timezone_id){
                return strtoupper($value['abb']);
            }
        }
    }
    return FALSE;
} 
function convertDateTimeUTCtoLocal($bookingDateTime, $tz)
{
    $utc_date = DateTime::createFromFormat(
        'Y-m-d H:i:s',  // this the format from mysql
        // 'Y-m-d G:i',  // this the format from mysql
        $bookingDateTime, // this is the output from mysql $bookingDateTime...
        new DateTimeZone('UTC')
    );
    //
    $local_date = $utc_date;
    $local_date->setTimeZone(new DateTimeZone($tz));
    //
    $bookingDate = $local_date->format('n-j-Y'); // output: 08-25-2020
    $bookingTime = $local_date->format('h:ia'); // output: 10:45 PM

    return array($bookingDate, $bookingTime);
}
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rawdata = file_get_contents('php://input');
$data = json_decode($rawdata, true);
$bookingId = $data['bookingId'];
$reminder = $data['reminder'];
$bookingType = $data['bookingType'];
$StartDate = $data['StartDate'];
$bookingDateTimeStart = $data['bookingDateTimeStart'];
$StartTime = $data['StartTime'];
$bookingDateTimeEnd = $data['bookingDateTimeEnd'];
$EndDate = $data['EndDate'];
$EndTime = $data['EndTime'];
$litmTimezoneName = $data['timezone'];
$litmTimezoneId = 12;
$litmTimezoneOffset = '-06:00';
$litmTimezoneName = 'America/Chicago';
$bookingLength = $data['bookingLength'];
$clientFullName = $data['clientFullName'];
$clientNameId = $data['clientNameId'];
$bookingColor = $data['bookingColor'];
$clientConfirm = $data['clientConfirm'];
$venueName = $data['venueName'];
$hostFullName = $data['hostFullName'];
$venueConfirm = $data['venueConfirm'];
$bookingStatus = $data['bookingStatus'];

$primaryVenueId = $data['primaryVenueId'];
$primaryVenueNoteId = $data['primaryVenueNoteId'];

$bookingLiveRecorded = $data['bookingLiveRecorded'];
$bookingAudioOnly = $data['bookingAudioOnly'];

if ($bookingLiveRecorded === '0') {
    $bookingLiveRecorded = 'Live';
  } else {
    $bookingLiveRecorded = 'Pre-Recorded';
  }
 if ($bookingAudioOnly === '0') {
      $bookingAudioOnly = 'Audio&Video';
    } else {
      $bookingAudioOnly = 'Audio Only';
    }

$primaryVenueNote = $data['primaryVenueNote'];
$clientPrimaryEmailId = $data['clientPrimaryEmailId'];
$clientPrimaryEmail = $data['clientPrimaryEmail'];
$hostPrimaryEmailId = $data['hostPrimaryEmailId'];
$hostPrimaryEmail = $data['hostPrimaryEmail'];
$clientPrimaryNoteId = $data['clientPrimaryNoteId'];
$clientPrimaryNote = $data['clientPrimaryNote'];
$primaryVenueServiceId = $data['primaryVenueServiceId'];
$primaryVenueServiceName = $data['primaryVenueServiceName'];
$primaryVenueServiceUserAccount = $data['primaryVenueServiceUserAccount'];
$primaryVenueServiceWebsite = $data['primaryVenueServiceWebsite'];
$primaryVenueServiceNotes = $data['primaryVenueServiceNotes'];
$clientTzId = $data['clientTzId'];
$pacificTimezoneId = 5;
$pacificTimezoneName = 'America/Los_Angeles';
$to = "$clientPrimaryEmail";
// $to = "admin@callitweb.com";
// $to = "admin@callitweb.com, mich721@gmail.com";
// $to = "somebody@example.com, somebodyelse@example.com";
$subject = "Booking Schedule: For(" . $clientFullName . ")";


$timezone_sql = "SELECT * from timezones where id='$clientTzId';";
    $timezone_result = mysqli_query($conn, $timezone_sql);
    if (mysqli_num_rows($timezone_result) > 0) {
        $row = mysqli_fetch_assoc($timezone_result);
        $clientTzId = $row['id'];
        $clientTzOffset = $row['offset'];
        $clientTimezoneName = $row['timezone'];
    }

    (empty($bookingDateTimeStart)) ? $litmStartDate = 'unset' : $litmStartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $litmTimezoneName)[0];
    (empty($bookingDateTimeStart)) ? $litmStartTime = 'unset' : $litmStartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $litmTimezoneName)[1];
    (empty($bookingDateTimeEnd)) ? $litmEndDate = 'unset' : $litmEndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $litmTimezoneName)[0];
    (empty($bookingDateTimeEnd)) ? $litmEndTime = 'unset' : $litmEndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $litmTimezoneName)[1];

    (empty($bookingDateTimeStart)) ? $clientStartDate = 'unset' : $clientStartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $clientTimezoneName)[0];
    (empty($bookingDateTimeStart)) ? $clientStartTime = 'unset' : $clientStartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $clientTimezoneName)[1];
    (empty($bookingDateTimeEnd)) ? $clientEndDate = 'unset' : $clientEndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $clientTimezoneName)[0];
    (empty($bookingDateTimeEnd)) ? $clientEndTime = 'unset' : $clientEndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $clientTimezoneName)[1];
    
    (empty($bookingDateTimeStart)) ? $pacificStartDate = 'unset' : $pacificStartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $pacificTimezoneName)[0];
    (empty($bookingDateTimeStart)) ? $pacificStartTime = 'unset' : $pacificStartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $pacificTimezoneName)[1];
    (empty($bookingDateTimeEnd)) ? $pacificEndDate = 'unset' : $pacificEndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $pacificTimezoneName)[0];
    (empty($bookingDateTimeEnd)) ? $pacificEndTime = 'unset' : $pacificEndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $pacificTimezoneName)[1];




// $Source = "$pacificStartTime-$pacificEndTime";


function removeDuplicateAmPm($formattedTimeString){

    $delDuplicates = function ($amOrPm, $src){
        $FIRST_OCCURENCE = 1;
        $FOUND_INSTANCES_COUNT = 2;
        $bothArePm = substr_count($src, $amOrPm) == $FOUND_INSTANCES_COUNT;
        return $bothArePm ? preg_replace("/$amOrPm/", '',$src, $FIRST_OCCURENCE) : $src;
    };
    
    $hasPm = substr_count($formattedTimeString, 'am') <= 0;
    return $hasPm ? $delDuplicates('pm', $formattedTimeString) : $delDuplicates('am', $formattedTimeString);
}

$pacificStartEnd = removeDuplicateAmPm("$pacificStartTime-$pacificEndTime");
$clientStartEnd = removeDuplicateAmPm("$clientStartTime-$clientEndTime");
$litmStartEnd = removeDuplicateAmPm("$litmStartTime-$litmEndTime");




$tz_alias = array();
$sql = "SELECT timezone,alias FROM timezones;";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)){
    $tz_alias[$row['alias']] = $row['timezone'];
}
function checkForAliasTZ($timezoneName,$tz_alias){
    $TzAbbrev = array_search($timezoneName,$tz_alias);
    if(empty($TzAbbrev)){
        $TzAbbrev = get_timezone_abbreviation($timezoneName);
    }
    return $TzAbbrev;
}

// }
$litmTimezoneName = checkForAliasTZ($litmTimezoneName,$tz_alias);
$clientTimezoneName = checkForAliasTZ($clientTimezoneName,$tz_alias);
$pacificTimezoneName = checkForAliasTZ($pacificTimezoneName,$tz_alias);



$pacificSource = "$pacificStartEnd $pacificTimezoneName";
$clientSource = "$clientStartEnd $clientTimezoneName ";
$litmSource = "$litmStartEnd $litmTimezoneName";


// echo $pacificSource;
// echo $clientSource;
// echo $litmSource;
// $times = "$pacificStartEnd $pacificTimezoneName $clientStartEnd $clientTimezoneName $litmStartEnd $litmTimezoneName";
// $times = implode(' ',array_unique(explode(' ', $times)));
// echo $times;
$times = array();
array_push($times,"$pacificStartDate $pacificStartEnd ($pacificTimezoneName)", "$clientStartDate $clientStartEnd ($clientTimezoneName)", "$litmStartDate $litmStartEnd ($litmTimezoneName)");
$times = array_unique($times);
foreach ($times as $v) {
    $t .= "$v<br>";
}

$start = explode('-', $litmStartDate);
$month = $start[0];
$day = $start[1];
$year = $start[2];
$real_start = implode('-', [$day, $month, $year]);

$time = strtotime($real_start);

$litmStartDate = date('l, F jS',$time);

$reminder = "
    <html>
    <head>
    <title>Booking Reminder</title>
    </head>
    <body>
    <h3>Booking Reminder For " . $clientFullName . " </h3>
    <table>
        <tr>
            <th style='text-align: left;'>Date:</th>
            <td style='text-align: left;'>" . $litmStartDate . "</td>
        </tr>
        <tr>
            <th style='text-align: left;'>Time:</th>
            <td style='text-align: left;'>" . $t . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Host:</th>
            <td style='text-align: left;'>" . $hostFullName . " (" . $hostPrimaryEmail . ")</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Show Type:</th>
            <td style='text-align: left;'>" . $bookingLiveRecorded . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Audio/Video:</th>
            <td style='text-align: left;'>" . $bookingAudioOnly . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Length of Interview:</th>
            <td style='text-align: left;'>" . $bookingLength . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Website:</th>
            <td style='text-align: left;'>" . $primaryVenueServiceWebsite . "</td> 
        </tr>
        <tr>
        </tr>

        <br>
        <br>
    </table>
    </body>
    </html>
";

$signature = <<<SIGNATURE
    <div class="signature" style="height: 120px;width: 70%; margin-top: 2em;">
        <div class="logo" style="display: inline-block; margin:0; padding: 0;">
            <img
            src="https://ci3.googleusercontent.com/proxy/r5QP5P6T_WDQRE6TJNt9fDkJGl0vEl96dSnZQ9qZmWqhOdwN7GZLmfEFabihsPUa8qfrjeNxjvpxdzhdnkBc2A64i7p4mLOirNAiBo7yyRPo8JSoCmrhsN2nnt3Xr9WhXJMYe_2voaaeITFN4HS1WwhJi3d1yxJxbCNauRdhdQgkV2tKqOmg_Hl9DxIkpTQrYmq60mjVWLJRu_KAew=s0-d-e1-ft#https://docs.google.com/uc?export=download&id=1KFwppgNkPJgHCfNZb2KZsYmX6VGRuY-9&revid=0Bw3hvFN4lg78OU9pZU9zZUQzTlRlWkF6NlZMOG1GYmxmOEhvPQ"
            alt="Logo"
            height="90"
            style="display: inline-block;"
            />
        </div>

        <div class="company" style="display: inline-block;">
            <div class="employee" style="font-weight: bold">Michelle Freed, Publicist</div>
            <div class="company-name">LITM Media</div>
            <div class="byline">&quot;Leave it to Michelle&quot;</div>
            <div class="phone"><a href="tel:14244095486">424-409-5486</a></div>
            <div class="website"><a href="https://litmmedia.com/">https://litmmedia.com</a></div>
        </div>
    </div>
SIGNATURE;

$message = <<<HTML
<div>
    $reminder
    $signature
</div>
HTML;


echo $message;
$sql = "UPDATE bookings set reminder='1' where id='$bookingId';";

if(mysqli_query($conn, $sql)){
    header("location: ../calendar/");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}
$conn->close();
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <michelle@litmmedia.com>' . "\r\n";
$headers .= 'Cc: michelle@litmmedia.com' . "\r\n";

mail($to, $subject, $message, $headers);

