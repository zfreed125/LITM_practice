<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
        <title>Contact</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td class='fitwidth'>" . "$row[firstname]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[lastname]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[birthdate]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[jobTitle]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[active]" . "</td>";
        echo "<td class='fitwidth'>";
        echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
        echo "<a href='../contacts/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
        echo "<a href='delete.php?contactId=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
        echo "</td>";
        $id = $row['id'];
        echo "</tr>";


        


            //phone sql loop table
            $phone_sql = "SELECT * FROM phones where contactId = '$id';";
            $phone_result = mysqli_query($conn, $phone_sql);

            echo "<table style= 'position: relative; left: 50px;' class='table table-bordered table-striped'>";
            echo "<caption><a href='../phones/add.php?id=". $row['id'] ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span></a>phone</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Phone</th>";
            echo "<th>Phone Type</th>";
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
            echo "<tr>";
            echo "<td class='fitwidth'>" . "$row[phone]" . "</td>";
            echo "<td class='fitwidth'>" . "$phoneTypeId" . "</td>";
            echo "<td class='fitwidth'>";
            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
            echo "<a href='../phones/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
            echo "<a href='../phones/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
            echo "</td>";
            echo "</tr>";
            }//end of phone loop
            //end of the table from the phone loop
            echo "</tbody>";
            echo "</table>";


                //email sql loop table
                $email_sql = "SELECT * FROM emails where contactId = '$id';";
                $email_result = mysqli_query($conn, $email_sql);

                echo "<table style= 'position: relative; left: 50px;' class='table table-bordered table-striped'>";
                echo "<caption><a href='../emails/add.php?id=". $id ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span></a>Email</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Email</th>";
                echo "<th>Email Type</th>";
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
                echo "<td class='fitwidth'>";
                echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                echo "<a href='../emails/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                echo "<a href='../emails/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
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
                        echo "<caption><a href='../address/create.html?id=". $id ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span></a>Address</caption>";
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
                        echo "<td class='fitwidth'>" . "$row[street1]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[street2]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[city]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[shortState]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[zip1]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[country]" . "</td>";
                        echo "<td class='fitwidth'>" . "$row[regDate]" . "</td>";
                        echo "<td class='fitwidth'>";
                        echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                        echo "<a href='../address/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                        echo "<a href='../address/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
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