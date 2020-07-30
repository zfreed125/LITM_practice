<?php 
require_once 'config.php';

// // Create connection
$conn = new mysqli($servername, $username, $password, $database);

// // Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$addressfields = ['street1','street2', 'city', 'shortState', 'zip1', 'zip2', 'country'];

$firstname = mysqli_real_escape_string($conn, $_REQUEST['firstName']);
$lastname = mysqli_real_escape_string($conn, $_REQUEST['lastName']);
echo "Contact: First Name: $firstname";
echo "<br>";
echo "Contact: Last Name: $lastname";
echo "<br>";

foreach($addressfields as $index=>$value){
    // echo "$value <br> $index <br>";
    foreach($_POST[$value] as $i=>$val){
        $$value = $val;
        echo "$value: " . $$value;
        echo "<br>";
    }
}

// foreach($_POST['street1'] as $index=>$value){
//     $street[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: Street 1: $street[$index]";
//     echo "<br>";
// }
// foreach($_POST['street2'] as $index=>$value){
//     $street2[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: Street 2: $street2[$index]";
//     echo "<br>";
// }
// foreach($_POST['city'] as $index=>$value){
//     $city[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: City 1: $city[$index]";
//     echo "<br>";
// }
// foreach($_POST['shortState'] as $index=>$value){
//     $shortState[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: State: $shortState[$index]";
//     echo "<br>";
// }
// foreach($_POST['zip1'] as $index=>$value){
//     $zip1[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: Zip 1: $zip1[$index]";
//     echo "<br>";
// }
// foreach($_POST['zip2'] as $index=>$value){
//     $zip2[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: Zip 2: $zip2[$index]";
//     echo "<br>";
// }
// foreach($_POST['country'] as $index=>$value){
//     $country[$index]  = $value;
//     $addr_num = $index + 1;
//     echo "Address $addr_num: Country: $country[$index]";
//     echo "<br>";
// }

?>