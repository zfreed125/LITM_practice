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
?>

<!-- https://stackoverflow.com/questions/2086313/store-am-pm-time-string-into-time-datatype-in-mysql-and-retrieve-with-am-pm-whil -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <title>LITM Media Masterbase</title>

</head>
<style>
    .wrapper{
            width: 500px;
        margin: 0 auto;
    }
</style>
<body>
<div class="wrapper">
    <h1 class="center">Create a Venue</h1>
    <form class="center" action="create.php" method="POST">
        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Venue Name</span></div>
            <input type="text" name="venueName" placeholder="">
        </div>

        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Venue Type</span></div>
            <select name="venueTypeId">
                <option selected="selected">Select Venue Type</option>
                    <?php foreach($venueType_array as $item){ ?>
                <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['venueType']; ?></option>
                    <?php } ?>
            </select>  
        </div>

        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Venue Contact</span></div>
            <select name="contactNameId">
                <option selected="selected">Select Contact</option>
                    <?php foreach($contacts_array as $item){ ?>
                <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                    <?php } ?>
            </select>   
        </div>

        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Venue Host</span></div>
            <select name="hostNameId">
                <option selected="selected">Select Host</option>
                    <?php foreach($contacts_array as $item){ ?>
                <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                    <?php } ?>
            </select>  
        </div>
        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-100">
         <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">Start Date</span></div>
            <input type="date" name="venueDateStart" class="form-control" placeholder="">
            <div class="input-group-prepend"><span class="input-group-text">Start Time</span></div>
            <input type="time" name="venueTimeStart" class="form-control" placeholder="">
        </div>
        <span class="input-group-addon">&nbsp</span>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">End Date</span></div>
            <input type="date" name="venueDateEnd" class="form-control" placeholder="">
            <div class="input-group-prepend"><span class="input-group-text">End Time</span></div>
            <input type="time" name="venueTimeEnd" class="form-control" placeholder="">
        </div>
        </div>



        <div class="input-group">
        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
            <div class="input-group-prepend"><span class="input-group-text">Show Length Minutes</span></div>
        <input type="number" name="showLength" placeholder="Show Length Minutes">
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
        </div>

    </form>
</div>
</body>
</html>