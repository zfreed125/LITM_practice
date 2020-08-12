<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM email_types;";
$result = mysqli_query($conn, $sql);
$data_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data_array[] = array('id' => $row['id'], 'emailType' => $row['emailType']);
}
$contactId = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Register</title>
</head>

<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>

<body>

    <h1 class="center">Add an Email</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="email" placeholder="Email">
        <select name="emailTypeId">
            <option selected="selected">Choose one</option>
                <?php foreach($data_array as $item){ ?>
            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['emailType']; ?></option>
                <?php } ?>
        </select>
        <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
        <br>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    
</body>
</html>

