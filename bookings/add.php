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
arsort($venue_array);

$venue_name_sql = "SELECT id, venueName FROM venues;";
$result = mysqli_query($conn, $venue_name_sql);
$venue_name_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
}
// ORDER BY
//    column1 [ASC|DESC],
$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts ORDER BY lastname ASC, firstname ASC;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
// arsort($contacts_array);
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
    .wrapper {
        width: 800px;
        margin: 0 auto;
    }

    .hide {
        display: none;
    }

    p {
        padding-left: 10px;
        padding-right: 5px;
    }
</style>
<script>
    window.addEventListener('load', function() {
        var contacts_array = <?php echo json_encode($contacts_array) ?>;
        var client_select = document.getElementById('clientNameId');
        var i;
        for (i = 0; i < contacts_array.length; i++) {
            var opt = contacts_array[i];
            var el = document.createElement("option");
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
            el.textContent = opt['venueName'];
            el.value = opt['id'];
            venue_select.appendChild(el);
        }
    });
</script>
<script>
    function formValidate() {
        var venueName = document.forms["myForm"]["venueNameId"];
        var clientName = document.forms["myForm"]["clientNameId"];
        var bookingType = document.getElementById("bookingTypeId");

        if (bookingType.value == "-1") {
            bookingType.nextElementSibling.classList.remove("hide");
            bookingType.focus();
            return false;
        }

        if (bookingType.value == "2") {
            if (venueName.value == "-1") {
                venueName.nextElementSibling.classList.remove("hide");
                venueName.focus();
                return false;
            }
        } else if (bookingType.value == "1") {
            if (clientName.value == "-1") {
                clientName.nextElementSibling.classList.remove("hide");
                clientName.focus();
                return false;
            }
        }
    }
</script>

<body>
    <div class="wrapper">
        <h1>Add a Booking</h1>
        <form name="myForm" action="create.php" method="POST" onsubmit="return formValidate()">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">Booking Type</span></div>
                <select class="form-control" onchange="this.nextElementSibling.classList.add('hide')" name="bookingTypeId" id="bookingTypeId">
                    <option value='-1'>Choose one</option>
                    <?php foreach ($booking_type_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['bookingType']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-100">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                    <input style=" width: 65px;" type="date" name="bookingDateStart" class="form-control" value="NULL">
                    <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                    <input type="time" name="bookingTimeStart" class="form-control">
                </div>
                <!-- <span class="input-group-addon">&nbsp</span>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                    <input style=" width: 65px;" type="date" name="bookingDateEnd" class="form-control">
                    <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                    <input type="time" name="bookingTimeEnd" class="form-control">
                </div> -->
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Booking Timezone</span><select class="form-control" name="timezoneId"></div>
                <option value="12" selected="selected">Default *(CST)</option>
                <?php foreach ($timezones_array as $item) { ?>
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

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Contact/Client</span></div>
                <select class="form-control" onchange="this.nextElementSibling.classList.add('hide')" name="clientNameId" id="clientNameId">
                    <option value='-1'>Select Client</option>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field When Booking Type is Guest</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Client Confirm</span></div>
                    <input class="form-control" type="checkbox" id="clientConfirm" name="clientConfirm">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue/Venue Client</span></div>
                <select class="form-control" onchange="this.nextElementSibling.classList.add('hide')" name="venueNameId" id="venueNameId">
                    <option value='-1'>Select Venue</option>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field When Booking Type is Venue</p>
                </div>
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