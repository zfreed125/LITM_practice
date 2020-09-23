<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $contactId = $_REQUEST['id'];

$contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM contacts;";
$contact_result = mysqli_query($conn, $contact_sql);
$contacts_array = array();
while ($row = mysqli_fetch_assoc($contact_result)) {
    $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
}
$venueType_sql = "SELECT * FROM venue_types;";
$venueType_result = mysqli_query($conn, $venueType_sql);
$venueType_array = array();
while ($row = mysqli_fetch_assoc($venueType_result)) {
    $venueType_array[] = array('id' => $row['id'], 'venueType' => $row['venueType']);
}
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}
?>

<!-- https://stackoverflow.com/questions/2086313/store-am-pm-time-string-into-time-datatype-in-mysql-and-retrieve-with-am-pm-whil -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../tz.js"></script>



    <title>LITM Media Masterbase</title>

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
<script src="./js/validation.js">
    
</script>

<body>
    <div class="wrapper">
        <h1 class="center">Create a Venue</h1>
        <!-- <form name="myForm" class="center" action="create.php" method="POST" onsubmit=""> -->
        <form name="myForm" class="center" action="create.php" method="POST" onsubmit="return validateForm()">
            <div class="input-group mt-3 mb-1 input-group-sm">
                <div class="input-group-prepend"><span class="input-group-text">Venue Name</span></div>
                <input type="text" name="venueName" onkeyup="this.nextElementSibling.classList.add('hide')">
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue Type</span></div>
                <select name="venueTypeId" onchange="this.nextElementSibling.classList.add('hide')">
                    <option value="-1" selected="selected">Select Venue Type</option>
                    <?php foreach ($venueType_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['venueType']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue Contact</span></div>
                <select name="contactNameId" onchange="this.nextElementSibling.classList.add('hide')">
                    <option value="-1" selected="selected">Select Contact</option>
                    <?php foreach ($contacts_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Venue Host</span></div>
                <select name="hostNameId" onchange="this.nextElementSibling.classList.add('hide')">
                    <option value="-1" selected="selected">Select Host</option>
                    <?php foreach ($contacts_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                    <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-100">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
                    <input style=" width: 50px;" type="date" onclick="this.nextElementSibling.classList.add('hide')" name="venueDateStart" class="form-control" placeholder="">
                    <div class="hide">
                        <p style="color: tomato;">* Required Field</p>
                    </div>
                    <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
                    <input type="time" name="venueTimeStart" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" placeholder="">
                    <div class="hide">
                            <p style="color: tomato;">* Required Field</p>
                    </div>
                </div>
                <!-- <span class="input-group-addon">&nbsp</span>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
                    <input style=" width: 50px;" type="date" onclick="this.nextElementSibling.classList.add('hide')" name="venueDateEnd" class="form-control" placeholder="">
                    <div class="hide">
                        <p style="color: tomato;">* Required Field</p>
                    </div>
                    <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
                    <input type="time" name="venueTimeEnd" onclick="this.nextElementSibling.classList.add('hide')" class="form-control" placeholder="">
                    <div class="hide">
                        <p style="color: tomato;">* Required Field</p>
                    </div>
                </div> -->
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm">
                <div class="input-group-prepend"><span class="input-group-text">Venue Timezone</span><select onchange="this.nextElementSibling.classList.add('hide')" name="timezoneId"></div>
                <!-- <option value="-1" selected="selected">Choose one</option> -->
                <option value="12" selected="selected">Default *(CST)</option>                <?php foreach ($timezones_array as $item) { ?>
                    <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['name']; ?></option>
                <?php } ?>
                </select>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>


            <div class="input-group">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Show Length Minutes</span></div>
                    <input class="form-control" type="number" name="showLength">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Active</span></div>
                    <input class="form-control" type="checkbox" id="active" name="active" value="active">
                    <!-- <label for="active">Active</label> -->
                </div>
            </div>
            <!-- <div class="m-5"> -->
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <button class="btn btn-primary" type="submit" name="submit">Submit</button>

        </form>
    </div>
</body>

</html>