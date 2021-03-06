<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LITM Main Dashboard</title>
    <style>
        .center {
            text-align: center;
        }

        body {
            font-family: "Lato", sans-serif;
        }

        .sidenav {
            height: 100%;
            width: 160px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .main {
            margin-left: 160px;
            /* Same as the width of the sidenav */
            font-size: 28px;
            /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }

        .hide {
            /* visibility: hidden; */
            /* background-color: cyan; */
            display: none;
        }

        .show {
            display: block;
        }
    </style>
    <script type="text/javascript">
        function toggle_visibility(id) {
            var e = document.getElementById(id);
            if (e.style.display == "block") e.style.display = "none";
            else e.style.display = "block";
        }
        window.addEventListener("load", function () {
            console.log("All assets are loaded");
        });
    </script>
</head>

<body>
    <h1 style="margin-left: 160px;" class="center">Welcome To The LITM MasterBase</h1>
    <!-- <img class="center" src="butterfly.jpg"> -->

    <div class="sidenav">
        <a href="#types" onclick="toggle_visibility('types');">Types</a>
        <a href="contacts/view.php">Contacts</a>
        <a href="venues/view.php">Venues</a>
        <a href="bookings/view.php">Bookings</a>
        <a href="calendar/">Calendar</a>
        <!-- <a href="todo/">Todo</a> -->
        <a href="#tables" onclick="toggle_visibility('tables');">Tables</a>
    </div>

    <div id="types" class="main hide">
        <h2>View Types</h2>
        <a href="account_types/view.php">Account_Types</a><br />
        <a href="booking_types/view.php">Booking_Types</a><br />
        <a href="email_types/view.php">Email_Types</a><br />
        <a href="genre_types/view.php">Genre_Types</a><br />
        <a href="phone_types/view.php">Phone_Types</a><br />
        <a href="venue_types/view.php">Venue_Types</a><br />
    </div>
    <div id="tables" class="main hide">
        <h2>Tables to Create</h2>
        <a href="table/accounts.php">Accounts</a><br />
        <a href="table/account_types.php">Account_Types</a><br />
        <a href="table/addresses.php">Addresses</a><br />
        <a href="table/bookings.php">Bookings</a><br />
        <a href="table/booking_types.php">Booking Types</a><br />
        <a href="table/contacts.php">Contacts</a><br />
        <a href="table/emails.php">Emails</a><br />
        <a href="table/email_types.php">Email_Types</a><br />
        <a href="table/genres.php">Genres</a><br />
        <a href="table/genre_types.php">Genre_Types</a><br />
        <a href="table/services.php">Services</a><br />
        <a href="table/notes.php">Notes</a><br />
        <a href="table/phones.php">Phones</a><br />
        <a href="table/phone_types.php">Phone_Types</a><br />
        <a href="table/venues.php">Venues</a><br />
        <a href="table/venue_types.php">Venue_Types</a><br />
    </div>

<?php
require "./todo/index.php";
?>


</body>

</html>