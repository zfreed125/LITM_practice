<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$phone_types_sql = "SELECT * FROM phone_types;";
$result1 = mysqli_query($conn, $phone_types_sql);
$phone_type_array = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $phone_type_array[] = array('id' => $row['id'], 'phoneType' => $row['phoneType']);
}

$id = $_GET["id"];
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
                                    <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                                    <input type="hidden" name="venueId" value="<?php echo $venueId; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="m-5">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <!-- </div> -->
                            <!-- <div class="mt-3 mb-1"> -->
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </div>
                    </form>
        </div>
    </body>       
</html>    