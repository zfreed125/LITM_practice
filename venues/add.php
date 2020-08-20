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
    .center {
        text-align: center;
        background-color: violet;
    }
</style>
<body>
    <h1 class="center">Create a Venue</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="venueName" placeholder="Venue Name">
        <br>
        <br>
        <select name="venueTypeId">
            <option selected="selected">Select Venue Type</option>
                <?php foreach($venueType_array as $item){ ?>
            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['venueType']; ?></option>
                <?php } ?>
        </select>  
        <br>
        <br>
        <select name="contactNameId">
            <option selected="selected">Select Contact</option>
                <?php foreach($contacts_array as $item){ ?>
            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                <?php } ?>
        </select>        
        <br>
        <br>
        <select name="hostNameId">
            <option selected="selected">Select Host</option>
                <?php foreach($contacts_array as $item){ ?>
            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['fullname']; ?></option>
                <?php } ?>
        </select>  
        <br>
        <br>
        <input type="datetime-local" name="venueDateStart" placeholder="Start Date/Time">
        <br>
        <br>
        <input type="datetime-local" name="venueDateEnd" placeholder="End Date/Time">
        <br>
        <br>
        <input type="number" name="showLength" placeholder="Show Length Minutes">
        <br>
        <br>
        <input type="checkbox" id="active" name="active" value="active">
        <label for="active">Active</label>
        <br>
        <br>
         <button type="submit" name="submit">Submit</button>

    </form>
</body>
</html>