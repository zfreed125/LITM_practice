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
    <div class="wrapper pull-left">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Venue List</h2>
                        <a href="../" style="float:left;font-size:18px;" class="" ><i class="fas fa-chevron-left"></i> Back</a>
                        <a href="#" onclick='collapseAll()' style="margin-left:500px;font-size:18px;" class="" ><i class="fas fa-chevron-down"></i> Collapse All</a>
                        <a href="add.php" style="float:right;" class="btn btn-success pull-right">Add New Venue</a>
                    </div>
                    <div class="parent">
                        <div class="title">Search Fields</div>
                        <span class="">
                            &nbsp 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchType()" id="searchTypeInput" placeholder="Search for Venue Type.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchVenueNames()" id="searchVenueNamesInput" placeholder="Search for Venue Name.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchContactNames()" id="searchContactNamesInput" placeholder="Search for Contact Name.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchHostNames()" id="searchHostNamesInput" placeholder="Search for host Name.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="searchEmails()" id="searchEmailInput" placeholder="Search for Email.."> 
                        </span>
                        <span class="child">
                            <input type="text" onkeyup="prerecorded()" id="prerecorded" placeholder="Type Live or Recorded.."> 
                        </span>
                        <span class="child">
                            <input type="checkbox" onclick="searchHot()" id="searchHot" placeholder="Search for Hot.."> 
                            <label for="searchActive">Only Hot</label>
                        </span>
                        <span class="child">
                            <input type="checkbox" onclick="searchActive()" id="searchActive" placeholder="Search for Active.."> 
                            <label for="searchActive">Only Active</label>
                        </span>
                    </div>
                    <?php
                    require_once '../formatPhone.php';
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
                    $venues_sql = "SELECT * FROM venues ORDER BY venueName asc;";
                    $venues_result = mysqli_query($conn, $venues_sql);
                    while ($row =  mysqli_fetch_assoc($venues_result)) {
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
                        ($row['active'] == '1') ? $active = 'true' : $active = 'false'; 
                        ($row['hotCold'] == '1') ? $hotCold = 'true' : $hotCold = 'false';
                        ($row['bookingLiveRecorded'] == '1') ? $isbookingLiveRecorded = 'Pre-Recorded' : $isbookingLiveRecorded = 'Live';
                        echo "<div class='' data-type='".strtolower($venueType)."' data-venuename='".strtolower($row['venueName'])."' data-contactname='".strtolower($contactFullname)."' data-hostname='".strtolower($hostFullname)."' data-preRecorded='".strtolower($isbookingLiveRecorded)."' data-hotCold='".$hotCold."' data-active='".$active."'>";
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
                        echo "<th>Live/Pre-recorded</th>";
                        echo "<th>Audio Video</th>";
                        echo "<th>Hot/Cold</th>";
                        echo "<th>Active</th>";
                        // echo "<th>Created</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        echo "<tr>";
                        
                        (empty($row['venueDateTimeStart'])) ? $StartDate = 'unset' : $StartDate = convertDateTimeUTCtoLocal($row['venueDateTimeStart'], $timezone)[0];
                        (empty($row['venueDateTimeStart'])) ? $StartTime = 'unset' : $StartTime = convertDateTimeUTCtoLocal($row['venueDateTimeStart'], $timezone)[1];
                        (empty($row['venueDateTimeEnd'])) ? $EndDate = 'unset' : $EndDate = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'], $timezone)[0];
                        (empty($row['venueDateTimeEnd'])) ? $EndTime = 'unset' : $EndTime = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'], $timezone)[1];

                        $StartDateTime = "$StartDate $StartTime";
                        $EndDateTime = "$EndDate $EndTime";
                        $primaryPhoneId = $row['primaryPhoneId'];
                        $primaryEmailId = $row['primaryEmailId'];
                        $primaryAddressId = $row['primaryAddressId'];
                        $primaryServiceId = $row['primaryServiceId'];
                        $primaryNoteId = $row['primaryNoteId'];
                        ($row['active'] == '1') ? $isActive = 'Yes' : $isActive = 'No';
                        ($row['hotCold'] == '1') ? $ishotCold = 'Hot' : $ishotCold = 'Cold';
                        
                        ($row['bookingAudioOnly'] == '1') ? $isbookingAudioOnly = 'Audio Only' : $isbookingAudioOnly = 'Audio&Video';
                        echo "<td class='fitwidth'>" . "$row[id]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[venueName]" . "</td>";
                        echo "<td class='fitwidth'>" . $venueType . "</td>";
                        echo "<td class='fitwidth'>" . $contactFullname . "</td>";
                        echo "<td class='fitwidth'>" . $hostFullname . "</td>";
                        echo "<td class='fitwidth'>" . "$StartDateTime" . "</td>";
                        echo "<td class='fitwidth'>" . "$EndDateTime" . "</td>";
                        echo "<td class='fitwidth'>" . $timezone . "</td>";
                        echo "<td class='fitwidth'>" . "$row[showLength]" . " Mins</td>";
                        echo "<td class='fitwidth'>" . "$isbookingLiveRecorded" . "</td>";
                        echo "<td class='fitwidth'>" . "$isbookingAudioOnly" . "</td>";
                        echo "<td class='fitwidth'>" . "$ishotCold" . "</td>";
                        echo "<td class='fitwidth'>" . "$isActive" . "</td>";
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
                        echo "</div>";
                        echo "</tbody>";
                    } //end of contact loop
                    //end of the table from the contacts loop
                    echo "</table>";


                    ?>