<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Venue</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="shortcut icon" href="../favicon.ico">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../tz.js"></script>
    <link rel="stylesheet" href="./css/view.css">
    <script src="./js/view.js" type="text/javascript"></script>
</head>

<body>
 <style type="text/css">
    body {
        font-size: 10px;
    }
        .wrapper {
            width: 100%;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }
        .table {
            border: 1px solid lightgrey;

        }
        .table th,
        .table td {
            width: 100px;
            padding: 0px 5px;
            margin: 0px;
            text-align: left;
        }
        table>thead::after 
        {
            display: none;
        }
        .fitwidth {
        }
</style>
    <div class="wrapper pull-left">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Venue List</h2>
                        <a href="../" style="float:left;font-size:18px;" class="" ><i class="fas fa-chevron-left"></i> Back</a>
                        <a href="add.php" style="float:right;" class="btn btn-success pull-right">Add New Venue</a>
                    </div>
                    <?php

                    require_once '../config.php';
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
                        $venueDate = $local_date->format('m-d-Y'); // output: 08-25-2020
                        $venueTime = $local_date->format('g:i A'); // output: 10:45 PM
                        // $venueTime = $local_date->format('g:i A'); // output: 10:45 PM

                        return array($venueDate, $venueTime);
                    }
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
                        $timezones_array[] = array('id' => $row['id'], 'name' => $row['name'], 'timezone' => $row['timezone']);
                    }
                    //contacts sql query loop table
                    $venues_sql = "SELECT * FROM venues;";
                    $venues_result = mysqli_query($conn, $venues_sql);
                    while ($row =  mysqli_fetch_assoc($venues_result)) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Venue Name</th>";
                        echo "<th>Venue Type</th>";
                        echo "<th>Contact Name</th>";
                        echo "<th>Host Name</th>";
                        echo "<th>Start Date/Time</th>";
                        echo "<th>End Date/Time</th>";
                        echo "<th>Timezone</th>";
                        echo "<th>Show Length</th>";
                        echo "<th>Active</th>";
                        // echo "<th>Created</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        echo "<tr>";
                        $venuesId = $row['id'];
                        foreach ($contacts_array as $item) {
                            if ($row['contactNameId'] == $item['id']) {
                                $contactFullname = $item['fullname'];
                            }
                            if ($row['hostNameId'] == $item['id']) {
                                $hostFullname = $item['fullname'];
                            }
                        }
                        foreach ($venue_type_array as $item) {
                            if ($row['venueTypeId'] == $item['id']) {
                                $venueType = $item['venueType'];
                            }
                        }
                        foreach ($timezones_array as $item) {
                            if ($row['timezoneId'] == $item['id']) {
                                $timezone = $item['timezone'];
                                $tz = $item['timezone'];
                            }
                        }
                        $StartDate = convertDateTimeUTCtoLocal($row['venueDateTimeStart'], $tz)[0];
                        $StartTime = convertDateTimeUTCtoLocal($row['venueDateTimeStart'], $tz)[1];
                        $EndDate = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'], $tz)[0];
                        $EndTime = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'], $tz)[1];
                        $StartDateTime = "$StartDate $StartTime";
                        $EndDateTime = "$EndDate $EndTime";
                        $primaryPhoneId = $row['primaryPhoneId'];
                        $primaryEmailId = $row['primaryEmailId'];
                        $primaryAddressId = $row['primaryAddressId'];
                        $primaryServiceId = $row['primaryServiceId'];
                        $primaryNoteId = $row['primaryNoteId'];
                        echo "<td class='fitwidth'>" . "$row[id]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[venueName]" . "</td>";
                        echo "<td class='fitwidth'>" . $venueType . "</td>";
                        echo "<td class='fitwidth'>" . $contactFullname . "</td>";
                        echo "<td class='fitwidth'>" . $hostFullname . "</td>";
                        echo "<td class='fitwidth'>" . "$StartDateTime" . "</td>";
                        echo "<td class='fitwidth'>" . "$EndDateTime" . "</td>";
                        echo "<td class='fitwidth'>" . $timezone . "</td>";
                        echo "<td class='fitwidth'>" . "$row[showLength]" . " Mins</td>";
                        echo "<td class='fitwidth'>" . "$row[active]" . "</td>";
                        // echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                        echo "<td class='fitwidth'>";
                        echo "<a href='edit.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                        // echo "<a href='delete.php?venueId=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                        echo "</td>";
                        echo "</tr>";

                        //account sql loop table
                        require './includes/account_loop.php';

                        //address sql query loop table
                        require './includes/address_loop.php';

                        //email sql loop table
                        require './includes/email_loop.php';

                        //genre sql loop table
                        require './includes/genre_loop.php';

                        //note sql query loop table
                        require './includes/note_loop.php';

                        //phone sql loop table
                        require './includes/phone_loop.php';

                        //Services sql query loop table
                        require './includes/service_loop.php';
                    } //end of contact loop
                    //end of the table from the contacts loop
                    echo "</tbody>";
                    echo "</table>";


                    ?>