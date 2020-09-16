<?php

(!empty($_REQUEST['month'])) ? $month = $_REQUEST['month'] : $month = idate('m');
(!empty($_REQUEST['year'])) ? $year = $_REQUEST['year'] : $year = idate('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    input{
        width: 75px;
        margin-left: 20px;
    }
    .wrapper{
        display: flex;  

    }
    .card{
        margin: 20px;
        padding: 10px;
        max-width: 15%;
        text-align: center;
	    flex-flow: row wrap;

    }
    .container > div{

    }
    .dot {
        height: 25px;
        width: 25px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
</style>
<body>
<form name="myForm" action="index.php" method="POST">
<span>
    <h3>Month: <input name="month" type="text" value="<?php echo $month; ?>"> Year: <input name="year" type="text" value="<?php echo $year; ?>"><input class="btn btn-primary" type="submit" name="submit" value="Submit"></h3>
      
</span>    
</form>
    <div class='wrapper'>

<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts ORDER BY lastname ASC, firstname ASC;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
$venue_name_sql = "SELECT id, venueName FROM venues;";
$result = mysqli_query($conn, $venue_name_sql);
$venue_name_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
}
$client_booking_count_array = [];
$sql = "SELECT clientNameId,venueNameId, MONTH(bookingDateTimeStart) as bookingMonth,YEAR(bookingDateTimeStart) as bookingYear FROM bookings ;";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)){
  
  $clientNameId = $row['clientNameId'];
  $venueNameId = $row['venueNameId'];
  $bookingMonth = $row['bookingMonth'];
  $bookingYear = $row['bookingYear'];

foreach ($venue_name_array as $venue_item) {
    if($row['venueNameId'] == $venue_item['id']){
        $venueName = $venue_item['venueName'];
    }
}
  $sql_contact = "SELECT bookingColor, bookingCount as bookingCountTotal FROM contacts WHERE id='$clientNameId';";
  $result_client = mysqli_query($conn, $sql_contact);
  while ($crow = mysqli_fetch_assoc($result_client)){
    $bookingCountTotal = $crow['bookingCountTotal'];
    $bookingColor = $crow['bookingColor'];
  }
    $client_booking_count_array[] = array(
      'contactId' => $clientNameId,
      'venuename' => $venueName,
      'bookingColor' => $bookingColor,
      'bookingMonth' => $bookingMonth,
      'bookingYear' => $bookingYear,
      'bookingCountTotal' => $bookingCountTotal
    );
    
}
$todo_array = array();
$client_booking_count = array();

foreach ($client_booking_count_array as $booking) {
    if ($booking['bookingYear'] == $year) {
        foreach ($contacts_array as $contact_item) {
            if($booking['contactId'] == $contact_item['id']){
                // array_push($client_booking_count,$contact_item['id']);
                $todo_array[$contact_item['id']] = array(
                    'fullname' => $contact_item['fullname'],
                    'bookingColor' => $booking['bookingColor'],
                    'bookingCountTotal' => $booking['bookingCountTotal'],
                    'bookings' => 0);
                    
            }
        }
        if ($booking['bookingMonth'] == $month) {
            foreach ($contacts_array as $contact_item) {
                if($booking['contactId'] == $contact_item['id']){
                    array_push($client_booking_count,$contact_item['id']);
                    $todo_array[$contact_item['id']] = array(
                        'fullname' => $contact_item['fullname'],
                        'bookingColor' => $booking['bookingColor'],
                        'bookingCountTotal' => $booking['bookingCountTotal'],
                        'bookings' => array_count_values($client_booking_count)[$contact_item['id']]);
                        
                }
            }
        } // If Month
    }else{ // If Year
    foreach ($contacts_array as $contact_item) {
            if($booking['contactId'] == $contact_item['id']){
                // array_push($client_booking_count,$contact_item['id']);
                $todo_array[$contact_item['id']] = array(
                    'fullname' => $contact_item['fullname'],
                    'bookingColor' => $booking['bookingColor'],
                    'bookingCountTotal' => $booking['bookingCountTotal'],
                    'bookings' => 0);
                    
            }
        }
    }
}   
    // echo "<pre>";
    // echo print_r($todo_array);
    // echo "</pre>";
    foreach ($todo_array as $todo_item) {
        $card = " <div class='card'><div class='container'> ";
        $card .= " <h4><b>".$todo_item['fullname']."</b></h4> <!-- <p>Venue Name</p> --> ";
        
        for ($x = 1; $x <= $todo_item['bookingCountTotal']; $x++) {
            if($x > $todo_item['bookings']){
                $card .= "<div><span style='background-color: grey;' class='dot'></span></div>";
            }else{
                $card .= "<div><span style='background-color: ".$todo_item['bookingColor'].";' class='dot'></span></div>";
            }
        } 
        $card .= " </div> </div> ";
        echo $card;
        }

?>
</div>
</body>
</html>