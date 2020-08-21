<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$id = $_GET["id"];
//attempt insert query execution
$sql = "select id, phoneType from phone_types where id='$id';";
$result = mysqli_query($conn, $sql);
    //output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $phoneType = $row["phoneType"];
    }
    $conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Phone</title>
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
            <h2>Update Phone Type</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                        <!-- Flip card needs to be collapsable -->
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                                        <div class="input-group-prepend"><span class="input-group-text">Phone</span></div>
                                        <input type="text" name="phoneType" class="form-control" value="<?php echo $phoneType; ?>">
                                    </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <br>
                            <br>
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                    </form>
        </div>
    </body>       
</html>    