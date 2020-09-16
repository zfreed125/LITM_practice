<?php
require 'data.php';
// echo json_encode($bookings_array, JSON_FORCE_OBJECT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- LITM -->
    <script>window.booking_array = <?php echo json_encode($bookings_array);?>;</script>
    <script>window.client_booking_count_array = <?php echo json_encode($client_booking_count_array);?>;</script>
    <script type="module" src="./js/scripts.js" defer></script>
<style media="screen">
#calendar-body  td{
height: 100px;
width: 175px;
}
#sideDetails {
position: absolute;
top: 60px;

height: 602px;
width: 400px;
left: 1230px;
border: 1px solid #DEE2E6;
border-radius: 10px;
background-color: #F7F7F7;
}
.booking-details span {
margin-top: 5px;  
margin-left: 10px;  
font-weight: bold;
/* font-style: italic; */
text-transform: capitalize;

}
.booking-details div{
    /* padding: 5px; */
    align-text: right;
}
</style>
</head>
<body>
<div style="width:max-content" class="container col-sm-4 col-md-7 col-lg-4 mt-1 ml-1">
    <div style="width:max-content" class="card">
        <h3 style="text-align: center;" class="card-header" id="monthAndYear"></h3>
        <div class="form-inline">
            <button class="btn btn-outline-primary col-sm-6" id="previous">Previous</button>
            <button class="btn btn-outline-primary col-sm-6" id="next">Next</button>
        </div>

        <table class="table table-bordered table-responsive-sm" id="calendar">
            <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
            </thead>

            <tbody id="calendar-body">

            </tbody>
        </table>
        <br/>
        <div id="sideDetails"></div>
        <form hidden class="form-inline">
            <label class="lead mr-2 ml-2" for="month">Jump To: </label>
            <select class="form-control col-sm-4" name="month" id="month" onchange="jump()">
                <option value=0>January</option>
                <option value=1>February</option>
                <option value=2>March</option>
                <option value=3>April</option>
                <option value=4>May</option>
                <option value=5>June</option>
                <option value=6>July</option>
                <option value=7>August</option>
                <option value=8>September</option>
                <option value=9>October</option>
                <option value=10>November</option>
                <option value=11>December</option>
            </select>


            <label for="year"></label><select class="form-control col-sm-4" name="year" id="year" onchange="jump()">
            <option value=2020>2020</option>
            <option value=2021>2021</option>
            <option value=2022>2022</option>
            <option value=2023>2023</option>
            <option value=2024>2024</option>
            <option value=2025>2025</option>
            <option value=2026>2026</option>
            <option value=2027>2027</option>
            <option value=2028>2028</option>
            <option value=2029>2029</option>
            <option value=2030>2030</option>
        </select></form>
    </div>
</div>
<!-- <button name="jump" onclick="jump()">Go</button> -->
<!-- <script src="./js/scripts.js"></script> -->

</body>
</html>
