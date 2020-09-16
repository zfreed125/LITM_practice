<?php

require_once '../config.php';
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
    $bookingTime = $local_date->format('H:i'); // output: 10:45 PM

    return array($bookingDate, $bookingTime);
}
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//attempt insert query execution
$bookings_sql = "select * from bookings;";
$result = mysqli_query($conn, $bookings_sql);
//output data of each row
$bookings_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $bookingTypeId = $row["bookingTypeId"];
    $bookingDateTimeStart = $row["bookingDateTimeStart"];
    $bookingDateTimeEnd = $row["bookingDateTimeEnd"];
    $timezoneId = $row["timezoneId"];
    $bookingLength = $row["bookingLength"];
    $clientNameId = $row["clientNameId"];
    $clientConfirm = $row["clientConfirm"];
    $venueNameId = $row["venueNameId"];
    $venueConfirm = $row["venueConfirm"];
    $bookingStatus = $row["bookingStatus"];

    $venue_name_sql = "SELECT id,primaryNoteId,primaryServiceId,venueName,hostNameId FROM venues WHERE id='$venueNameId';";
    $venue_result = mysqli_query($conn, $venue_name_sql);
    while ($row = mysqli_fetch_assoc($venue_result)) {
        $venue_name_array[] = [$row['id'] => $row['venueName']];
        $primaryVenueNoteId = $row['primaryNoteId'];
        $primaryVenueServiceId = $row['primaryServiceId'];
        $primaryVenueHostNameId = $row['hostNameId'];
    }
    $host_sql = "SELECT id,primaryEmailId, CONCAT(firstname, ' ', lastname) as fullname FROM contacts WHERE id='$primaryVenueHostNameId';";
    $host_result = mysqli_query($conn, $host_sql);
    while ($row = mysqli_fetch_assoc($host_result)) {
        $hostFullName = $row['fullname'];
        $hostPrimaryEmailId = $row['primaryEmailId'];
    }
    $contact_sql = "SELECT id,bookingColor,primaryEmailId, CONCAT(firstname, ' ', lastname) as fullname FROM contacts WHERE id='$clientNameId';";
    $contact_result = mysqli_query($conn, $contact_sql);
    while ($row = mysqli_fetch_assoc($contact_result)) {
        $clientFullName = $row['fullname'];
        $bookingColor = $row['bookingColor'];
        $clientPrimaryEmailId = $row['primaryEmailId'];
    }
    
    $hostPrimaryEmail = 'unasigned';
    $email_sql = "SELECT email FROM emails where id = '$hostPrimaryEmailId';";
    $email_result = mysqli_query($conn, $email_sql);
    while ($email_row = mysqli_fetch_assoc($email_result)) {
        $hostPrimaryEmail = $email_row['email'];
    }
    $clientPrimaryEmail = 'unasigned';
    $email_sql = "SELECT email FROM emails where id = '$clientPrimaryEmailId';";
    $email_result = mysqli_query($conn, $email_sql);
    while ($email_row = mysqli_fetch_assoc($email_result)) {
        $clientPrimaryEmail = $email_row['email'];
    }
    $primaryVenueNote = 'unasigned';
    $note_sql = "SELECT note FROM notes where id = '$primaryVenueNoteId';";
    $note_result = mysqli_query($conn, $note_sql);
    while ($note_row = mysqli_fetch_assoc($note_result)) {
        $primaryVenueNote = $note_row['note'];
    }
    $primaryVenueServiceName = 'unasigned';
    $primaryVenueServiceUserAccount = 'unasigned';
    $primaryVenueServiceWebsite = 'unasigned';
    $primaryVenueServiceNotes = 'unasigned';
    $service_sql = "SELECT * FROM services where id = '$primaryVenueServiceId';";
    $service_result = mysqli_query($conn, $service_sql);
    while ($service_row = mysqli_fetch_assoc($service_result)) {
        $primaryVenueServiceName = $service_row['serviceName'];
        $primaryVenueServiceUserAccount = $service_row['userAccount'];
        $primaryVenueServiceWebsite = $service_row['website'];
        $primaryVenueServiceNotes = $service_row['notes'];
    }
    // TODO: add primary email address from contacts (primaryAddressId) if not null, to booking so we can email from calendar
    // TODO: add venue host name website and notes
    
    $booking_sql = "SELECT * FROM booking_types WHERE id='$bookingTypeId';";
    $booking_result = mysqli_query($conn, $booking_sql);
    while ($row = mysqli_fetch_assoc($booking_result)) {
        $bookingType = $row['bookingType'];
    }

    $timezone_sql = "SELECT * from timezones where id='$timezoneId';";
    $timezone_result = mysqli_query($conn, $timezone_sql);
    if (mysqli_num_rows($timezone_result) > 0) {
        $row = mysqli_fetch_assoc($timezone_result);
        $clientTzId = $row['id'];
        $clientTzOffset = $row['offset'];
        $clientTzName = $row['timezone'];
        $tz = 'America/Chicago'; // Default Calendar TimeZone
        // $tz = $row['timezone'];
    }

    (empty($bookingDateTimeStart)) ? $StartDate = 'unset' : $StartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[0];
    (empty($bookingDateTimeStart)) ? $StartTime = 'unset' : $StartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[1];
    (empty($bookingDateTimeEnd)) ? $EndDate = 'unset' : $EndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[0];
    (empty($bookingDateTimeEnd)) ? $EndTime = 'unset' : $EndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[1];
    for ($i = 0; $i < count($venue_name_array); $i++) { $venueName = $venue_name_array[$i][$venueNameId]; }
    $bookings_array[] = array(
        'bookingType' => $bookingType,
        'StartDate' => $StartDate,
        'bookingDateTimeStart' => $bookingDateTimeStart,
        'StartTime' => $StartTime,
        'bookingDateTimeEnd' => $bookingDateTimeEnd,
        'EndDate' => $EndDate,
        'EndTime' => $EndTime,
        'timezone' => $tz,
        'bookingLength' => $bookingLength,
        'clientFullName' => $clientFullName,
        'clientNameId' => $clientNameId,
        'clientPrimaryEmail' => $clientPrimaryEmail,
        'primaryVenueNote' => $primaryVenueNote,
        'bookingColor' => $bookingColor,
        'clientConfirm' => $clientConfirm,
        'venueName' => $venueName,
        'hostFullName' => $hostFullName,
        'hostPrimaryEmail' => $hostPrimaryEmail,
        'venueConfirm' => $venueConfirm,
        'bookingStatus' => $bookingStatus,
        'primaryVenueServiceName' => $primaryVenueServiceName,
        'primaryVenueServiceUserAccount' => $primaryVenueServiceUserAccount,
        'primaryVenueServiceWebsite' => $primaryVenueServiceWebsite,
        'primaryVenueServiceNotes' => $primaryVenueServiceNotes,
        'clientTzId' => $clientTzId
    );
}
?>