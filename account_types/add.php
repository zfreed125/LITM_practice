<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Account Type Register</title>
</head>

<style>
            .wrapper{
                    width: 500px;
                margin: 0 auto;
            }
</style>

<body>
    <div class="wrapper">
        <h1>Add an Account Type</h1>
            <form action="create.php" method="POST">
                <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                    <div class="input-group-prepend"><span class="input-group-text">Account</span></div>
                    <input class="form-control" type="text" name="accountType">
                </div>
                <br>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>
    </div>
    
</body>
</html>