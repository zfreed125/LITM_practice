<?php

// $venue_types_sql = "SELECT * FROM venue_types;";
// $venue_types_result = mysqli_query($conn, $venue_types_sql);
// $venue_type_array = array();
// while ($row = mysqli_fetch_assoc($venue_types_result)) {
//     $venue_type_array[] = array('id' => $row['id'], 'venueType' => $row['venueType']);
// }
echo "<table id='tbl_client". $bookingId ."' style='width:0px; display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
// echo "<caption><a href='../accounts/add.php?contactId=". $bookingId ."' title='Add Account' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Account</a></caption>";
// echo "<a href='#' title='Show/Hide accounts'style='position: relative; left: 50px;' onclick='myFunction(tbl_account". $bookingId .")'><span><i class='fas fa-chevron-down'></i>&nbspVenue Details&nbsp</span></a>";
echo "<tbody>";
$clients_sql = "SELECT * FROM contacts WHERE id='$clientNameId';";
$clients_result = mysqli_query($conn, $clients_sql);
while ($row =  mysqli_fetch_assoc($clients_result))

{
    // $venue_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
    foreach($venue_type_array as $item){
        if ($row['venueTypeId'] == $item['id']){
            $venueType = $item['venueType'];
        }
    }
    foreach($contacts_array as $item){
        if(($item['id']) == $row['contactNameId']){
            $contactNameId = $item['fullname'];
        }
    }
    foreach($contacts_array as $item){
        if(($item['id']) == $row['hostNameId']){
            $hostNameId = $item['fullname'];
        }
    }
    foreach($timezones_array as $item){
        if($item['id'] == $row['timezoneId']){
            $timezoneId = $item['timezone'];
        }
    }
    // (empty($row['venueDateTimeStart'])) ? $StartDate = 'unset': $StartDate = convertDateTimeUTCtoLocal($row['venueDateTimeStart'],$timezone)[0];
    // (empty($row['venueDateTimeStart'])) ? $StartTime = 'unset': $StartTime = convertDateTimeUTCtoLocal($row['venueDateTimeStart'],$timezone)[1];
    // (empty($row['venueDateTimeEnd'])) ? $EndDate = 'unset': $EndDate = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'],$timezone)[0];
    // (empty($row['venueDateTimeEnd'])) ? $EndTime = 'unset': $EndTime = convertDateTimeUTCtoLocal($row['venueDateTimeEnd'],$timezone)[1];
    // $StartDateTime = "$StartDate $StartTime";
    // $EndDateTime = "$EndDate $EndTime";
    
        echo "<tr>";
        echo "<tr><th class='fitwidth'>Name</th><td class='fitwidth'>".$row['firstname']." ".$row['lastname']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Job Title</th><td class='fitwidth'>".$row['jobTitle']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Birthdate</th><td class='fitwidth'>".$row['birthdate']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Booking Count</th><td class='fitwidth'>".$row['bookingCount']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Booking Auto</th><td class='fitwidth'>".$row['bookingAuto']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Booking Color</th><td class='fitwidth'>".$row['bookingColor']."</td></tr>" ;
        echo "<tr><th class='fitwidth'>Active</th><td class='fitwidth'>".$row['active']."</td></tr>" ;
        echo "</tr>" ;
    }
    echo "</tbody>";
    echo "</table>";
?>