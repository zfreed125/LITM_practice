<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $contactId = $_REQUEST['id'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>LITM Media Masterbase</title>

</head>
<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>
<body>
    <div class="wrapper">
        <h1>Create a Contact</h1>
        <form action="create.php" method="POST">
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">First Name</span></div>
                <input class="form-control" type="text" name="first_name">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Last Name</span></div>
                <input class="form-control" type="text" name="last_name">
            </div>
            <!-- <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Birthdate</span></div>
                <input class="form-control" type="date" name="birthdate">
            </div> -->
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Job Title</span></div>
                <input class="form-control" type="text" name="jobTitle">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Active</span></div>
                <input class="form-control" type="checkbox" id="active" name="active" value="active">
            </div>
                <br>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>
    </div>
</body>
</html>