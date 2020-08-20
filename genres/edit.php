<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$genre_types_sql = "SELECT * FROM genre_types;";
$result1 = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
}

$id = $_GET["id"];
//attempt insert query execution
$genres_sql = "select id, contactId, venueId, genreTypeId from genres where id='$id';";
$result2 = mysqli_query($conn, $genres_sql);
    //output data of each row
    while ($row = mysqli_fetch_assoc($result2)) {
        $contactId = $row["contactId"];
        $venueId = $row["venueId"];
        $genreTypeId = $row["genreTypeId"];
    }
$conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Genre</title>
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
            <h2>Update Genre</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                                    <!-- <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Genre</span></div>
                                        <input type="text" name="genre" class="form-control" value="<?php echo $genre; ?>">
                                    </div> -->
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                    <select class="form-control" name="genreTypeId">
                                        <option selected="selected">Choose one</option>
                                            <?php foreach($genre_type_array as $item){ ?>
                                        <option value="<?php echo strtolower($item['id']); ?>"
                                            <?php if($item['id'] == $genreTypeId){ echo "selected"; } ?> >
                                        <?php echo $item['genreType']; ?></option>
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