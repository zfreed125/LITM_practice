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
$contactId = $_REQUEST['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Register</title>
</head>

<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>

<body>

    <h1 class="center">Add an Genre</h1>
    <form class="center" action="create.php" method="POST">
        <!-- <input type="text" name="genre" placeholder="genre"> -->
        <select name="genreTypeId">
            <option selected="selected">Choose one</option>
                <?php foreach($genre_type_array as $item){ ?>
            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['genreType']; ?></option>
                <?php } ?>
        </select>
        <input hidden id="contactId" style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId; ?>">
        <br>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    
</body>
</html>

