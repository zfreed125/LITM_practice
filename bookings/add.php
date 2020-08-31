<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$booking_sql = "SELECT * FROM booking_types;";
$result = mysqli_query($conn, $booking_sql);
$booking_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $booking_type_array[] = array('id' => $row['id'], 'bookingType' => $row['bookingType']);
}
require_once './includes/guest_array.php';
        arsort($guest_array);
        
require_once './includes/venue_array.php';

$venue_name_sql = "SELECT id, venueName FROM venues;";
$result = mysqli_query($conn, $venue_name_sql);
$venue_name_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
}
$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
        arsort($contacts_array);
        foreach($contacts_array as $item){
        $contact = $item['fullname'];
        $contactId = $item['id'];
        }
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Booking Register</title>
</head>

<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>

<body>
    <div class="wrapper">
        <h1>Add a Booking</h1>
        <form action="create.php" method="POST">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Booking Type</span></div>
                    <select class="form-control" name="bookingTypeId" id="bookingTypeId">
                        <option selected="selected">Choose one</option>
                            <?php foreach($booking_type_array as $item){ ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['bookingType']; ?></option>
                            <?php } ?>
                    </select>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-100">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                <input style=" width: 65px;" type="date" name="bookingDateStart" class="form-control" value="NULL">
                <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                <input type="time" name="bookingTimeStart" class="form-control">
            </div>
            <span class="input-group-addon">&nbsp</span>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                <input style=" width: 65px;" type="date" name="bookingDateEnd" class="form-control">
                <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                <input type="time" name="bookingTimeEnd" class="form-control">
            </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Booking Timezone</span><select class="form-control" name="timezoneId"></div>
                        <option value="12" selected="selected">Default *(CST)</option>
                            <?php foreach($timezones_array as $item){ ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['name']; ?></option>
                            <?php } ?>
                    </select>

        </div>
            <div class="input-group">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Booking Length Minutes</span></div>
                    <input class="form-control" type="number" name="bookingLength">
                </div>
            </div>  
            <script>

            document.getElementById('bookingTypeId').addEventListener('change', function() {
            console.log('You selected: ', this.value);
            if(this.value === '1'){
                <?php  foreach($guest_array as $item){
                $client = $item['client'];
                $clientContactId = $item['contactId'];
                ?> 

                clientNameId = document.getElementById('clientNameId');
                    for (var i = min; i<=max; i++){
                    var opt = document.createElement('option');
                    opt.value = i;
                    opt.innerHTML = i;
                    clientNameId.appendChild(opt);
                    }
                    
                console.log('<?php echo $client;?>');
                <?php } ?>
            }
            });

            // what is bookingTypeId
            //if bookingtypeId is guest then 
                                // dispaly options for client of contacts else 
                                // displlay optins for all contacts
            </script>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Contact/Client</span></div>
                    <select class="form-control" name="clientNameId" id="clientNameId">
                        <option selected="selected">Select Client</option>
                    </select>   
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Client Confirm</span></div>
                    <input class="form-control" type="checkbox" id="clientConfirm" name="clientConfirm">
                </div>
            </div>
            <script>
            // what is bookingTypeId
            //if bookingtypeId is venue then 
                                // dispaly options for client of venues else 
                                // displlay optins for all venues
            </script>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue/Venue Client</span></div>
                    <select class="form-control" name="venueNameId">
                        <option value="0" selected="selected">Select Venue</option>
                            <?php foreach($venue_name_array as $item){ ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['venueName']; ?></option>
                            <?php } ?>
                    </select>  
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Venue Confirm</span></div>
                    <input class="form-control" type="checkbox" id="venueConfirm" name="venueConfirm">
                </div>
            </div>
                <br>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
    </div>
     </form>
</body>
</html>

