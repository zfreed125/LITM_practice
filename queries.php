<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
function get_timezone_abbreviation($timezone_id)
{
    if($timezone_id){
        $abb_list = timezone_abbreviations_list();

        $abb_array = array();
        foreach ($abb_list as $abb_key => $abb_val) {
            foreach ($abb_val as $key => $value) {
                $value['abb'] = $abb_key;
                array_push($abb_array, $value);
            }
        }

        foreach ($abb_array as $key => $value) {
            if($value['timezone_id'] == $timezone_id){
                return strtoupper($value['abb']);
            }
        }
    }
    return FALSE;
} 
// echo get_timezone_abbreviation('America/New_York');
echo "<pre>";
// print_r(timezone_abbreviations_list());
// print_r(timezone_abbreviations_list());
echo "</pre>";
// echo 'hi';
// $field0 = "0;"
// $field1 = "2;"
// $field2 = "1;"

// $sql = "INSERT INTO bookings () VALUES ();";



$sql = "SELECT * FROM timezones;";
// echo $sql;
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)){
// echo $row['timezone']."<br>";
// echo get_timezone_abbreviation($row['timezone']).",".$row['timezone']. ",".$row['name'].",".$row['offset'].",<br>";
echo $row['offset'].",<br>";
}

// $sql3 = "SELECT genres.genreTypeId, genre_types.genreType FROM genres
// INNER JOIN genre_types ON genres.genreTypeId=genre_types.id WHERE genres.contactId='3'";
// $result3 = mysqli_query($conn, $sql3);
// while($row = mysqli_fetch_assoc($result3)){
//   // echo $row['genreTypeId'];
//   echo $row['genreType'];
// }




// $account_sql = "SELECT * FROM accounts where contactId=1 AND accountTypeId=4;";
// $account_sql = "SELECT accounts.accountTypeId, account_types.id, account_types.accountType as typeName  FROM accounts 
// INNER JOIN account_types ON accounts.accountTypeId=account_types.id WHERE accounts.contactId=1;";
// $account_result = mysqli_query($conn, $account_sql);
// $contact_type_array = array();
// $is_client = False;
// while ($row = mysqli_fetch_assoc($account_result)) {
//   // echo $row['accountType'];
//   echo $row['typeName'];
//     // if (!empty($row['id'])){
//     //     $is_client = True;
//     // }
//     // $contact_type_array[] = array('id' => $row['id'], 'contactType' => $row['contactType']);
// }
//  echo $is_client;
?>