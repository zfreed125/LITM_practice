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
    .center {
        text-align: center;
        background-color: violet;
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
    <h1 class="center">Add an Address</h1>
    <form class="center" action="create.php" method="POST">
        <input type="text" name="street1" placeholder="Street #1">
        <input type="text" name="street2" placeholder="Street #2"><br><br>
        <input type="text" name="city" placeholder="City">
        <input autocomplete="off" name="shortState" id="shortState" style="display: none;"> </input>
        <select name="shortStateSelect" id="shortStateSelect" onchange="updateShortState(event)"></select>
        <br><br>
        <input style="width: 3em;" type="text" name="zip1" placeholder="Zip #1">-
        
       <input hidden style="width: 2.5em;" type="text" name="contactId" value="<?php echo $contactId;?>">
       <input hidden style="width: 2.5em;" type="text" name="venueId" value="<?php echo $venueId;?>">
       <input hidden style="width: 2.5em;" type="text" name="src" value="<?php echo $src;?>">
        <br>
        <br>
       <input type="text" name="country" placeholder="Country">
        <br>
        <br>
         <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>