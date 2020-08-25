<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET["id"];



$phone_types_sql = "SELECT * FROM phone_types;";
$result1 = mysqli_query($conn, $phone_types_sql);
$phone_type_array = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $phone_type_array[] = array('id' => $row['id'], 'phoneType' => $row['phoneType']);
}

//attempt insert query execution
$phones_sql = "select id, contactId, venueId, phoneTypeId, phone from phones where id='$id';";
$result2 = mysqli_query($conn, $phones_sql);
    //output data of each row
    while ($row = mysqli_fetch_assoc($result2)) {
        $contactId = $row["contactId"];
        $venueId = $row["venueId"];
        $phoneTypeId = $row["phoneTypeId"];
        $phone = $row["phone"];
    }
if(empty($venueId)){
    $primary_sql = "SELECT primaryPhoneId FROM contacts WHERE id='$contactId';";
}else{
    $primary_sql = "SELECT primaryPhoneId FROM venues WHERE id='$venueId';";
}
$primary_result = mysqli_query($conn, $primary_sql);
while ($row = mysqli_fetch_assoc($primary_result)) {
    $primaryPhoneId = $row['primaryPhoneId'];
   if($id == $primaryPhoneId) {
    //    echo "do nothing";
       $setPrimary = 1;
    }else{
        // echo "set primary";
        $setPrimary = 0;

   };
}



    $conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Phone</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
       <style type="text/css">
            .wrapper{
                    width: 500px;
                margin: 0 auto;
            }
        </style>
         <script>
                window.addEventListener('load', (event) => {

                    var x = document.getElementById("primary").value; 
                    if (<?php echo $setPrimary;?> == 1) {
                        document.getElementById("primary").checked = true;
                    }else{
                        // document.getElementById("primarydiv").style.display = "none";
                        document.getElementById("primary").checked = false;
                    }




                });
                    
            </script>
    </head> 
    <body>
        <div class="wrapper">
            <h2>Update Phone</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Phone</span></div>
                                        <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                                    </div>
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                    <select class="form-control" name="phoneTypeId">
                                        <option selected="selected">Choose one</option>
                                            <?php foreach($phone_type_array as $item){ ?>
                                        <option value="<?php echo strtolower($item['id']); ?>"
                                            <?php if($item['id'] == $phoneTypeId){ echo "selected"; } ?> >
                                        <?php echo $item['phoneType']; ?></option>
                                            <?php } ?>
                                    </select>
                                    </div>
                                    <div id="primarydiv" class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                                        <div class="input-group-prepend"><span class="input-group-text">Primary</span></div>
                                        <input class="form-control" type="checkbox" id="primary" name="primary">
                                    </div>
                                    <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                                    <input type="hidden" name="venueId" value="<?php echo $venueId; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="m-5">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </div>
                    </form>
        </div>
    </body>       
</html>    