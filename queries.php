<?php

require_once 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// if (isset($_post['0'])){
    $sql = "SELECT * FROM contacts;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result))
    {
        
        echo "$row[firstname]";
        echo "$row[lastname]";
        echo "$row[birthdate]";
        // echo "$row[id]";
        echo "<br>";
        $id = $row['id'];


                $sql2 = "SELECT * FROM addresses WHERE contactId = '$id';";
                $result2 = mysqli_query($conn, $sql2);
            
                while ($row = mysqli_fetch_assoc($result2))
                {
                    echo "$row[street1]";
                    echo "$row[street2]";
                    echo "$row[city]";
                    echo "$row[shortState]";
                    echo "$row[zip1]";
                    echo "$row[country]";
                    echo "<br>";
                }
    }

    
// }

?>