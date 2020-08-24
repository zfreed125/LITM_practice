<?php
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$src = $_REQUEST['src'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../helpers.js"></script>
    <title>LITM Media Masterbase</title>

</head>
<style>
    .wrapper{
    width: 500px;
    margin: 0 auto;
    }
</style>
<script>
            function updateShortState(e) {
                document.getElementById("shortState").value = e.target.value;
            }
         
        window.addEventListener('load', (event) => {
            //document.getElementById("shortState").value = '<?php //echo $shortState;?>';
                            

            $(function () {
                var output = [];
                var shortStateSelect = '<?php echo $shortState;?>';
                $.each(state, function (i, state) {
                    let j = "";
                    if (state.abrev === shortStateSelect) {
                        j = 'selected';
                    }
                    output.push(`<option value="${state.abrev}"${j}>${state.state}</option>`);
                });
                $('#shortStateSelect').html(output.join(''));
            });
        });
    </script>
<body>
    <div class="wrapper">
        <h1>Add an Address</h1>
        <form action="create.php" method="POST">
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Street 1</span></div>
                <input class="form-control" type="text" name="street1">
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Street 2</span></div>
                <input class="form-control" type="text" name="street2">
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">City</span></div>
                <input class="form-control" type="text" name="city">
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">State</span></div>
                <input class="form-control" autocomplete="off" name="shortState" id="shortState" style="display: none;"> </input>
                <select name="shortStateSelect" id="shortStateSelect" onchange="updateShortState(event)"></select>
            </div>   
                
            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Zip Code</span></div>    
                <input class="form-control" type="text" name="zip1">
            </div>

            <div class="input-group mt-3 mb-1 input-group-sm p-1 w-75">
                <div class="input-group-prepend"><span class="input-group-text">Country</span></div>
                <input class="form-control" type="text" name="country">
            </div>    
                <input hidden style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId;?>">
                <input hidden style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId;?>">
                <input hidden style="width: 2.5em;" type="text" name="src" value="<?php echo $src;?>">
            
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>