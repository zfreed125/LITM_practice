<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET["id"];
$sql = "select id, bookingType from booking_types where id='$id';";
$result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $bookingType = $row["bookingType"];
    }
    $conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Email</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <script src="../helpers.js"></script>
    <style type="text/css">
        .wrapper{
        width: 500px;
        margin: 0 auto;
        }
    </style>
    </head> 
    <body>
        <div class="wrapper">
            <h2>Update Email Type</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                        <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                            <div class="input-group-prepend"><span class="input-group-text">Email</span></div>
                            <input type="text" name="bookingType" class="form-control" value="<?php echo $bookingType; ?>">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <br>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                    </form>
        </div>
    </body>       
</html>    