<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




$id = $_GET["id"];
// Attempt insert query execution
$sql = " select contacts.*, address.*, address.id as address_id from contacts, address where contacts.id = '$id' and address.contactId = '$id';
";
$result = mysqli_query($conn, $sql);
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $addressid = $row["address_id"];
        $addressContactId = $row["contactId"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $active = $row["active"];
        $street1 = $row["street1"];
        $street2 = $row["street2"];
        $city = $row["city"];
        $shortState = $row["shortState"];
        $zip1 = $row["zip1"];
        $zip2 = $row["zip2"];
        $country = $row["country"];
    }

 
    $conn->close();
?>
<!-- // HTML Form -->
<!DOCTYPE html>

<html lang="en">
            <head>
                <meta charset="UTF-8">
            <title>Update Record</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <style type="text/css">
                .wrapper{
                        width: 500px;
                    margin: 0 auto;
                    
                }
            </style>
            <script>
                var state = [
                {abrev: "AK" , state: "Alaska"},
                {abrev: "AL" , state: "Alabama"}, 
                {abrev: "AR" , state: "Arkansas"}, 
                {abrev: "AS" , state: "American Samoa"}, 
                {abrev: "AZ" , state: "Arizona"}, 
                {abrev: "CA" , state: "California"}, 
                {abrev: "CO" , state: "Colorado"}, 
                {abrev: "CT" , state: "Connecticut"}, 
                {abrev: "DC" , state: "District of Columbia"}, 
                {abrev: "DE" , state: "Delaware"}, 
                {abrev: "FL" , state: "Florida"}, 
                {abrev: "GA" , state: "Georgia"}, 
                {abrev: "GU" , state: "Guam"}, 
                {abrev: "HI" , state: "Hawaii"}, 
                {abrev: "IA" , state: "Iowa"}, 
                {abrev: "ID" , state: "Idaho"}, 
                {abrev: "IL" , state: "Illinois"}, 
                {abrev: "IN" , state: "Indiana"}, 
                {abrev: "KS" , state: "Kansas"}, 
                {abrev: "KY" , state: "Kentucky"}, 
                {abrev: "LA" , state: "Louisiana"}, 
                {abrev: "MA" , state: "Massachusetts"}, 
                {abrev: "MD" , state: "Maryland"}, 
                {abrev: "ME" , state: "Maine"}, 
                {abrev: "MI" , state: "Michigan"}, 
                {abrev: "MN" , state: "Minnesota"}, 
                {abrev: "MO" , state: "Missouri"}, 
                {abrev: "MS" , state: "Mississippi"}, 
                {abrev: "MT" , state: "Montana"}, 
                {abrev: "NC" , state: "North Carolina"}, 
                {abrev: "ND" , state: "North Dakota"}, 
                {abrev: "NE" , state: "Nebraska"}, 
                {abrev: "NH" , state: "New Hampshire"}, 
                {abrev: "NJ" , state: "New Jersey"}, 
                {abrev: "NM" , state: "New Mexico"}, 
                {abrev: "NV" , state: "Nevada"}, 
                {abrev: "NY" , state: "New York"}, 
                {abrev: "OH" , state: "Ohio"}, 
                {abrev: "OK" , state: "Oklahoma"}, 
                {abrev: "OR" , state: "Oregon"}, 
                {abrev: "PA" , state: "Pennsylvania"}, 
                {abrev: "PR" , state: "Puerto Rico"}, 
                {abrev: "RI" , state: "Rhode Island"}, 
                {abrev: "SC" , state: "South Carolina"}, 
                {abrev: "SD" , state: "South Dakota"}, 
                {abrev: "TN" , state: "Tennessee"}, 
                {abrev: "TX" , state: "Texas"}, 
                {abrev: "UT" , state: "Utah"}, 
                {abrev: "VA" , state: "Virginia"}, 
                {abrev: "VI" , state: "Virgin Islands"}, 
                {abrev: "VT" , state: "Vermont"}, 
                {abrev: "WA" , state: "Washington"}, 
                {abrev: "WI" , state: "Wisconsin"}, 
                {abrev: "WV" , state: "West Virginia"}, 
                {abrev: "WY" , state: "Wyoming"}
                ];
                // <option value="AL">Alabama (AL)</option>
                // console.log(state.map(x => "adam" + x.abrev));
                // console.log(state.map(x => "<option value='" + x.abrev + "'>" + x.state + "</option>"));
                
                window.addEventListener('load', (event) => {

                    var x = document.getElementById("active").value; 
                    if (x == 1) {
                        document.getElementById("active").checked = true;
                    }else{
                        document.getElementById("active").checked = false;
                    }
                    // var y = document.getElementById('shortState');
                    // y.append.text(state.map(x => "<option value='" + x.abrev + "'>" + x.state + "</option>"));
                    // function addOption(selectbox,text,value)
                    // {var optn = document.createElement("OPTION");
                    // optn.text = text;
                    // optn.value = value;
                    // selectbox.options.add(optn);
                    // }   
                    // for (var i=0; i < state.lenght;++i){
                    //     addOption(document.drop_list.state_list, state[i], state[i]);
                    // }   
                    // var cuisines = ["Chinese","Indian"];     
                    var sel = document.getElementById('Stateslist');
                    for(var i = 0; i < state.length; i++) {
                    var opt = document.createElement('option');
                    opt.innerHTML = state[i];
                    opt.value = state[i];
                    sel.appendChild(opt);
                    }              
                });
                    
            </script>
    </head>
        <body>
                <div class="wrapper">
                        <h2>Update Record</h2>
                            <p>Please edit the input values and submit to update the record.</p>
                            <form name="drop_list" action="update.php" method="post">
                               
                            <div class="form-group">
                                <label>active</label>
                                <input type="checkbox" name="active" id="active" class="form-control" value="<?php echo $active; ?>">
                            </div>
                            <div class="form-group">
                                <label>addressContactId</label>
                                <input type="text" name="addressContactId" class="form-control" value="<?php echo $addressContactId; ?>">
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>firstname</label>
                                    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                                </div>
                                <div class="form-group">
                                    <label>lastname</label>
                                    <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>street1</label>
                                    <input type="text" name="street1" class="form-control" value="<?php echo $street1; ?>">
                                </div>
                                <div class="form-group">
                                    <label>street2</label>
                                    <input type="text" name="street2" class="form-control" value="<?php echo $street2; ?>">
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>city</label>
                                    <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                </div>
                                <div class="form-group">
                                    <label>State</label>


                                    <select name="shortState" id="shortState" value="<?php echo $shortState; ?>">
                                        <option value="" >Select State...</option>
                                        <!-- {state.map(x => "<option value='" + x.abrev + "'>" + x.state + "</option>");} -->
                                    </select>
                                    <!-- <input type="text" name="shortState" class="form-control" value="<?php echo $shortState; ?>"> -->
                                </div>
                            </div>

                            <div class="input-group">
                                <div class="form-group">
                                    <label>zip1</label>
                                    <input type="text" name="zip1" class="form-control" value="<?php echo $zip1; ?>">
                                </div>
                                <div class="form-group">
                                    <label>zip2</label>
                                    <input type="text" name="zip2" class="form-control" value="<?php echo $zip2; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>country</label>
                                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                            </div>
                                <input type="hidden" name="addressid" value="<?php echo $addressid; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <br>
                                <br>
                                <a class="btn btn-danger" href="delete.php?id=<?php echo "$id&addressid=$addressid";?>">Delete</a>
                            </form>
                </div>
    </body>
        </html>