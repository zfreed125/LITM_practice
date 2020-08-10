<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
        <title>Contact</title>
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
            th,td{

            }
        </style>
        <!-- <script type="text/javascript">
            $(document).ready(function(){
                    $('[data-toggle="tooltip"]').tooltip();
            });
        </script> -->
</head>
    <body>
            <div class="wrapper pull-left">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header clearfix">
                                <h2 class="pull-left">Contact List</h2>
                            <!-- <a href="contact_wiz.html" class="btn btn-success pull-right">Add New Contact</a> -->
                    </div>





<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM contacts;";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result))
{
    echo "<table class='table table-bordered table-striped'>";
        echo "<thead>";
         echo "<tr>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Birthdate</th>";
    echo "<th>Active</th>";
         echo "</tr>";
        echo "</thead>";
    echo "<tbody>";

    echo "<tr>";
        echo "<td>" . "$row[firstname]" . "</td>";
        echo "<td>" . "$row[lastname]" . "</td>";
        echo "<td>" . "$row[birthdate]" . "</td>";
        echo "<td>" . "$row[active]" . "</td>";
            $id = $row['id'];
    echo "</tr>";


            $sql2 = "SELECT * FROM addresses WHERE contactId = '$id';";
            $result2 = mysqli_query($conn, $sql2);

            echo "<table style= 'position: relative; left: 50px;' class='table table-bordered table-striped'>";
                echo "<thead>";
                 echo "<tr>";
            echo "<th>Street1</th>";
            echo "<th>Street2</th>";
            echo "<th>City</th>";
            echo "<th>State</th>";
            echo "<th>Zip1</th>";
            echo "<th>Country</th>";
            echo "<th>Reg date</th>";
                 echo "</tr>";
                echo "</thead>";
            echo "<tbody>";
        
            while ($row = mysqli_fetch_assoc($result2))
            {
                echo "<tr>";
                echo "<td>" . "$row[street1]" . "</td>";
                echo "<td>" . "$row[street2]" . "</td>";
                echo "<td>" . "$row[city]" . "</td>";
                echo "<td>" . "$row[shortState]" . "</td>";
                echo "<td>" . "$row[zip1]" . "</td>";
                echo "<td>" . "$row[country]" . "</td>";
                echo "<td>" . "$row[regDate]" . "</td>";
                echo "<td>";
                echo "<a href='view.php?id=". $row['contact_id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                echo "<a href='edit.php?id=". $row['contact_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                echo "<a href='delete.php?id=". $row['contact_id'] ."&addressid=". $row['address_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                echo "</td>";
                echo "</tr>";
            }//end of address loop
            echo "</tbody>";
            echo "</table>";
} //end of contact loop
            echo "</tbody>";
            echo "</table>";
// }


?>