<?php

$sql = "SELECT * FROM account_types WHERE accountType='Client';";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $clientTypeId = $row['id'];
  }
$client_array = array();
$venueId_sql = "SELECT venueId  FROM accounts WHERE accountTypeId='$clientTypeId' AND venueId IS NOT NULL;";
$venueId_result = mysqli_query($conn, $venueId_sql);
while ($row = mysqli_fetch_assoc($venueId_result)) {
    $client_venueId = $row['venueId'];
    $venue_sql = "SELECT id, venueName  FROM venues WHERE id='$client_venueId';";
    $venue_result = mysqli_query($conn, $venue_sql);
    while ($row = mysqli_fetch_assoc($venue_result)) {
      $client_array[] = array(
        'id' => $row['id'],
        'type' => 'venue',
        'client' => $row['venueName']);
    }
}

$contactId_sql = "SELECT contactId  FROM accounts WHERE accountTypeId='$clientTypeId' AND contactId IS NOT NULL;";
$contactId_result = mysqli_query($conn, $contactId_sql);

while ($row = mysqli_fetch_assoc($contactId_result)) {
    $client_contactId = $row['contactId'];
    $contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM contacts WHERE id='$client_contactId';";
    $contact_result = mysqli_query($conn, $contact_sql);
    while ($row = mysqli_fetch_assoc($contact_result)) {
      $client_array[] = array(
        'id' => $row['id'],
       'type' => 'contact',
       'client' => $row['fullname']);
    }
}
// foreach($client_array as $item){
//             $client = $item['client'];
//             $type = $item['type'];
//             $clientId = $item['id'];
//             echo"$type $clientId $client <br>";
// }

?>