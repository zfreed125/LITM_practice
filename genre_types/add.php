<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre Type Register</title>
</head>

<style>
    .center {
        text-align: center;
        background-color: violet;
    }
</style>

<body>

    <h1 class="center">Add a Genre Type</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="genreType" placeholder="Genre Type">
        <br>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    
</body>
</html>