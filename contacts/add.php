<?php
require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email_sql = "SELECT * FROM email_types;";
$email_result = mysqli_query($conn, $email_sql);
$email_type_array = array();
while ($row = mysqli_fetch_assoc($email_result)) {
    $email_type_array[] = array('id' => $row['id'], 'emailType' => $row['emailType']);
}
$account_types_sql = "SELECT * FROM account_types;";
$result = mysqli_query($conn, $account_types_sql);
$account_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $account_type_array[] = array('id' => $row['id'], 'accountType' => $row['accountType']);
}
$genre_types_sql = "SELECT * FROM genre_types;";
$result = mysqli_query($conn, $genre_types_sql);
$genre_type_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $genre_type_array[] = array('id' => $row['id'], 'genreType' => $row['genreType']);
}
$timezones_sql = "SELECT * FROM timezones;";
$timezones_result = mysqli_query($conn, $timezones_sql);
$timezones_array = array();
while ($row = mysqli_fetch_assoc($timezones_result)) {
    $timezones_array[] = array('id' => $row['id'], 'name' => $row['name']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">

</head>
<style>
    .wrapper {
        width: 500px;
        margin: 0 auto;
    }

    .hide {
        display: none;
    }
</style>
<script>
    
    
    function showEmailType() {
        var email = document.getElementById("email");
        var emailTypeId = document.getElementById("emailTypeId");
        var emailTypeDiv = document.getElementById("emailTypeDiv");
        emailTypeDiv.classList.remove("hide");
        if (email.value == "") {
            emailTypeDiv.classList.add("hide");
        }
    }

    function formValidate() {
        var email = document.getElementById("email");
        var emailTypeId = document.getElementById("emailTypeId");
        var emailTypeDiv = document.getElementById("emailTypeDiv");
        var gotEmailAddress = email.value !== "";
        var missingEmailType = gotEmailAddress && emailTypeId.value === "-1"
        if (missingEmailType) {
            emailTypeDiv.classList.remove("hide");
            emailTypeId.focus();
            return false;
        }
    }
</script>

<body class="body">
    <div class="wrapper">
        <h1 class="label">Create a Contact</h1>
        <form action="create.php" method="POST" onsubmit="return formValidate()">
        <input type="hidden" name="dov" value="Dov" />
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">First Name</span></div>
                <input class="form-control" type="text" name="first_name">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Last Name</span></div>
                <input class="form-control" type="text" name="last_name">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Email</span></div>
                <input id="email" class="form-control" type="text" name="email" onchange="showEmailType()">
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div id="emailTypeDiv" class="hide input-group-prepend">
                    <span class="input-group-text label">Email Type</span>
                    <select id="emailTypeId" name="emailTypeId">
                        <option id="chooseOption" selected="selected" value="-1">Choose one</option>
                        <?php foreach ($email_type_array as $item) { ?>
                            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['emailType']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="hide">
                    <p style="color: tomato;">* Required Field</p>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend">
                    <span class="input-group-text label">Contact Timezone</span>
                    <select class="form-control" name="timezoneId">
                        <option value="12" selected="selected">Default *(CST)</option>
                        <?php foreach ($timezones_array as $item) { ?>
                            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Account Type</span><select name="accountTypeId">
                        <option value="-1" selected="selected">Choose one</option>
                        <?php foreach ($account_type_array as $item) { ?>
                            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['accountType']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Genre Type</span><select size="10" multiple name="genreTypeId[]">
                        <option disabled selected="selected">Choose one or multiple with Ctl Button</option>
                        <?php foreach ($genre_type_array as $item) { ?>
                            <option value="<?php echo strtolower($item['id']); ?>"><?php echo $item['genreType']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text label">Active</span></div>
                <input class="form-control" type="checkbox" id="active" name="active" value="active">
            </div>
            <br>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>

</html>