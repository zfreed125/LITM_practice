<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET["id"];
// Attempt insert query execution
$sql = " select contacts.*, address.*, address.id as address_id from contacts, address where contacts.id = '$id' and address.contactId = '$id';
";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $addressid = $row["address_id"];
        $addressContactId = $row["contactId"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $active = $row["active"];
        $street1 = $row["street1"];
        $street2 = $row["street2"];
        $city = $row["city"];
        $shortState = $row["shortState"];
        $zip1 = $row["zip1"];
        $zip2 = $row["zip2"];
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
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script src="../helpers.js"></script>
            <style type="text/css">
                .wrapper{
                        width: 500px;
                    margin: 0 auto;
                }
            </style>
            <script>
                window.addEventListener('load', (event) => {
                    // var t = "1, 2, 3, 4, 5";
                    // console.log(`"${t}"`);
                    var x = document.getElementById("active").value; 
                    if (x == 1) {
                        document.getElementById("active").checked = true;
                    }else{
                        document.getElementById("active").checked = false;
                    }
                    $(function() {
                    var output = [];
                    var shortState = '<?php echo $shortState; ?>';
                    $.each(state , function(i, state){
                    let j = "";
                    if (state.abrev === shortState){
                        j = 'selected';
                    }  
                    output.push(`<option value="${state.abrev}"${j}>${state.state}</option>`);
                    // output.push('<option value="'+ state.abrev +'"'+ j +'>'+ state.state +'</option>');
                    });
                    $('#shortState').html(output.join(''));
                }); 
                });
            </script>
    </head>
        <body>
                <div class="wrapper">
                        <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form name="drop_list" action="update.php" method="post">
                               
                            <div class="form-group">
                                <label>active</label>
                                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
                            </div>
                            <div class="form-group">
                                <label>addressContactId</label>
                                <input type="text" name="addressContactId" class="form-control" value="<?php echo $addressContactId; ?>">
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>firstname</label>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                                </div>
                                <div class="form-group">
                                    <label>lastname</label>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>street1</label>
                                    <input type="text" name="street1" class="form-control" value="<?php echo $street1; ?>">
                                </div>
                                <div class="form-group">
                                    <label>street2</label>
                                    <input type="text" name="street2" class="form-control" value="<?php echo $street2; ?>">
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>city</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <select name="shortState" id="shortState" value="<?php echo $shortState; ?>"> </select>
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>zip1</label>
                                    <input type="text" name="zip1" class="form-control" value="<?php echo $zip1; ?>">
                                </div>
                                <div class="form-group">
                                    <label>zip2</label>
                                    <input type="text" name="zip2" class="form-control" value="<?php echo $zip2; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>country</label>
                                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            </div>
                                <input type="hidden" name="addressid" value="<?php echo $addressid; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <a class="btn btn-danger" href="delete.php?id=<?php echo "$id&addressid=$addressid";?>">Delete</a>
                            </form>
                </div>
    </body>
        </html>