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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
</head>

<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>

<body>

    <h1 class="center">Add a Note</h1>
    <form class="center" action="create.php" method="POST">
        <label>Add Notes</label>
        <input type="text" name="author" id="author" placeholder="Author">
        <input type="text" name="topic" id="topic" placeholder="Topic">
        <!-- <input type="date" name="created" id="created" placeholder="Created"> -->
        <!-- <input type="text" name="modified" id="modified" placeholder="Modified"> -->
        <textarea name="note" id="note" rows="4" cols="50">
        </textarea>
        <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
        <input hidden id="venueId" style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId; ?>">
        <br>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    
</body>
</html>

