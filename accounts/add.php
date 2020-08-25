<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$account_types_sql = "SELECT * FROM account_types;";
$result = mysqli_query($conn, $account_types_sql);
$account_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $account_type_array[] = array('id' => $row['id'], 'accountType' => $row['accountType']);
}
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Account Register</title>
</head>

<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>

<body>
    <div class="wrapper">
        <h1>Add an Account</h1>
        <form action="create.php" method="POST">
            <div class="input-group">
            <div class="input-group-prepend"><select name="accountTypeId"></div>
                    <option selected="selected">Choose one</option>
                        <?php foreach($account_type_array as $item){ ?>
                    <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['accountType']; ?></option>
                        <?php } ?>
                </select>
            </div>
            <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
            <input hidden id="venueId" style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId; ?>">
            <br>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        </form>
    </div>
    
</body>
</html>

