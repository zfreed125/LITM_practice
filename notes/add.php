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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Notes</title>
</head>

<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>

<body>
<div class="wrapper">
    <h1 class="center">Add a Note</h1>
    <form class="center" action="create.php" method="POST">
        <label>Add Notes</label>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Author</span></div>
                <input type="text" name="author" id="author" placeholder="Author">

            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Topic</span></div>
                <input type="text" name="topic" id="topic" placeholder="Topic">

            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Note</span></div>
                <textarea class="form-control" name="note" id="note" rows="4" cols="50"></textarea>
            </div>

        <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
        <input hidden id="venueId" style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId; ?>">
        <button  class="btn btn-primary" type="submit" name="submit">Submit</button>
    </form>
    
</div>
</body>
</html>

