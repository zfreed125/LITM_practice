<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
        <title>Contact</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="shortcut icon" href="../favicon.ico">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
       <link rel="stylesheet" href="./css/view.css">
        <script src="./js/view.js" type="text/javascript"></script>
</head>
    <body>
            <div class="wrapper pull-left">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header clearfix">
                                <h2 class="pull-left">Contact List</h2>
                            <a href="../contacts/add.php" class="btn btn-success pull-right">Add New Contact</a>
                    </div>
<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//contacts sql query loop table
$contact_sql = "SELECT * FROM contacts;";
$result = mysqli_query($conn, $contact_sql);

while ($row = mysqli_fetch_assoc($result))
{
echo "<table class='table table-bordered table-striped'>";
echo "<thead>";
echo "<tr>";
echo "<th>First Name</th>";
echo "<th>Last Name</th>";
echo "<th>Birthdate</th>";
echo "<th>Job Title</th>";
echo "<th>Active</th>";
// echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
echo "<tr>";
echo "<td class='fitwidth'>" . "$row[firstname]" . "</td>";
echo "<td class='fitwidth'>" . "$row[lastname]" . "</td>";
echo "<td class='fitwidth'>" . "$row[birthdate]" . "</td>";
echo "<td class='fitwidth'>" . "$row[jobTitle]" . "</td>";
echo "<td class='fitwidth'>" . "$row[active]" . "</td>";
// echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
echo "<td class='fitwidth'>";
echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
echo "<a href='delete.php?contactId=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
echo "</td>";
$primaryPhoneId = $row['primaryPhoneId'];
$primaryEmailId = $row['primaryEmailId'];
$primaryAddressId = $row['primaryAddressId'];
$primaryServiceId = $row['primaryServiceId'];
$contactId = $row['id'];
echo "</tr>";

        //account sql loop table
        require './includes/account_loop.php';

        //address sql query loop table
        require './includes/address_loop.php';

        //email sql loop table
        require './includes/email_loop.php';

        //genre sql loop table
        require './includes/genre_loop.php';

        //phone sql loop table
        require './includes/phone_loop.php';

        //note sql query loop table
        require './includes/note_loop.php';

        //Services sql query loop table
        require './includes/service_loop.php';

} //end of contact loop
//end of the table from the contacts loop
echo "</tbody>";
echo "</table>";


?>
