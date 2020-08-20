<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
        <title>Contact</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="shortcut icon" href="../favicon.ico">
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
$account_types_sql = "SELECT * FROM account_types;";
$account_types_result = mysqli_query($conn, $account_types_sql);
$account_type_array = array();
while ($row = mysqli_fetch_assoc($account_types_result)) {
    $account_type_array[] = array('id' => $row['id'], 'accountType' => $row['accountType']);
}
$genre_types_sql = "SELECT * FROM genre_types;";
$genre_types_result = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($genre_types_result)) {
    $genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
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
        echo "<th>Created</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td class='fitwidth'>" . "$row[firstname]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[lastname]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[birthdate]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[jobTitle]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[active]" . "</td>";
        echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
        echo "<td class='fitwidth'>";
        echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
        echo "<a href='edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
        echo "<a href='delete.php?contactId=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
        echo "</td>";
        $id = $row['id'];
        echo "</tr>";

            //phone sql loop table
            $phone_sql = "SELECT * FROM phones where contactId = '$id';";
            $phone_result = mysqli_query($conn, $phone_sql);
            $phoneRowCount = mysqli_num_rows($phone_result);
            echo "<table id='tbl_phone". $id ."' style='display: none; position: relative; left: 50px;' class='show table table-bordered table-striped'>";
            echo "<thead>";
            echo "<caption><a href='../phones/add.php?id=". $row['id'] ."' title='Add Phone' data-toggle='tooltip'><span><i class='fas fa-plus'></i>phone</span></a></caption>";
            echo "<a href='#' title='Show/Hide Phones'style='position: relative; left: 50px;' onclick='myFunction(tbl_phone". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Phones (". $phoneRowCount .")&nbsp</span></a>";
            echo "<tr>";
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
            echo "<tr>";
            echo "<td class='fitwidth'>" . "$row[phone]" . "</td>";
            echo "<td class='fitwidth'>" . "$phoneTypeId" . "</td>";
            echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
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
        
        //account sql loop table
        $account_sql = "SELECT * FROM accounts where contactId = '$id';";
        $account_result = mysqli_query($conn, $account_sql);
        $accountRowCount = mysqli_num_rows($account_result);
        
        echo "<table id='tbl_account". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
        echo "<caption><a href='../accounts/add.php?id=". $id ."' title='Add Account' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Account</a></caption>";
        echo "<a href='#' title='Show/Hide accounts'style='position: relative; left: 50px;' onclick='myFunction(tbl_account". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Account Type (". $accountRowCount .")&nbsp</span></a>";
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
                echo "<a href='../accounts/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                echo "</td>";
                echo "</tr>";
                }//end of account loop
                //end of the table from the account loop
                echo "</tbody>";
                echo "</table>";

                    //genre sql loop table
                    $genre_sql = "SELECT * FROM genres where contactId = '$id';";
                    $genre_result = mysqli_query($conn, $genre_sql);
                    $genreRowCount = mysqli_num_rows($genre_result);

                    echo "<table id='tbl_genre". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                    echo "<caption><a href='../genres/add.php?src=contacts&contactId=". $id ."' title='Add Genre' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>genre</a></caption>";
                    echo "<a href='#' title='Show/Hide Genres'style='position: relative; left: 50px;' onclick='myFunction(tbl_genre". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Genre Type (". $genreRowCount .")&nbsp</span></a>";
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
                    echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                    echo "<a href='../genres/edit.php?src=contacts&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                    echo "<a href='../genres/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                    echo "</td>";
                    echo "</tr>";
                    }//end of genre loop
                    //end of the table from the genre loop
                    echo "</tbody>";
                    echo "</table>";
        
                        //email sql loop table
                        $email_sql = "SELECT * FROM emails where contactId = '$id';";
                        $email_result = mysqli_query($conn, $email_sql);
                        $emailRowCount = mysqli_num_rows($email_result);

                        echo "<table id='tbl_email". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                        echo "<caption><a href='../emails/add.php?id=". $id ."' title='Add Email' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Email</a></caption>";
                        echo "<a href='#' title='Show/Hide Emails'style='position: relative; left: 50px;' onclick='myFunction(tbl_email". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Emails (". $emailRowCount .")&nbsp</span></a>";
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
                            $addressRowCount = mysqli_num_rows($address_result);

                            echo "<table id='tbl_address". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                            echo "<caption><a href='../address/add.php?src=contacts&contactId=". $id ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Address</span></a></caption>";
                            echo "<a href='#' title='Show/Hide Addresses'style='position: relative; left: 50px;' onclick='myFunction(tbl_address". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Addresses (". $addressRowCount .")&nbsp</span></a>";
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
                            echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                            echo "<a href='../address/edit.php?src=contacts&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                            echo "<a href='../address/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                            echo "</td>";
                            echo "</tr>";
                            }//end of address loop
                            //end of the table from the address loop
                            echo "</tbody>";
                            echo "</table>";

                                //Info sql query loop table
                                $messaging_services_sql = "SELECT * FROM messaging_services WHERE contactId = '$id';";
                                $messaging_services_result = mysqli_query($conn, $messaging_services_sql);
                                $messaging_servicesRowCount = mysqli_num_rows($messaging_services_result);

                                echo "<table id='tbl_messaging_services". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                echo "<caption><a href='../messaging_services/add.php?src=contacts&contactId=". $id ."' title='Add Messaging Services' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Messaging Services</span></a></caption>";
                                echo "<a href='#' title='Show/Hide Messaging Services'style='position: relative; left: 50px;' onclick='myFunction(tbl_messaging_services". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Messaging Services (". $messaging_servicesRowCount .")&nbsp</span></a>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Service Name</th>";
                                echo "<th>User Account</th>";
                                echo "<th>Notes</th>";
                                echo "<th>Created</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while ($row = mysqli_fetch_assoc($messaging_services_result))
                                {
                                echo "<tr>";
                                echo "<td class='fitwidth'>" . "$row[serviceName]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[userAccount]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[notes]" . "</td>";
                                echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
                                echo "<td class='fitwidth'>";
                                echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                                echo "<a href='../messaging_services/edit.php?src=contacts&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                echo "<a href='../messaging_services/delete.php?src=contacts&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                echo "</td>";
                                echo "</tr>";
                                }//end of Info loop
                                //end of the table from the Info loop
                                echo "</tbody>";
                                echo "</table>";

                                    //note sql query loop table
                                    $note_sql = "SELECT * FROM notes WHERE contactId = '$id';";
                                    $note_result = mysqli_query($conn, $note_sql);
                                    $noteRowCount = mysqli_num_rows($note_result);

                                    echo "<table id='tbl_note". $id ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
                                    echo "<caption><a href='../notes/add.php?id=". $id ."' title='Add note' data-toggle='tooltip'><span><i class='fas fa-plus'></i>note</span></a></caption>";
                                    echo "<a href='#' title='Show/Hide Notes'style='position: relative; left: 50px;' onclick='myFunction(tbl_note". $id .")'><span><i class='fas fa-chevron-down'></i>&nbspShow Notes (". $noteRowCount .")&nbsp</span></a>";
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
                                    echo "<a href='view.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span><i class='fas fa-eye'></i></span></a>";
                                    echo "<a href='../notes/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
                                    echo "<a href='../notes/delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                    }//end of note loop
                                    //end of the table from the note loop
                                    echo "</tbody>";
                                    echo "</table>";

        } //end of contact loop
        //end of the table from the contacts loop
        echo "</tbody>";
        echo "</table>";


?>