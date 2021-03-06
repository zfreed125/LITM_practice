<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bookings</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <script src="./js/view.js"></script>
    <link rel="stylesheet" href="./css/view.css">
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
            /* border-top: 1px solid lightgrey;
            border-bottom: 1px solid lightgrey; */
        }
        /* table tr td:last-child a { 
        table.table:nth-child(8) > thead:nth-child(1),
        table.table:nth-child(11) > thead:nth-child(1) 
        thead:nth-child(5)::after */
        table>thead::after 
        {
            display: none;
            /* margin-right: 15px; */
        }
        .fitwidth {
            /* width: 500px; */
        }
                .dontShow {
        display: none;
        }
        .highLight {
        background-color: yellow !important;
        }
        .smallfield{
        width:20px !important;
        }
        .parent {
        width: 100%;
        border: 1px solid lightgrey;
        text-align: center;
        margin-bottom: 2em;
        background-color:#F2F2F2;
        }
        .title{
            border: 1px solid black;
            background-color:lightgrey;
            
        }
        
        .child {
            display: inline-block;  
            /* border: 1px solid red; */
            margin: 2px;
            
        }
</style>
</head>

<body>
    <div class="wrapper pull-left">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Booking List</h2>
                        <a href="../" style="float:left;font-size:18px;" class="" ><i class="fas fa-chevron-left"></i> Back</a>
                        <a href="add.php" style="float:right;" class="btn btn-success pull-right">Add New Booking</a>
                    </div>
                    <div class="parent">
                        <div class="title">Search Fields</div>
                        <span class="">
                            &nbsp 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchType()" id="searchTypeInput" placeholder="Search for Booking Type.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchVenueNames()" id="searchVenueNamesInput" placeholder="Search for Venue Name.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchContactNames()" id="searchContactNamesInput" placeholder="Search for Contact Name.."> 
                        </span>
                        <span class="child">
                            <input type="checkbox" onclick="ClientConfirm()" id="ClientConfirm" placeholder="Search for Client Confirm.."> 
                            <label for="searchActive">Only Client Confirm</label>
                        </span>
                        <span class="child">
                            <input type="checkbox" onclick="VenueConfirm()" id="VenueConfirm" placeholder="Search for Venue Confirm.."> 
                            <label for="searchActive">Only Venue Confirm</label>
                        </span>
                    </div>
                    <?php
                    // Include config file
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
                        // $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
                        $contacts_array[] = [$row['id'] => $row['fullname']];
                    }
                    $venue_name_sql = "SELECT id, venueName FROM venues;";
                    $result = mysqli_query($conn, $venue_name_sql);
                    $venue_name_array = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $venue_name_array[] = [$row['id'] => $row['venueName']];
                        // $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
                    }
                    $timezones_sql = "SELECT * FROM timezones;";
                    $timezones_result = mysqli_query($conn, $timezones_sql);
                    $timezones_array = array();
                    while ($row = mysqli_fetch_assoc($timezones_result)) {
                        $timezones_array[] = array('id' => $row['id'], 'timezone' => $row['timezone']);
                    }
                    //Attempt select query execution
                    $sql = "SELECT * FROM bookings ORDER BY id desc;";
                    echo "<table class='table table-bordered '>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Type</th>";
                    echo "<th>Start Date/Time</th>";
                    echo "<th>End Date/Time</th>";
                    echo "<th>Timezone</th>";
                    echo "<th>Length</th>";
                    echo "<th>Client Name</th>";
                    echo "<th>Client Confirm</th>";
                    echo "<th>Venue Name</th>";
                    echo "<th>Venue Confirm</th>";
                    echo "<th>Status</th>";
                    echo "<th></th>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";
                    echo "</tbody>";
                    echo "</table>";
                    if ($result = mysqli_query($conn, $sql)) {
                        // echo "<tbody>";
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $clientNameId = $row['clientNameId'];
                                $venueNameId = $row['venueNameId'];
                                ($row['clientConfirm'] == '1') ? $ClientConfirm = 'true' : $ClientConfirm = 'false';
                                ($row['venueConfirm'] == '1') ? $VenueConfirm = 'true' : $VenueConfirm = 'false';
                                // echo "($clientNameId $test)";
                                foreach ($booking_type_array as $item) {
                                    if ($item['id'] == $row['bookingTypeId']) {
                                        $bookingType = $item['bookingType'];
                                    }
                                }
                                echo "<div class='' data-type='".strtolower($bookingType)."' data-venuename='";
                                for ($i = 0; $i < count($venue_name_array); $i++) { $venue = $venue_name_array[$i][$venueNameId]; echo strtolower($venue); }
                                echo "' data-contactname='";
                                for ($h = 0; $h < count($contacts_array); $h++) { $clientFull = $contacts_array[$h][$clientNameId]; echo strtolower($clientFull); }
                                echo "' data-clientconfirm='".$ClientConfirm."' data-venueconfirm='".$VenueConfirm."'>";
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<tbody>";
                                foreach ($timezones_array as $item) {
                                    if ($item['id'] == $row['timezoneId']) {
                                        $timezone = $item['timezone'];
                                    }
                                }
                                (empty($row['bookingDateTimeStart'])) ? $StartDate = 'unset' : $StartDate = convertDateTimeUTCtoLocal($row['bookingDateTimeStart'], $timezone)[0];
                                (empty($row['bookingDateTimeStart'])) ? $StartTime = 'unset' : $StartTime = convertDateTimeUTCtoLocal($row['bookingDateTimeStart'], $timezone)[1];
                                (empty($row['bookingDateTimeEnd'])) ? $EndDate = 'unset' : $EndDate = convertDateTimeUTCtoLocal($row['bookingDateTimeEnd'], $timezone)[0];
                                (empty($row['bookingDateTimeEnd'])) ? $EndTime = 'unset' : $EndTime = convertDateTimeUTCtoLocal($row['bookingDateTimeEnd'], $timezone)[1];
                                $StartDateTime = "$StartDate $StartTime";
                                $EndDateTime = "$EndDate $EndTime";
                                $bookingId = $row['id'];
                                
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $bookingType . "</td>";
                                echo "<td>" . $StartDateTime . "</td>";
                                echo "<td>" . $EndDateTime . "</td>";
                                echo "<td>" . $timezone . "</td>";
                                echo "<td>" . $row['bookingLength'] . "</td>";
                                $htmlClient = htmlspecialchars('window.location.href="../contacts/edit.php?id='.$clientNameId.'"',ENT_QUOTES);
                                echo "<td ondblclick='dbclick($htmlClient)'><a href='#' title='Show/Hide accounts'  onclick='myFunction(tbl_client" . $row['id'] . ")'>";
                                for ($h = 0; $h < count($contacts_array); $h++) { $client = $contacts_array[$h][$clientNameId]; echo $client; }
                                echo "</a></td>";
                                // echo "<td>" . (!empty($client)) ? $row['clientNameId'] : $client . "</td>";
                                ($row['clientConfirm'] == '1') ? $isClientConfirm = 'Yes' : $isClientConfirm = 'No';
                                echo "<td>" . $isClientConfirm . "</td>";
                                // echo "<td>" . $venue . "</td>";
                                $htmlVenue = htmlspecialchars('window.location.href="../venues/edit.php?id='.$venueNameId.'"',ENT_QUOTES);
                                echo "<td ondblclick='dbclick($htmlVenue)'><a href='#' title='Show/Hide accounts'onclick='myFunction(tbl_venue" . $row['id'] . ")'>";
                                for ($i = 0; $i < count($venue_name_array); $i++) { $venue = $venue_name_array[$i][$venueNameId]; echo $venue; }
                                echo "</a></td>";
                                ($row['venueConfirm'] == '1') ? $isVenueConfirm = 'Yes' : $isVenueConfirm = 'No';
                                echo "<td>" . $isVenueConfirm . "</td>";
                                echo "<td>" . $row['bookingStatus'] . "</td>";
                                echo "<td>";
                                echo "<a href='view.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                                echo "<a href='edit.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                // echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                echo "</td>";
                                echo "</tr>";
                                
                                // echo "<div class='divmaster'>";
                                // echo "<span ";
                                require "./includes/venue_loop.php";
                                // echo "</span>";
                                // echo "<span ";
                                require "./includes/client_loop.php";
                                // echo "</span>";
                                
                                echo "</div>";
                            }
                            echo "</tbody>";
                        echo "</table>";


                            //Close connection
                            mysqli_close($conn);
                            //Free result set
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else {
                        echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    ?>
</body>

</html>