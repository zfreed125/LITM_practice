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
$note_sql = "select id, contactId, note from notes where id='$id';";
$result2 = mysqli_query($conn, $note_sql);
    //output data of each row
    while ($row = mysqli_fetch_assoc($result2)) {
        $contactId = $row["contactId"];
        $note = $row["note"];
    }
$conn->close();
?>
<!-- //HTML Form -->
<!DOCTYPE html>
<html lang="en">
    <head>
            <meta charset="UTF-8">
            <title>Update Note</title>
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
            <h2>Update Note</h2>
                <p>Please edit the input values and submit to update the record.</p>
                    <form action="update.php" method="POST">
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                        <div class="input-group-prepend"><span class="input-group-text">Note</span></div>
                                        <!-- <input type="text" name="note" class="form-control" > -->
                                    </div>
                                    <div class="input-group mt-3 mb-1 input-group-sm p-1 w-50">
                                    <textarea name="note" id="note" rows="4" cols="50"><?php echo $note; ?>
                                    </textarea>
                                    </div>
                                    <input type="hidden" name="contactId" value="<?php echo $contactId; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="m-5">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <!-- </div> -->
                            <!-- <div class="mt-3 mb-1"> -->
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $id;?>">Delete</a>
                            </div>
                    </form>
        </div>
    </body>       
</html>    