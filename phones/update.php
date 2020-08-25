<?php
require_once '../config.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$id = $_REQUEST['id'];
$contactId = $_REQUEST['contactId'];
$venueId = $_REQUEST['venueId'];
$phoneTypeId = $_REQUEST['phoneTypeId'];
$phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);
$primary = $_REQUEST['primary'];
if(empty($venueId)){
  $primary_sql = "SELECT primaryPhoneId FROM contacts WHERE id='$contactId';";
}else{
  $primary_sql = "SELECT primaryPhoneId FROM venues WHERE id='$venueId';";
}
$primary_result = mysqli_query($conn, $primary_sql);
while ($row = mysqli_fetch_assoc($primary_result)) {
    $primaryPhoneId = is_null($row['primaryPhoneId']) ? 0 : $row['primaryPhoneId'];
}



if (empty($venueId)){
  $sql = "UPDATE phones set contactId='$contactId', phoneTypeId='$phoneTypeId', phone='$phone' where id='$id';";
  $dst = "contacts";
}else{
  $sql = "UPDATE phones set venueId='$venueId', phoneTypeId='$phoneTypeId', phone='$phone' where id='$id';";
  $dst = "venues";
  
}

if(mysqli_query($conn, $sql)){
    // header("location: ../$dst/view.php");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}

if ($primary == "on") {
  // if ($primaryPhoneId == 0) {
    if(empty($venueId)){
      $primary_1_sql = "UPDATE contacts set primaryPhoneId='$id' where id='$contactId';";
    }else{

      $primary_1_sql = "UPDATE venues set primaryPhoneId='$id' where id='$venueId';";
    }
    // // }else{
  // //   $primary_1_sql = "UPDATE contacts set primaryPhoneId='$id' where id='$contactId';";
  // }
  if(mysqli_query($conn, $primary_1_sql)){
    header("location: ../$dst/view.php");
  }else{
    echo "ERROR: Not able to execute $primary_1_sql. " . mysqli_error($conn);
  }
}else{

  if ($primaryPhoneId == $id ) {
    if(empty($venueId)){
      $primary_2_sql = "UPDATE contacts set primaryPhoneId=NULL where id='$contactId';";
    }else{
      $primary_2_sql = "UPDATE venues set primaryPhoneId=NULL where id='$venueId';";
    }
      if(mysqli_query($conn, $primary_2_sql)){
        header("location: ../$dst/view.php");
      }else{
        echo "ERROR: Not able to execute $primary_2_sql. " . mysqli_error($conn);
      }
    }
    

}


$conn->close();
?>