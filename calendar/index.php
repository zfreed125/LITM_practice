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
<style media="screen">
  #calendar-body  td{
    height: 100px;
    width: 175px;
  }
</style>
</head>
<body>
<div style="width:max-content" class="container col-sm-4 col-md-7 col-lg-4 mt-1 ml-1">
    <div style="width:max-content" class="card">
        <h3 style="text-align: center;" class="card-header" id="monthAndYear"></h3>
        <div class="form-inline">
            <button class="btn btn-outline-primary col-sm-6" id="previous" onclick="previous()">Previous</button>
            <button class="btn btn-outline-primary col-sm-6" id="next" onclick="next()">Next</button>
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
<script src="./js/scripts.js"></script>
<script>
const booking_array = <?php echo json_encode($bookings_array);?>;
window.addEventListener('load', (event) => {
    for (let i = 0; i < booking_array.length; i++) {
        startDate = booking_array[i]['StartDate'];
        clientFullName = booking_array[i]['clientFullName'];
        color = (booking_array[i]['bookingColor'] === null) ? 'rgb(0, 0, 0)' : booking_array[i]['bookingColor'];
        title = JSON.stringify(booking_array[i]);
        createBooking(startDate,clientFullName,color,title);
    }
}); //window load

</script>

</body>
</html>
