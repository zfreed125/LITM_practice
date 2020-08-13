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
    <title>LITM Media Masterbase</title>

</head>
<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>
<body>
    <h1 class="center">Create a Contact</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="first_name" placeholder="Firstname">
        <br>
        <br>
        <input type="text" name="last_name" placeholder="Lastname">
        <br>
        <br>
        <input type="date" name="birthdate" placeholder="Birth Date">
        <br>
        <br>
        <input type="text" name="jobTitle" placeholder="Job Title">
        <br>
        <br>
        <input type="checkbox" id="active" name="active" value="active">
        <label for="active">Active</label>
        <br>
        <br>
         <button type="submit" name="submit">Submit</button>

    </form>
</body>
</html>