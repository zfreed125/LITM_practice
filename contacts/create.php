<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




    
$first_name = mysqli_real_escape_string($conn, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_REQUEST['last_name']);
$birthdate = $_REQUEST['birthdate'];
$timezoneId = $_REQUEST['timezoneId'];
$active = (isset($_POST['active'])) ? 1 : 0;
$accountTypeId = $_REQUEST['accountTypeId'];
$genreTypeId = $_REQUEST['genreTypeId'];
$emailTypeId = $_REQUEST['emailTypeId'];
$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
$dst = "contacts";

(empty($birthdate)) ? $birthdate = 'NULL': $birthdate = "'" .$birthdate. "'";
$sql = "INSERT INTO contacts (firstname, lastname, birthdate, timezoneId, active) VALUES ('$first_name', '$last_name', ".$birthdate.", '$timezoneId', '$active')";
if(mysqli_query($conn, $sql)){
    $contactId = mysqli_insert_id($conn);
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($conn);
}

if($emailTypeId != '-1' || !empty($email)){
    $email_sql = "INSERT INTO emails (contactId, emailTypeId, email) VALUES ('$contactId', '$emailTypeId', '$email')";
    if(mysqli_query($conn, $email_sql)){
        // header("location: ../$dst/view.php");
    } else{
        echo "ERROR: Not able to execute $account_sql. " . mysqli_error($conn);
    }
}
if($accountTypeId != '-1'){
    $account_sql = "INSERT INTO accounts (contactId, accountTypeId) VALUES ('$contactId', '$accountTypeId')";
    if(mysqli_query($conn, $account_sql)){
        // header("location: ../$dst/view.php");
    } else{
        echo "ERROR: Not able to execute $account_sql. " . mysqli_error($conn);
    }
}

if(!empty($genreTypeId)){
    //loop array
    $genre_sql = "INSERT INTO genres (contactId, genreTypeId) VALUES ";
    foreach($genreTypeId as $value) {
        $genre_sql .=  "('$contactId', '$value'),";
    }
    
    if(mysqli_query($conn, rtrim($genre_sql, ", "))){
    header("location: ../$dst/view.php");
    } else{
        echo "ERROR: Not able to execute $genre_sql. " . mysqli_error($conn);
    }
}

header("location: ../$dst/view.php");






    $conn->close();
