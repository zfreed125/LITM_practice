<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// echo 'hi';
// $field0 = "0;"
// $field1 = "2;"
// $field2 = "1;"

// $sql = "INSERT INTO bookings () VALUES ();";



// $sql = "SELECT genreTypeId FROM genres WHERE contactId='3'";
// // echo $sql;
// $result = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_assoc($result)){
// $sql2 = "SELECT genreType FROM genre_types WHERE id='$row[genreTypeId]'";

// }

$sql3 = "SELECT genres.genreTypeId, genre_types.genreType FROM genres
INNER JOIN genre_types ON genres.genreTypeId=genre_types.id WHERE genres.contactId='3'";
$result3 = mysqli_query($conn, $sql3);
while($row = mysqli_fetch_assoc($result3)){
  // echo $row['genreTypeId'];
  echo $row['genreType'];
}




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