<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$genre_types_sql = "SELECT * FROM genre_types;";
$result = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
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
    <title>Genre Register</title>
</head>

<style>
   .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>

<body>
    <div class="wrapper">
        <h1 class="center">Add an Genre</h1>
        <form class="center" action="create.php" method="POST">
            <div class="input-group">
            <div class="input-group-prepend"><select name="genreTypeId"></div>
                
                <option selected="selected">Choose one</option>
                    <?php foreach($genre_type_array as $item){ ?>
                <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['genreType']; ?></option>
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

