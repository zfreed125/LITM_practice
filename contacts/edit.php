<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}


$id = $_GET["id"];
$sql = "select id, firstname, lastname, birthdate, timezoneId, jobTitle, bookingAuto, bookingCount, bookingColor, active from contacts where id='$id';";
$result = mysqli_query($conn, $sql);
// output data of each row
while ($row = mysqli_fetch_assoc($result)) {
    $contactId = $row["id"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $birthdate = $row["birthdate"];
    $timezoneId = $row["timezoneId"];
    $jobTitle = $row['jobTitle'];
    $bookingAuto = $row['bookingAuto'];
    $bookingCount = $row['bookingCount'];
    $bookingColor = $row['bookingColor'];
    $active = $row["active"];
}
$account_sql = "SELECT accounts.accountTypeId, account_types.id, account_types.accountType as typeName  FROM accounts 
INNER JOIN account_types ON accounts.accountTypeId=account_types.id WHERE accounts.contactId=$id;";
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
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
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

<body class="body">
    <div class="wrapper">
        <h2>Update Record</h2>
        <p>Please edit the input values and submit to update the record.</p>
        <form action="update.php" method="post">

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">First Name</span></div>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Last Name</span></div>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Birth Date</span></div>
                <input type="date" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Job Title</span></div>
                <input type="text" name="jobTitle" class="form-control" value="<?php echo $jobTitle; ?>">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1">
                <div class="input-group-prepend"><span class="input-group-text label">Timezone</span></div>
                <select style=" width: 375px;" name="timezoneId" class="form-control">
                    <option selected="selected">Select Timezone</option>
                    <?php foreach ($timezones_array as $item) { ?>
                        <option value="<?php echo strtolower($item['id']); ?>" <?php if ($item['id'] == $timezoneId) {
                                                                                    echo "selected";
                                                                                } ?>> <?php echo $item['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div id="client">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text label">Auto Monthly Bookings</span></div>
                    <input type="checkbox" name="bookingAuto" id="bookingAuto" class="form-control" value="<?php echo $bookingAuto; ?>">
                </div>
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text label">Booking Amount Per Month</span></div>
                    <input type="number" id="bookingCount" name="bookingCount" class="form-control w-25" value="<?php echo $bookingCount; ?>">
                </div>
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text label">Booking Color</span></div>
                    <input type="color" id="bookingColor" class="form-control" name="bookingColor" value="<?php echo $bookingColor; ?>">
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Active</span></div>
                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="is_client" value="<?php echo $is_client; ?>" />
            <input type="submit" class="btn btn-primary" value="Submit">
            <br>
            <br>
            <!-- <a class="btn btn-danger" href="delete.php?id=<?php echo $id; ?>">Delete</a> -->
            <br>
            <br>
            <a class="btn btn-default" href="view.php">Cancel</a>
        </form>
    </div>
</body>

</html>