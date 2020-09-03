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
    $genre_array[] = array(
        'id' => $row['gId'],
        'genreName' => $row['genreType'],
        'contactId' => $row['contactId'],
        'venueId' => $row['venueId']
    );
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

$timezone_sql = "SELECT timezone from timezones where id='$timezoneId';";
$timezone_result = mysqli_query($conn, $timezone_sql);
if (mysqli_num_rows($timezone_result) > 0) {
    $row = mysqli_fetch_assoc($timezone_result);
    $tz = $row['timezone'];
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
    $bookingDate = $local_date->format('Y-m-d'); // output: 08-25-2020
    $bookingTime = $local_date->format('H:i'); // output: 10:45 PM

    return array($bookingDate, $bookingTime);
}

(empty($bookingDateTimeStart)) ? $StartDate = 'unset' : $StartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[0];
(empty($bookingDateTimeStart)) ? $StartTime = 'unset' : $StartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $tz)[1];
(empty($bookingDateTimeEnd)) ? $EndDate = 'unset' : $EndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[0];
(empty($bookingDateTimeEnd)) ? $EndTime = 'unset' : $EndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $tz)[1];

$conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/middle_finger.css">
    <style type="text/css">
    body{
        width: 1400px;
    }
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }

        .btn-delete {
            display: inline-block;
            margin-left: 1em;
            background: red;
            color: white;
            font-weight: bold;
            padding: 0.25em;
        }
    </style>
</head>
<script>
    var selected_contact = '<?php echo $clientNameId; ?>';
    var selected_venue = '<?php echo $venueNameId; ?>';

    function updateClientGenreTags(clientNameId) {
        let genre_array = <?php echo json_encode($genre_array) ?>;
        let genreTagDiv = document.getElementById('genreContactTags');
        while (genreTagDiv.hasChildNodes()) {
            genreTagDiv.removeChild(genreTagDiv.lastChild);
        }
        let h;
        for (h = 0; h < genre_array.length; h++) {
            let el = document.createElement("span");
            let tag = genre_array[h];
            if (tag['contactId'] === clientNameId) {
                el.innerHTML = tag['genreName'] + ' <span class="btn-delete">X</span>';
                el.className = 'badge badge-primary p-2 m-1 fu';
                el.addEventListener('click', () => {
                    console.log(tag['genreName']);
                    genreTagDiv.removeChild(el);
                })
                genreTagDiv.appendChild(el);
            }
        }

    }

    function updateVenueGenreTags(venueNameId) {
        let genre_array = <?php echo json_encode($genre_array) ?>;
        let genreTagDiv = document.getElementById('genreVenueTags');
        while (genreTagDiv.hasChildNodes()) {
            genreTagDiv.removeChild(genreTagDiv.lastChild);
        }
        let h;
        for (h = 0; h < genre_array.length; h++) {
            let el = document.createElement("span");
            let tag = genre_array[h];
            if (tag['venueId'] === venueNameId) {
                el.innerHTML = tag['genreName'] + ' <span class="btn-delete">X</span>';
                el.className = 'badge badge-primary p-2 m-1 fu';
                el.addEventListener('click', () => {
                    console.log(tag['genreName']);
                    genreTagDiv.removeChild(el);
                })
                genreTagDiv.appendChild(el);
            }
        }

    }

    function getValueFromClientSelect(clientId) {
        updateClientGenreTags(clientId);
    }

    function getValueFromVenueSelect(venueId) {
        updateVenueGenreTags(venueId);
    }
    window.addEventListener('load', (event) => {

        updateClientGenreTags(selected_contact);
        updateVenueGenreTags(selected_venue);


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
        var venue_name_array = <?php echo json_encode($venue_name_array) ?>;
        var venue_select = document.getElementById('venueNameId');
        var j;
        for (j = 0; j < venue_name_array.length; j++) {
            var opt = venue_name_array[j];
            var el = document.createElement("option");
            if (opt['id'] === selected_venue) {
                el.selected = true;
            }
            el.textContent = opt['venueName'];
            el.value = opt['id'];
            venue_select.appendChild(el);
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
        <form action="update.php" method="POST">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Booking Type</span></div>
                <select class="form-control" name="bookingTypeId">
                    <option selected="selected">Choose one</option>
                    <?php foreach ($booking_type_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $bookingTypeId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['bookingType']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group mt-4">
                <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                <input style=" width: 50px;" type="date" name="bookingDateStart" class="form-control" value="<?php echo $StartDate; ?>">
                <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                <input type="time" name="bookingTimeStart" class="form-control" value="<?php echo $StartTime; ?>">
            </div>
            <span class="input-group-addon">&nbsp</span>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                <input style=" width: 50px;" type="date" name="bookingDateEnd" class="form-control" value="<?php echo $EndDate; ?>">
                <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                <input type="time" name="bookingTimeEnd" class="form-control" value="<?php echo $EndTime; ?>">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1">
                <div class="input-group-prepend"><span class="input-group-text">Timezone</span></div>
                <select style=" width: 375px;" name="timezoneId" class="form-control">
                    <option selected="selected">Select Timezone</option>
                    <?php foreach ($timezones_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $timezoneId) {
                                                                                    echo "selected";
                                                                                } ?>> <?php echo $item['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Booking Length Minutes</span></div>
                    <input class="form-control" type="number" name="bookingLength" value="<?php echo $bookingLength; ?>">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Contact/Client</span></div>
                <select class="form-control" name="clientNameId" id="clientNameId" onchange="getValueFromClientSelect(this.value)">
                    <option value=''>Select Client</option>
                </select>
            </div>
            <div style=" position: absolute; left: 840px; top: 370px;" class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div style="height: 40px;" class="input-group-prepend"><span class="input-group-text">Client Genre Tags</span></div>
                <div id="genreContactTags" style="border: 1px solid black; max-width: 250px;"> </div>
            </div>
            <div class="input-group mt-5 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Client Confirm</span></div>
                    <input class="form-control" type="checkbox" id="clientConfirm" name="clientConfirm">
                </div>
            </div>
            <div class="input-group mt-5 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue/Venue Client</span></div>
                <select class="form-control" name="venueNameId" id='venueNameId' onchange="getValueFromVenueSelect(this.value)">
                    <option value=''>Select Venue</option>
                </select>
            </div>
            <div style=" position: absolute; left: 840px; top: 550px;" class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div style="height: 40px;" class="input-group-prepend"><span class="input-group-text">Venue Genre Tags</span></div>
                <div id="genreVenueTags" style="border: 1px solid black; max-width: 250px;"> </div>
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

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="m-5">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-danger" href="delete.php?id=<?php echo $id; ?>">Delete</a>
            </div>
        </form>
    </div>
</body>
<script>

</script>

</html>