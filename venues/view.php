<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
        <title>Venue</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="shortcut icon" href="../favicon.ico">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../tz.js"></script>
        <style type="text/css">
            .wrapper{
                    width: 75%;
                /* margin: 0 auto; */
            }
            .page-header h2{
                    margin-top: 0;
            }
            table tr td:last-child a{
                    margin-right: 15px;
            }
            th,td{
                width: 1px;
                white-space: nowrap;
            }
            td.fitwidth {
                width: 1px;
                white-space: nowrap;
            }
            .details,
            .show,
            .hide:target {
            display: none;
            }
            .hide:target + .show,
            .hide:target ~ .details {
            display: block;
            }
        </style>
        <script type="text/javascript">

            function myFunction(id) {
                console.log(id);
                // var x = document.getElementById('tbl_phone1');
                if (id.style.display === "block") {
                    id.style.display = "none";
                } else {
                    id.style.display = "block";
                }
            }


            // $(document).ready(function(){
            //         $('[data-toggle="tooltip"]').tooltip();
            // });
        </script>
</head>
    <body>
            <div class="wrapper pull-left">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header clearfix">
                                <h2 class="pull-left">Venue List</h2>
                            <a href="add.php" class="btn btn-success pull-right">Add New Venue</a>
                    </div>
<?php

require_once '../config.php';
function convertDateTimeUTCtoLocal($venueDateTime,$tz){
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
            $venueTime = $local_date->format('H:i'); // output: 10:45 PM
            // $venueTime = $local_date->format('g:i A'); // output: 10:45 PM

            return array($venueDate,$venueTime);
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
$genre_types_sql = "SELECT * FROM genre_types;";
$genre_types_result = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($genre_types_result)) {
$genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
}
$email_types_sql = "SELECT * FROM email_types;";
$email_types_result = mysqli_query($conn, $email_types_sql);
$email_type_array = array();
while ($row = mysqli_fetch_assoc($email_types_result)) {
    $email_type_array[] = array('id' => $row['id'], 'emailType' => $row['emailType']);
}
$phone_types_sql = "SELECT * FROM phone_types;";
$phone_types_result = mysqli_query($conn, $phone_types_sql);
$phone_type_array = array();
while ($row = mysqli_fetch_assoc($phone_types_result)) {
    $phone_type_array[] = array('id' => $row['id'], 'phoneType' => $row['phoneType']);
}
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name'], 'timezone' => $row['timezone']);
}
$account_types_sql = "SELECT * FROM account_types;";
$account_types_result = mysqli_query($conn, $account_types_sql);
$account_type_array = array();
while ($row = mysqli_fetch_assoc($account_types_result)) {
    $account_type_array[] = array('id' => $row['id'], 'accountType' => $row['accountType']);
}

//contacts sql query loop table
$venues_sql = "SELECT * FROM venues;";
// $venues_sql = "SELECT venues.*, timezones.timezone as tz FROM venues join timezones on timezones.id = venues.timezoneId;";
$venues_result = mysqli_query($conn, $venues_sql);

while ($row =  mysqli_fetch_assoc($venues_result))
// while ($row = (object) mysqli_fetch_assoc($venues_result))
{
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Venue Name</th>";
    echo "<th>Venue Type</th>";
    echo "<th>Contact Name</th>";
    echo "<th>Host Name</th>";
    echo "<th>Start Date/Time</th>";
    echo "<th>End Date/Time</th>";
    echo "<th>Timezone</th>";
    echo "<th>Show Length</th>";
    echo "<th>Active</th>";
    echo "<th>Created</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";

    $venues_id = $row['id'];
        foreach($contacts_array as $item){
            if ($row['contactNameId'] == $item['id']){
                $contactFullname = $item['fullname'];
            }
            if ($row['hostNameId'] == $item['id']){
                $hostFullname = $item['fullname'];
            }
        }
        foreach($venue_type_array as $item){
            if ($row['venueTypeId'] == $item['id']){
                $venueType = $item['venueType'];
            }
        }
        foreach($timezones_array as $item){
            if ($row['timezoneId'] == $item['id']){
                $timezone = $item['name'];
                $tz = $item['timezone'];
            }
        }

        



        $StartDate = convertDateTimeUTCtoLocal($row['venueDateTimeStart'],$tz)[0];
        $StartTime = convertDateTimeUTCtoLocal($row['venueDateTimeStart'],$tz)[1];
        $EndDate = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'],$tz)[0];
        $EndTime = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'],$tz)[1];
        $StartDateTime = "$StartDate $StartTime";
        $EndDateTime = "$EndDate $EndTime";
        $primaryPhoneId = $row['primaryPhoneId'];

        echo "<td class='fitwidth'>" . "$row[venueName]" . "</td>";
        echo "<td class='fitwidth'>" . $venueType . "</td>";
        echo "<td class='fitwidth'>" . $contactFullname . "</td>";
        echo "<td class='fitwidth'>" . $hostFullname . "</td>";
        echo "<td class='fitwidth'>" . "$StartDateTime" . "</td>";
        echo "<td class='fitwidth'>" . "$EndDateTime" . "</td>";


        echo "<td class='fitwidth'>" . $timezone . "</td>";
        echo "<td class='fitwidth'>" . "$row[showLength]" . " Mins</td>";
        echo "<td class='fitwidth'>" . "$row[active]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
        echo "<td class='fitwidth'>";
        echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
        echo "<a href='delete.php?venueId=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
        echo "</td>";
        echo "</tr>";


                    //genre sql loop table
                    $genre_sql = "SELECT * FROM genres where venueId = '$row[id]';";
                    $genre_result = mysqli_query($conn, $genre_sql);
                    $genreRowCount = mysqli_num_rows($genre_result);

                    echo "<table id='tbl_genre". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                    echo "<caption><a href='../genres/add.php?venueId=". $venues_id ."' title='Add Genre' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>genre</a></caption>";
                    echo "<a href='#' title='Show/Hide Genres'style='position: relative; left: 50px;' onclick='myFunction(tbl_genre". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Genre Type (". $genreRowCount .")&nbsp</span></a>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Genre Type</th>";
                    echo "<th>Created</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = mysqli_fetch_assoc($genre_result))
                    {
                        foreach($genre_type_array as $item){
                            if($item['id'] == $row['genreTypeId']){
                                $genreTypeId = $item['genreType'];
                                }
                        }
                    echo "<tr>";
                    echo "<td class='fitwidth'>" . "$genreTypeId" . "</td>";
                    echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                    echo "<td class='fitwidth'>";
                    // echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                    echo "<a href='../genres/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                    echo "<a href='../genres/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                    echo "</td>";
                    echo "</tr>";
                    }//end of genre loop
                    //end of the table from the genre loop
                    echo "</tbody>";
                    echo "</table>";



                            //address sql query loop table
                            $address_sql = "SELECT * FROM addresses WHERE venueId = '$venues_id';";
                            $address_result = mysqli_query($conn, $address_sql);
                            $addressRowCount = mysqli_num_rows($address_result);

                            echo "<table id='tbl_address". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                            echo "<caption><a href='../address/add.php?src=venues&venueId=". $venues_id ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Address</span></a></caption>";
                            echo "<a href='#' title='Show/Hide Addresses'style='position: relative; left: 50px;' onclick='myFunction(tbl_address". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Addresses (". $addressRowCount .")&nbsp</span></a>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Street1</th>";
                            echo "<th>Street2</th>";
                            echo "<th>City</th>";
                            echo "<th>State</th>";
                            echo "<th>Zip1</th>";
                            echo "<th>Country</th>";
                            echo "<th>Created</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            while ($row = mysqli_fetch_assoc($address_result))
                            {
                                echo "<tr>";
                                echo "<td class='fitwidth'>" . "$row[street1]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[street2]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[city]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[shortState]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[zip1]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[country]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                echo "<td class='fitwidth'>";
                                echo "<a href='../address/edit.php?src=venues&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                echo "<a href='../address/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }//end of address loop
                            //end of the table from the address loop
                            echo "</tbody>";
                            echo "</table>";

                                //Services sql query loop table
                                $services_sql = "SELECT * FROM services WHERE venueId = '$venues_id';";
                                $services_result = mysqli_query($conn, $services_sql);
                                $servicesRowCount = mysqli_num_rows($services_result);

                                echo "<table id='tbl_services". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                echo "<caption><a href='../services/add.php?src=venues&venueId=". $venues_id ."' title='Add Messaging Services' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Services</span></a></caption>";
                                echo "<a href='#' title='Show/Hide Services'style='position: relative; left: 50px;' onclick='myFunction(tbl_services". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Services (". $servicesRowCount .")&nbsp</span></a>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Service Name</th>";
                                echo "<th>User Account</th>";
                                echo "<th>Website</th>";
                                echo "<th>Notes</th>";
                                echo "<th>Created</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while ($row = mysqli_fetch_assoc($services_result))
                                {
                                    echo "<tr>";
                                    echo "<td class='fitwidth'>" . "$row[serviceName]" . "</td>";
                                    echo "<td class='fitwidth'>" . "$row[userAccount]" . "</td>";
                                    echo "<td class='fitwidth'>" . "$row[website]" . "</td>";
                                    echo "<td class='fitwidth'>" . "$row[notes]" . "</td>";
                                    echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                    echo "<td class='fitwidth'>";
                                    echo "<a href='../services/edit.php?src=venues&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                    echo "<a href='../services/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                    }//end of Services loop
                                    //end of the table from the Services loop
                                    echo "</tbody>";
                                    echo "</table>";

                                        //note sql query loop table
                                        $note_sql = "SELECT * FROM notes WHERE venueId = '$venues_id';";
                                        $note_result = mysqli_query($conn, $note_sql);
                                        $noteRowCount = mysqli_num_rows($note_result);

                                        echo "<table id='tbl_note". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                        echo "<caption><a href='../notes/add.php?venueId=". $venues_id ."' title='Add note' data-toggle='tooltip'><span><i class='fas fa-plus'></i>note</span></a></caption>";
                                        echo "<a href='#' title='Show/Hide Notes'style='position: relative; left: 50px;' onclick='myFunction(tbl_note". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Notes (". $noteRowCount .")&nbsp</span></a>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Author</th>";
                                        echo "<th>Topic</th>";
                                        echo "<th>Notes</th>";
                                        echo "<th>Created</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($note_result))
                                        {
                                        echo "<tr>";
                                        echo "<td class='fitwidth'>" . "$row[author]" . "</td>";
                                        echo "<td class='fitwidth'>" . "$row[topic]" . "</td>";
                                        echo "<td class='fitwidth'>" . "$row[note]" . "</td>";
                                        echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                        echo "<td class='fitwidth'>";
                                        echo "<a href='../notes/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                        echo "<a href='../notes/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        }//end of note loop
                                        //end of the table from the note loop
                                        echo "</tbody>";
                                        echo "</table>";

                                            //email sql loop table
                                            $email_sql = "SELECT * FROM emails where venueId = '$venues_id';";
                                            $email_result = mysqli_query($conn, $email_sql);
                                            $emailRowCount = mysqli_num_rows($email_result);

                                            echo "<table id='tbl_email". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                            echo "<caption><a href='../emails/add.php?venueId=". $venues_id ."' title='Add Email' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Email</a></caption>";
                                            echo "<a href='#' title='Show/Hide Emails'style='position: relative; left: 50px;' onclick='myFunction(tbl_email". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Emails (". $emailRowCount .")&nbsp</span></a>";
                                            echo "<thead>";
                                            echo "<tr>";
                                            echo "<th>Email</th>";
                                            echo "<th>Email Type</th>";
                                            echo "<th>Created</th>";
                                            echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";

                                            while ($row = mysqli_fetch_assoc($email_result))
                                            {
                                                foreach($email_type_array as $item){
                                                    if($item['id'] == $row['emailTypeId']){
                                                        $emailTypeId = $item['emailType'];
                                                        }
                                                }
                                            echo "<tr>";
                                            echo "<td class='fitwidth'>" . "$row[email]" . "</td>";
                                            echo "<td class='fitwidth'>" . "$emailTypeId" . "</td>";
                                            echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                            echo "<td class='fitwidth'>";
                                            echo "<a href='../emails/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                            echo "<a href='../emails/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                            echo "</td>";
                                            echo "</tr>";
                                            }//end of email loop
                                            //end of the table from the email loop
                                            echo "</tbody>";
                                            echo "</table>";

                                                //phone sql loop table
                                                $phone_sql = "SELECT * FROM phones where venueId = '$venues_id';";
                                                $phone_result = mysqli_query($conn, $phone_sql);
                                                $phoneRowCount = mysqli_num_rows($phone_result);
                                                echo "<table id='tbl_phone". $venues_id ."' style='display: none; position: relative; left: 50px;' class='show table table-bordered table-striped'>";
                                                echo "<thead>";
                                                echo "<caption><a href='../phones/add.php?venueId=". $venues_id ."' title='Add Phone' data-toggle='tooltip'><span><i class='fas fa-plus'></i>phone</span></a></caption>";
                                                echo "<a href='#' title='Show/Hide Phones'style='position: relative; left: 50px;' onclick='myFunction(tbl_phone". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Phones (". $phoneRowCount .")&nbsp</span></a>";
                                                echo "<tr>";
                                                echo "<th></th>";
                                                echo "<th>Phone</th>";
                                                echo "<th>Phone Type</th>";
                                                echo "<th>Created</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";

                                                while ($row = mysqli_fetch_assoc($phone_result))
                                                {
                                                    foreach($phone_type_array as $item){
                                                        if($item['id'] == $row['phoneTypeId']){
                                                            $phoneTypeId = $item['phoneType'];
                                                            }
                                                    }
                                                    if($primaryPhoneId == $row['id']) { 
                                                        $primary = "<span><i style='color:green'class='fas fa-star'></i></span>"; 
                                                    }else{ 
                                                        $primary = "";
                                                    }
                                                echo "<tr>";
                                                echo "<td class='fitwidth'>" . $primary . "</td>";
                                                echo "<td class='fitwidth'>" . "$row[phone]" . "</td>";
                                                echo "<td class='fitwidth'>" . "$phoneTypeId" . "</td>";
                                                echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                                echo "<td class='fitwidth'>";
                                                echo "<a href='../phones/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                                echo "<a href='../phones/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                }//end of phone loop
                                                //end of the table from the phone loop
                                                echo "</tbody>";
                                                echo "</table>";

                                                    //account sql loop table
                                                    $account_sql = "SELECT * FROM accounts where venueId = '$venues_id';";
                                                    $account_result = mysqli_query($conn, $account_sql);
                                                    $accountRowCount = mysqli_num_rows($account_result);

                                                    echo "<table id='tbl_account". $venues_id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                                    echo "<caption><a href='../accounts/add.php?venueId=". $venues_id ."' title='Add Account' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Account</a></caption>";
                                                    echo "<a href='#' title='Show/Hide accounts'style='position: relative; left: 50px;' onclick='myFunction(tbl_account". $venues_id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Account Type (". $accountRowCount .")&nbsp</span></a>";
                                                    echo "<thead>";
                                                    echo "<tr>";
                                                    echo "<th>Account Type</th>";
                                                    echo "<th>Created</th>";
                                                    echo "</tr>";
                                                    echo "</thead>";
                                                    echo "<tbody>";

                                                    while ($row = mysqli_fetch_assoc($account_result))
                                                    {
                                                        foreach($account_type_array as $item){
                                                            if($item['id'] == $row['accountTypeId']){
                                                                $accountTypeId = $item['accountType']; 
                                                            }
                                                        }
                                                    echo "<tr>";
                                                    echo "<td class='fitwidth'>" . "$accountTypeId" . "</td>";
                                                    echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                                    echo "<td class='fitwidth'>";
                                                    echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                                                    echo "<a href='../accounts/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                                    echo "<a href='../accounts/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    }//end of account loop
                                                    //end of the table from the account loop
                                                    echo "</tbody>";
                                                    echo "</table>";

        } //end of contact loop
        //end of the table from the contacts loop
        echo "</tbody>";
        echo "</table>";


?>
