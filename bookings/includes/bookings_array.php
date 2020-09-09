<?php
$bookings = "SELECT * FROM bookings;";
$bookings_result = mysqli_query($conn, $bookings);
$bookings_array = array();
while ($brow = mysqli_fetch_assoc($bookings_result)) {

    foreach ($timezones_array as $tzitem) {
        if ($tzitem['id'] == $brow["timezoneId"]) {
            $ttz = $tzitem['name'];
        }
    }
    $bDateTimeStart = $brow["bookingDateTimeStart"];
    $bDateTimeEnd = $brow["bookingDateTimeEnd"];
    (empty($bDateTimeStart)) ? $bStartDate = 'unset' : $bStartDate = convertDateTimeUTCtoLocal($bDateTimeStart, $ttz)[0];
    (empty($bDateTimeStart)) ? $bStartTime = 'unset' : $bStartTime = convertDateTimeUTCtoLocal($bDateTimeStart, $ttz)[1];
    (empty($bDateTimeEnd)) ? $bEndDate = 'unset' : $bEndDate = convertDateTimeUTCtoLocal($bDateTimeEnd, $ttz)[0];
    (empty($bDateTimeEnd)) ? $bEndTime = 'unset' : $bEndTime = convertDateTimeUTCtoLocal($bDateTimeEnd, $ttz)[1];
    
    foreach ($booking_type_array as $bitem) { 
        if ($bitem['id'] == $brow['bookingTypeId']) {
            $bbookingType = $bitem['bookingType']; 
        }
    }
    
    $bookings_array[] = array(
        'id' => $brow['id'],
        'bookingType' => $bbookingType,
        'bStartDate' => $bStartDate,
        'bStartTime' => $bStartTime,
        'bEndDate' => $bEndDate,
        'bEndTime' => $bEndTime,
        'timezone' => $ttz,
        'bookingLength' => $brow["bookingLength"],
        'clientNameId' => $brow["clientNameId"],
        'clientConfirm' => $brow["clientConfirm"],
        'venueNameId' => $brow["venueNameId"],
        'venueConfirm' => $brow["venueConfirm"],
        'bookingStatus' => $brow["bookingStatus"]
    );
}
?>