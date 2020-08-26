<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
<style type="text/css">
.wrapper{
width: 100%;
margin: 0 auto;
}

.page-header h2{
margin-top: 0;
}

table tr td:last-child a{
margin-right: 15px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body>
    <div class="wrapper pull-left">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Booking List</h2>
                        <a href="add.php" class="btn btn-success pull-right">Add New Booking</a>
                    </div>
                    <?php
                    // Include config file
                    require_once '../config.php';
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
                    $contact_sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM contacts;";
                    $contact_result = mysqli_query($conn, $contact_sql);
                    $contacts_array = array();
                    while ($row = mysqli_fetch_assoc($contact_result)) {
                        $contacts_array[] = array('id' => $row['id'], 'fullname' => $row['fullname']);
                    }
                    $venue_name_sql = "SELECT id, venueName FROM venues;";
                    $result = mysqli_query($conn, $venue_name_sql);
                    $venue_name_array = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $venue_name_array[] = array('id' => $row['id'], 'venueName' => $row['venueName']);
                    }
                    $timezones_sql = "SELECT * FROM timezones;";
                    $timezones_result = mysqli_query($conn, $timezones_sql);
                    $timezones_array = array();
                    while ($row = mysqli_fetch_assoc($timezones_result)) {
                        $timezones_array[] = array('id' => $row['id'], 'timezone' => $row['timezone']);
                    }
                    //Attempt select query execution
                    $sql = "SELECT * FROM bookings;";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>bookingTypeId</th>";
                                        echo "<th>bookingDateTimeStart</th>";
                                        echo "<th>bookingDateTimeEnd</th>";
                                        echo "<th>timezoneId</th>";
                                        echo "<th>bookingLength</th>";
                                        echo "<th>clientNameId</th>";
                                        echo "<th>clientConfirm</th>";
                                        echo "<th>venueNameId</th>";
                                        echo "<th>venueConfirm</th>";
                                        echo "<th>bookingStatus</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                                foreach($booking_type_array as $item){
                                    if($item['id'] == $row['bookingTypeId']){
                                        $bookingType = $item['bookingType']; 
                                    }
                                }  
                                foreach($contacts_array as $item){
                                    if($item['id'] == $row['clientNameId']){
                                        $client = $item['fullname']; 
                                    }
                                }  
                                foreach($venue_name_array as $item){
                                    if($item['id'] == $row['venueNameId']){
                                        $venue = $item['venueName']; 
                                    }
                                }  
                                foreach($timezones_array as $item){
                                    if($item['id'] == $row['timezoneId']){
                                        $timezone = $item['timezone']; 
                                    }
                                }
                                
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $bookingType . "</td>";
                                        echo "<td>" . $row['bookingDateTimeStart'] . "</td>";
                                        echo "<td>" . $row['bookingDateTimeEnd'] . "</td>";
                                        echo "<td>" . $timezone . "</td>";
                                        echo "<td>" . $row['bookingLength'] . "</td>";
                                        echo "<td>" . $client . "</td>";
                                        echo "<td>" . $row['clientConfirm'] . "</td>";
                                        echo "<td>" . $venue . "</td>";
                                        echo "<td>" . $row['venueConfirm'] . "</td>";
                                        echo "<td>" . $row['bookingStatus'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                            }
                                echo "</tbody>";
                            echo "</table>";
                            //Free result set
                            mysqli_free_result($result);
                        }else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    }else{
                        echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
                    }
                    //Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>