<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// $email_sql = "SELECT * FROM emails where contactId = '7';";
$email_sql = "SELECT email_types.*, link_email_types.*
FROM email_types
INNER JOIN  link_email_types
ON link_email_types.emailId = email_types.id
";
// $link_email_types = "SELECT emailTypeId FROM link_email_types WHERE emailId = '1';";
// $result = mysqli_query($conn, $link_email_types);
//     echo "<pre>";
// print_r($result); 
//     echo "</pre>";


// $email_types = "SELECT emailtype FROM email_types WHERE id='$link_email_types_result';";

$result = mysqli_query($conn, $email_sql);
while ($row = mysqli_fetch_assoc($result)){
    echo "<pre>";
    print_r($row);
    echo "</pre>";
}


// if (isset($_post['0'])){
    // $sql = "SELECT * FROM contacts;";
    // $result = mysqli_query($conn, $sql);

    // while ($row = mysqli_fetch_assoc($result))
    // {
        
    //     echo "$row[firstname]";
    //     echo "$row[lastname]";
    //     echo "$row[birthdate]";
    //     // echo "$row[id]";
    //     echo "<br>";
    //     $id = $row['id'];


    //             $sql2 = "SELECT * FROM addresses WHERE contactId = '$id';";
    //             $result2 = mysqli_query($conn, $sql2);
            
    //             while ($row = mysqli_fetch_assoc($result2))
    //             {
    //                 echo "$row[street1]";
    //                 echo "$row[street2]";
    //                 echo "$row[city]";
    //                 echo "$row[shortState]";
    //                 echo "$row[zip1]";
    //                 echo "$row[country]";
    //                 echo "<br>";
    //             }
    // }

    
// }


?>