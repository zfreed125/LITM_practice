<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];


$phone_sql = "SELECT * FROM phone_types;";
$phone_result = mysqli_query($conn, $phone_sql);
$phone_type_array = array();
while ($row = mysqli_fetch_assoc($phone_result)) {
    $phone_type_array[] = array('id' => $row['id'], 'phoneType' => $row['phoneType']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Phone Register</title>
</head>
<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>
 <script>
                window.addEventListener('load', (event) => {

                });
                    
            </script>
<body>
<form class="center" action="create.php" method="POST">
    <div class="wrapper">
        <h1 class="center">Add a Phone</h1>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Phone Number</span></div>
                <input type="text" name="phone">
                <div class="input-group-prepend"><select name="phoneTypeId">
                        <option selected="selected">Choose one</option>
                            <?php foreach($phone_type_array as $item){ ?>
                        <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['phoneType']; ?></option>
                            <?php } ?>
                    </select>
            </div>
            <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
            <input hidden id="venueId" style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId; ?>">
            <br>
            <button class="btn btn-primary" type="submit" name="submit">Submit</button>


    </div>
</form>
</body>
</html>