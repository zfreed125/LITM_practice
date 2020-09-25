<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'includes/type_arrays.php';

$id = $_GET["id"];
//attempt insert query execution
$emails_sql = "select * from bookings where id='$id';";
$result2 = mysqli_query($conn, $emails_sql);
//output data of each row
while ($row = mysqli_fetch_assoc($result2)) {
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
}
// (empty($venueNameId)) ? $venueNameId = '0' : $venueNameId = $venueNameId;
// echo "Venueid is not showing correctly:$venueNameId";
$timezone_sql = "SELECT timezone from timezones where id='$timezoneId';";
$timezone_result = mysqli_query($conn, $timezone_sql);
if (mysqli_num_rows($timezone_result) > 0) {
    $row = mysqli_fetch_assoc($timezone_result);
    $tz = $row['timezone'];
}

require 'includes/convertDateTimeUTCtoLocal.php';

(empty($bookingDateTimeStart)) ? $StartDate = 'unset' : $StartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[0];
(empty($bookingDateTimeStart)) ? $StartTime = 'unset' : $StartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[1];
(empty($bookingDateTimeEnd)) ? $EndDate = 'unset' : $EndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[0];
(empty($bookingDateTimeEnd)) ? $EndTime = 'unset' : $EndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[1];

require 'includes/bookings_array.php';
// require 'includes/venue_array.php';

$conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/middle_finger.css">

    <!-- moment.js && moment-timezone.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.31/moment-timezone-with-data.js" integrity="sha512-ECoTMVFwwVtxjEBRjUMjviUd6hBjwDhBJI0+3W2YDs+ld5rHHUDr59T15gxwEPkGu5XLmkASUSvPgQe/Tpyodg==" crossorigin="anonymous"></script>
</head>
<script src="js/generateTags.js"></script>
<script src="js/validate.js"></script>
<script >
    var selected_contact = '<?php echo $clientNameId; ?>';
    var selected_venue = '<?php echo $venueNameId; ?>';
    var genre_array = <?php echo json_encode($genre_array) ?>;
    var genre_array_original = <?php echo json_encode($genre_array) ?>;
    var bookings_array = <?php echo json_encode($bookings_array) ?>;
    var contacts_array = <?php echo json_encode($contacts_array) ?>;
    var venue_name_array_from_db = <?php echo json_encode($venue_name_array) ?>;
</script>
<script src="js/gsearch.js"></script>
<script src="js/showBookings.js"></script>
<script >
function changeVenueList(venue_list){
    const venue_name_array = venue_list;
    return venue_name_array
}



window.addEventListener('load', (event) => {
    updateGenreTags( selected_contact, 'genreContactTags', 'contactId', getValueFromClientSelect );
    updateGenreTags( selected_venue, 'genreVenueTags', 'venueId', getValueFromVenueSelect );
    showBookingsForClient(selected_contact);
    getVenueList(venue_name_array_from_db);

    var contacts_array = <?php echo json_encode($contacts_array) ?>;
    var client_select = document.getElementById('clientNameId');
    var i;
    for (i = 0; i < contacts_array.length; i++) {
        var opt = contacts_array[i];
        var el = document.createElement("option");
        if (opt['id'] === selected_contact) {
            el.selected = true;
        }
        el.textContent = opt['fullname'];
        el.value = opt['id'];
        client_select.appendChild(el);
    }

    var x = document.getElementById("clientConfirm").value;
    if ('<?php echo $clientConfirm; ?>' === '1') {
        document.getElementById("clientConfirm").checked = true;
    } else {
        document.getElementById("clientConfirm").checked = false;
    }
    var y = document.getElementById("venueConfirm").value;
    if ('<?php echo $venueConfirm; ?>' === '1') {
        document.getElementById("venueConfirm").checked = true;
    } else {
        document.getElementById("venueConfirm").checked = false;
    }

}); //window load
</script>

<body>
    <div class="wrapper">
        <h2>Update Booking</h2>
        <p>Please edit the input values and submit to update the record.</p>
        <form name="myForm" action="update.php" method="POST" onsubmit="return formValidate()">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Booking Type</span></div>
                <select class="form-control" onchange="this.nextElementSibling.classList.add('hide')" name="bookingTypeId" id="bookingTypeId">
                    <option value="-1" selected="selected">Choose one</option>
                    <?php foreach ($booking_type_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $bookingTypeId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['bookingType']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-4">
                <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                <input style=" width: 50px;" type="date" name="bookingDateStart" class="form-control" value="<?php echo $StartDate; ?>">
                <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                <input type="time" name="bookingTimeStart" class="form-control" value="<?php echo $StartTime; ?>">
            </div>
            <!-- <span class="input-group-addon">&nbsp</span>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                <input style=" width: 50px;" type="date" name="bookingDateEnd" class="form-control" value="<?php //echo $EndDate; ?>">
                <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                <input type="time" name="bookingTimeEnd" class="form-control" value="<?php //echo $EndTime; ?>">
            </div> -->
            <div class="input-group mt-3 mb-1 input-group-sm p-1">
                <div class="input-group-prepend"><span class="input-group-text">Timezone</span></div>
                <select style=" width: 375px;" name="timezoneId" class="form-control">
                    <option value="-1" selected="selected">Select Timezone</option>
                    <?php foreach ($timezones_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $timezoneId) {
                                                                                    echo "selected";
                                                                                } ?>> <?php echo $item['name']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>

            </div>
            <div class="input-group">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Booking Length Minutes</span></div>
                    <input class="form-control" type="number" name="bookingLength" value="<?php echo $bookingLength; ?>">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Contact/Client</span></div>
                <select class="form-control"  name="clientNameId" id="clientNameId" onchange="getValueFromClientSelect(this.value)">
                    <option value="-1">Select Client</option>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div style=" position: absolute; left: 840px; top: 370px;" class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div style="height: 40px;" class="input-group-prepend"><span class="input-group-text">Client Genre Tags</span></div>
                <div title="*If you add a tag 'all' you will get all venues."id="genreContactTags" ondblclick="createInputTag(this.id, 'addTagToClient', 'btnTagToClient', addTagFromClientInput, getValueFromClientSelect)" style="border: 1px solid black; min-width: 250px; max-width: 250px; "></div>
            </div>
            <div class="input-group mt-5 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Client Confirm</span></div>
                    <input class="form-control" type="checkbox" id="clientConfirm" name="clientConfirm">
                </div>
            </div>
            <div class="input-group mt-5 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue/Venue Client</span></div>
                <select class="form-control"  name="venueNameId" id='venueNameId' onchange="getValueFromVenueSelect(this.value)">
                    <option value="-1">Select Venue</option>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div style=" position: absolute; left: 840px; top: 550px;" class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div style="height: 40px;" class="input-group-prepend"><span class="input-group-text">Venue Genre Tags</span></div>
                <div id="genreVenueTags"  style="border: 1px solid black; min-width: 250px; max-width: 250px; "> </div>
                <!-- <div id="genreVenueTags" ondblclick="createInputTag(this.id, 'addTagToVenue', 'btnTagToVenue', addTagFromVenueInput, getValueFromVenueSelect)" style="border: 1px solid black; min-width: 250px; max-width: 250px; "> </div> -->
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Venue Confirm</span></div>
                    <input class="form-control" type="checkbox" id="venueConfirm" name="venueConfirm">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Venue Confirm</span></div>
                    <input class="form-control" type="text" id="bookingStatus" name="bookingStatus" value="<?php echo $bookingStatus; ?>">
                </div>
            </div>
            <div class="bookingsDetails" id="bookingsByClient"></div>

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="m-5">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-danger" href="delete.php?id=<?php echo $id; ?>">Delete</a>
                <a class="btn btn-secondary" href="view.php">X</a>
            </div>
        </form>
    </div>
</body>
<script>

</script>

</html>