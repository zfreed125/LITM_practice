<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




$id = $_GET["id"];
$src = $_GET["src"];
// $id = 1;
// $firstname = mysqli_real_escape_string($conn, $_REQUEST['firstname']);
// $lastname = mysqli_real_escape_string($conn, $_REQUEST['lastname']);
// $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
// $activity = mysqli_real_escape_string($conn, $_REQUEST['activity']);
// $client_type = mysqli_real_escape_string($conn, $_REQUEST['client_type']);
 
// Attempt insert query execution
// $sql = "select id, first_name, last_name, email from Test1 where id='$id';";
$sql = "select id, contactId, venueId, street1, street2, city, shortState, zip1, country from addresses where id='$id';";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $contactId = $row["contactId"];
        $venueId = $row["venueId"];
        $street1 = $row["street1"];
        $street2 = $row["street2"];
        $city = $row["city"];
        $shortState = $row["shortState"];
        $zip1 = $row["zip1"];
        $country = $row["country"];
    }

 
    $conn->close();
?>
<!-- // HTML Form -->
<!DOCTYPE html>

<html lang="en">
            <head>
                <meta charset="UTF-8">
            <title>Update Record</title>
            <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script src="../helpers.js"></script>
        <style type="text/css">
                .wrapper{
                        width: 500px;
                    margin: 0 auto;
                }

                
                                            /* The flip card container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
            .flip-card {
            background-color: transparent;
            width: 300px;
            height: 300px;
            border: 1px solid #f1f1f1;
            perspective: 1000px; /* Remove this if you don't want the 3D effect */
            }

            /* This container is needed to position the front and back side */
            .flip-card-inner input{
                    /* width: 100%;
                    height: 100%; */
            }
            .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
            }

            /* Do an horizontal flip when you move the mouse over the flip box container */
            .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
            }

            /* Position the front and back side */
            .flip-card-front, .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden; /* Safari */
            backface-visibility: hidden;
            }

            /* Style the front side (fallback if image is missing) */
            .flip-card-front {
            background-color: #bbb;
            color: black;
            }

            /* Style the back side */
            .flip-card-back {
            background-color: dodgerblue;
            color: white;
            transform: rotateY(180deg);
            } 
    
        </style>

<script>
            function updateShortState(e) {
                document.getElementById("shortState").value = e.target.value;
            }
         
        window.addEventListener('load', (event) => {
            document.getElementById("shortState").value = '<?php echo $shortState;?>';


            $(function () {
                var output = [];
                var shortStateSelect = '<?php echo $shortState;?>';
                $.each(state, function (i, state) {
                    let j = "";
                    if (state.abrev === shortStateSelect) {
                        j = 'selected';
                    }
                    output.push(`<option value="${state.abrev}"${j}>${state.state}</option>`);
                });
                $('#shortStateSelect').html(output.join(''));
            });
        });
    </script>
    </head>
        <body>
                <div class="wrapper">
                        <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form action="update.php" method="post">
                              

                             <!-- Flip Card needs to be collaspable -->
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <img src="avatar_image.jpg" alt="Avatar" style="width:298px;height:298px;">
                            </div>
                            <div class="flip-card-back">
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">    
                                        <div class="input-group-prepend"><span class="input-group-text">Street1</span></div>
                                        <input type="text" name="street1" class="form-control" value="<?php echo $street1; ?>">
                                    </div>  
                                    <div class="input-group mb-1 input-group-sm p-1 w-75">    
                                        <div class="input-group-prepend"><span class="input-group-text">Street2</span></div>
                                        <input type="text" name="street2" class="form-control" value="<?php echo $street2; ?>">
                                    </div>  
                                    <div class="input-group mb-1 input-group-sm p-1 w-50">    
                                        <div class="input-group-prepend"><span class="input-group-text">City</span></div>
                                        <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                    </div>  
                                    <div class="input-group mb-1 input-group-sm p-1 w-75">    
                                        <div class="input-group-prepend"><span class="input-group-text">State</span></div>
                                        <p><input autocomplete="off" name="shortState" id="shortState" style="display: none;"> </input></p>
                                        <select name="shortStateSelect" id="shortStateSelect" onchange="updateShortState(event)"></select>
                                    </div>  
                                    <div class="input-group mb-1 input-group-sm p-1 w-50">    
                                        <div class="input-group-prepend"><span class="input-group-text">Zip</span></div>
                                        <input type="text" name="zip1" class="form-control" value="<?php echo $zip1; ?>">
                                    </div>  
                                        <div class="input-group mb-1 input-group-sm p-1 w-50">    
                                            <div class="input-group-prepend"><span class="input-group-text">Country</span></div>
                                            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                                        </div>
                                    <input type="hidden" name="venueId" value="<?php echo $venueId; ?>">
                                    <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                                    <input type="hidden" name="src" value="<?php echo $src; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                            </div>
                        </div>
                    </div>  <!-- Flip End -->
                    <p>Hover over Image to edit Address fields.</p>
                                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <!-- <input type="submit" class="btn btn-danger" value="Delete"> -->
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </form>
                </div>
    </body>
        </html>