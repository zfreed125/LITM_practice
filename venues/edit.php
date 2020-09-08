<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) as fullname FROM contacts;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
$venue_types_sql = "SELECT * FROM venue_types;";
$venue_types_result = mysqli_query($conn, $venue_types_sql);
$venue_type_array = array();
while ($row = mysqli_fetch_assoc($venue_types_result)) {
    $venue_type_array[] = array('id' => $row['id'], 'venueType' => $row['venueType']);
}
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}



$id = $_GET["id"];
$venues_sql = "SELECT * FROM venues where id='$id';";
$venues_result = mysqli_query($conn, $venues_sql);
// output data of each row
while ($row = mysqli_fetch_assoc($venues_result)) {
    $active = $row["active"];
    $venueName = $row["venueName"];
    $venueTypeId = $row["venueTypeId"];
    $contactNameId = $row["contactNameId"];
    $hostNameId = $row["hostNameId"];
    $venueDateTimeStart = $row["venueDateTimeStart"];
    $venueDateTimeEnd = $row['venueDateTimeEnd'];
    $timezoneId = $row['timezoneId'];
    $showLength = $row['showLength'];
    $bookingAuto = $row['bookingAuto'];
    $bookingCount = $row['bookingCount'];
    $bookingColor = $row['bookingColor'];
}
$timezone_sql = "SELECT timezone from timezones where id='$timezoneId';";
$timezone_result = mysqli_query($conn, $timezone_sql);
if (mysqli_num_rows($timezone_result) > 0) {
    $row = mysqli_fetch_assoc($timezone_result);
    $tz = $row['timezone'];
}

function convertDateTimeUTCtoLocal($venueDateTime, $tz)
{
    $utc_date = DateTime::createFromFormat(
        'Y-m-d H:i:s',  // this the format from mysql
        // 'Y-m-d G:i',  // this the format from mysql
        $venueDateTime, // this is the output from mysql $venueDateTime...
        new DateTimeZone('UTC')
    );
    //
    $local_date = $utc_date;
    $local_date->setTimeZone(new DateTimeZone($tz));
    //
    $venueDate = $local_date->format('Y-m-d'); // output: 08-25-2020
    $venueTime = $local_date->format('H:i'); // output: 10:45 PM

    return array($venueDate, $venueTime);
}
$account_sql = "SELECT accounts.accountTypeId, account_types.id, account_types.accountType as typeName  FROM accounts 
INNER JOIN account_types ON accounts.accountTypeId=account_types.id WHERE accounts.venueId=$id;";
$account_result = mysqli_query($conn, $account_sql);
$is_client = False;
while ($row = mysqli_fetch_assoc($account_result)) {
    if ($row['typeName'] == 'Client') {
        $is_client = True;
    }
}
$conn->close();
?>
<!-- // HTML Form -->
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/validation.js"></script>
    <style type="text/css">
        .wrapper {
            width: 800 px;
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
        window.addEventListener('load', (event) => {

            var x = document.getElementById("active").value;
            if (x == 1) {
                document.getElementById("active").checked = true;
            } else {
                document.getElementById("active").checked = false;
            }
            var x = document.getElementById("bookingAuto").value;
            if (x == 1) {
                document.getElementById("bookingAuto").checked = true;
            } else {
                document.getElementById("bookingAuto").checked = false;
            }

            if ('<?php echo $is_client; ?>' !== '1') {
                document.getElementById("client").style.display = "none";
            }



        });
    </script>

</head>

<body>
    <div class="wrapper">
        <h2>Update Record</h2>
        <p>Please edit the input values and submit to update the record.</p>
        <form name="myForm" action="update.php" method="post" onsubmit="return validateForm()">

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue Name</span></div>
                <input type="text" name="venueName" class="form-control" value="<?php echo $venueName; ?>" onkeyup="this.nextElementSibling.classList.add('hide')">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue Type</span></div>
                <select name="venueTypeId" onchange="this.nextElementSibling.classList.add('hide')" class="form-control">
                    <option value="-1" selected="selected">Select Venue Type</option>
                    <?php foreach ($venue_type_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $venueTypeId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['venueType']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Contact</span></div>
                <select name="contactNameId" onchange="this.nextElementSibling.classList.add('hide')" class="form-control">
                    <option value="-1" selected="selected">Select Contact Name</option>
                    <?php foreach ($contacts_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $contactNameId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['fullname']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Host</span></div>
                <select name="hostNameId" onchange="this.nextElementSibling.classList.add('hide')" class="form-control">
                    <option value="-1" selected="selected">Select Host Name</option>
                    <?php foreach ($contacts_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $hostNameId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['fullname']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-4">
                <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                <input style=" width: 50px;" type="date" name="venueDateStart" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" value="<?php echo convertDateTimeUTCtoLocal($venueDateTimeStart, $tz)[0]; ?>">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
                <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                <input type="time" name="venueTimeStart" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" value="<?php echo convertDateTimeUTCtoLocal($venueDateTimeStart, $tz)[1]; ?>">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <span class="input-group-addon">&nbsp</span>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                <input style=" width: 50px;" type="date" name="venueDateEnd" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" value="<?php echo convertDateTimeUTCtoLocal($venueDateTimeEnd, $tz)[0]; ?>">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
                <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                <input type="time" name="venueTimeEnd" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" value="<?php echo convertDateTimeUTCtoLocal($venueDateTimeEnd, $tz)[1]; ?>">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Timezone</span></div>
                <select name="timezoneId" onchange="this.nextElementSibling.classList.add('hide')" class="form-control">
                    <option value="-1" selected="selected">Select Timezone</option>
                    <?php foreach ($timezones_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $timezoneId) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $item['name']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Show Length</span></div>
                <input type="number" name="showLength" class="form-control" value="<?php echo $showLength; ?>">
            </div>
            <div id="client">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Auto Monthly Bookings</span></div>
                    <input type="checkbox" name="bookingAuto" id="bookingAuto" class="form-control" value="<?php echo $bookingAuto; ?>">
                </div>
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Booking Amount Per Month</span></div>
                    <input type="number" id="bookingCount" name="bookingCount" class="form-control w-25" value="<?php echo $bookingCount; ?>">
                </div>
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Booking Color</span></div>
                    <input type="color" id="bookingColor" class="form-control" name="bookingColor" value="<?php echo $bookingColor; ?>">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Active</span></div>
                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="is_client" value="<?php echo $is_client; ?>" />
            <input type="submit" class="btn btn-primary" value="Submit">
            <br>
            <br>
            <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
            <a class="btn btn-danger" href="delete.php?id=<?php echo $id; ?>">Delete</a>
            <br>
            <br>
            <a class="btn btn-default" href="view.php">Cancel</a>
        </form>
    </div>
</body>

</html>