<?php
$booking_sql = "SELECT * FROM booking_types;";
$result = mysqli_query($conn, $booking_sql);
$booking_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $booking_type_array[] = array('id' => $row['id'], 'bookingType' => $row['bookingType']);
}
$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts ORDER BY lastname ASC, firstname ASC;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
$genre_sql = "SELECT genres.id as gId, genres.contactId, genres.venueId, genres.genreTypeId, genre_types.* FROM genres INNER JOIN genre_types WHERE genre_types.id=genres.genreTypeId;";
$genre_results = mysqli_query($conn, $genre_sql);
$genre_array = array();
while ($row = mysqli_fetch_assoc($genre_results)) {
    $genre_array[] = array( 'id' => $row['gId'], 'genreName' => $row['genreType'], 'contactId' => $row['contactId'], 'venueId' => $row['venueId'] );
}

$venue_name_sql = "SELECT id, venueName FROM venues;";
$result = mysqli_query($conn, $venue_name_sql);
$venue_name_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
}
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}
?>