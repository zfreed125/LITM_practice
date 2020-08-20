<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$src = $_REQUEST['src'];
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Info</title>
</head>

<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>

<body>

    <h1 class="center">Add an alternative way for messaging</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="serviceName" placeholder="serviceName">
        <br>
        <br>
        <input type="text" name="userAccount" placeholder="userAccount">
        <br>
        <br>
        <textarea name="notes" id="notes" rows="4" cols="50"></textarea>
        <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
        <input hidden id="venueId" style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId; ?>">
        <input hidden type="text" name="src" value="<?php echo $src; ?>">
        <br>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    
</body>
</html>

