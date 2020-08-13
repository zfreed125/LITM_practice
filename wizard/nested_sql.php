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
                            <a href="contact_wiz.html" class="btn btn-success pull-right">Add New Contact</a>
                    </div>





<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$email_types_sql = "SELECT * FROM email_types;";
$email_types_result = mysqli_query($conn, $email_types_sql);
$data_array = array();
while ($row = mysqli_fetch_assoc($email_types_result)) {
    $data_array[] = array('id' => $row['id'], 'emailType' => $row['emailType']);
}

        //contacts sql query loop table
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

                //email sql loop table
                $email_sql = "SELECT * FROM emails where contactId = '$id';";
                $email_result = mysqli_query($conn, $email_sql);

                echo "<table style= 'position: relative; left: 50px;' class='table table-bordered table-striped'>";
                echo "<caption><a href='../emails/add.php?id=". $row['id'] ."' title='Add Address' data-toggle='tooltip'><span class='glyphicon glyphicon-plus-sign'></span></a>Email</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Email</th>";
                echo "<th>Email Type</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while ($row = mysqli_fetch_assoc($email_result))
                {
                    foreach($data_array as $item){
                        if($item['id'] == $row['emailTypeId']){
                            $emailType = $item['emailType']; 
                            }
                    }
                echo "<tr>";
                echo "<td>" . "$row[email]" . "</td>";
                echo "<td>" . "$emailType" . "</td>";
                echo "<td>";
                echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                echo "<a href='../emails/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                echo "<a href='../emails/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                echo "</td>";
                echo "</tr>";
                }//end of email loop
                //end of the table from the email loop
                echo "</tbody>";
                echo "</table>";
        
        
                                            //address sql query loop table
                                            $address_sql = "SELECT * FROM addresses WHERE contactId = '$id';";
                                            $address_result = mysqli_query($conn, $address_sql);

                                            echo "<table style= 'position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                            echo "<caption><a href='../address/create.html?id=". $row['id'] ."' title='Add Address' data-toggle='tooltip'><span class='glyphicon glyphicon-plus-sign'></span></a>Address</caption>";
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

                                            while ($row = mysqli_fetch_assoc($address_result))
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
                                            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='../address/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='../address/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "</td>";
                                            echo "</tr>";
                                            }//end of address loop
                                            //end of the table from the address loop
                                            echo "</tbody>";
                                            echo "</table>";

        } //end of contact loop
        //end of the table from the contacts loop
        echo "</tbody>";
        echo "</table>";


?>