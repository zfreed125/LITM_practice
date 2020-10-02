<?php

(!empty($_REQUEST['month'])) ? $month = $_REQUEST['month'] : $month = idate('m');
(!empty($_REQUEST['year'])) ? $year = $_REQUEST['year'] : $year = idate('Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    input {
        width: 75px;
        margin-left: 20px;
    }

    h3 {
        margin-left: 160px;
    }

    .wrapper {
        display: flex;
        margin-left: 160px;

    }

    .card {
        background-color: #4A0C57;
        color: #4FDC0E;
        border: solid 6px #4FDC0E;
        position: relative;
        margin: 20px;
        padding: 10px;
        max-width: 35%;
        text-align: center;
        flex-flow: row wrap;

    }

    .container>div {}

    .dot {
        height: 25px;
        width: 25px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
</style>

<body>
    <form name="myForm" action="index.php" method="POST">
        <span>
            <h3 class="center">(Client Only) Month: <input name="month" type="text" value="<?php echo $month; ?>"> Year: <input name="year" type="text" value="<?php echo $year; ?>"><input class="btn btn-primary" type="submit" name="submit" value="Submit"></h3>

        </span>
    </form>
    <div class='wrapper'>

        <?php

        require_once './config.php';

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $init_todo_array = array();
        $todo_sql = "
select 
    IFNULL(concat(contacts.firstname, ' ', contacts.lastname),'N/A') as client,
    IFNULL(bookings.bookingDateTimeStart,'unset') as startTime,
    bookings.bookingLength as duration,
    contacts.bookingCount as requiredCount,
    contacts.bookingColor as color,
    IFNULL(venues.venueName,'unassigned') as venue
from 
    bookings
left join contacts on bookings.clientNameId = contacts.id
left join venues on bookings.venueNameId = venues.id
where
    bookings.bookingDateTimeStart is null or
    (
        year(bookings.bookingDateTimeStart)=" . $year . " and
        month(bookings.bookingDateTimeStart)=" . $month . "
    )
order by client
;";

        $todo_result = mysqli_query($conn, $todo_sql);
        while ($row = mysqli_fetch_assoc($todo_result)) {
            $init_todo_array[] = $row;
        }
        // Array
        // (
        //     [0] => Array
        //         (
        //             [client] => Arlen Schumer
        //             [startTime] => unset
        //             [duration] => 0
        //             [requiredCount] => 4
        //             [color] => #000000
        //             [venue] => unassigned
        //         )
        // )

        // $client_bookings = [
        //     'client name' => [
        //         'bookings' => [
        //             ['startdate', 'duration', 'venue'],
        //             ['startdate', 'duration', 'venue'],
        //             ['startdate', 'duration', 'venue'],
        //         ],
        //         'color' => '#fff',
        //         'requiredCount' => 'required',
        //     ],
        //     'client name' => [
        //         'bookings' => [
        //             ['startdate', 'duration', 'venue'],
        //             ['startdate', 'duration', 'venue'],
        //             ['startdate', 'duration', 'venue'],
        //         ],
        //         'color' => '#fff',
        //         'requiredCount' => 'required',
        //     ]
        // ]
        $data = $init_todo_array;
        $client_bookings = [];
        // echo "<pre>";
        foreach ($data as $item) {
            $client = $item['client'];

            if (array_key_exists($client, $client_bookings)) {
                array_push($client_bookings[$client]['bookings'], [
                    'startTime' => $item['startTime'],
                    'duration' => $item['duration'],
                    'venue' => $item['venue']
                ]);
            } else {
                $client_bookings[$client] = [
                    'bookings' => [
                        [
                            'startTime' => $item['startTime'],
                            'duration' => $item['duration'],
                            'venue' => $item['venue']
                        ]
                    ],
                    'color' => $item['color'],
                    'requiredCount' => $item['requiredCount'],
                    'htmlCard' => <<<HTML
    <div class="card">
        <div class="container">
            <h4>$client</h4>
        </div>
    </div>
HTML
                ];
            }
        }
        // print_r($client_bookings);
        // echo "</pre>";
        foreach($client_bookings as $client => $details){
            // $bookings_count = sizeof($details['bookings']);
            // echo $details['htmlCard'];
        }



        $client_count_array = array();
        $full_client_count_array = array();
        foreach ($init_todo_array as $item) {
            $client = $item['client'];
            $full_client_count_array[$client][] = $item;
            $client_count_array[$client] = array_count_values(array_column($init_todo_array, 'client'))[$client];
            $tt = array_unique($client_count_array);
        }

        $card = '';
        foreach (array_keys($full_client_count_array) as $client) {
            $card = " <div class='card'><div class='container'> ";
            $card .= " <h4><b>" . $client . "</b>";
            for ($i = 0; $i < count($full_client_count_array[$client]); $i++) {
                $req = $full_client_count_array[$client][$i]['requiredCount'];
                $card .= "<div><span title='" . 'StartTime: ' . $full_client_count_array[$client][$i]['startTime'] . ' Venue: ' . $full_client_count_array[$client][$i]['venue'] . "' style='background-color: " . $full_client_count_array[$client][$i]['color'] . ";' class='dot'></span></div>";
            }
            $empty_dots = $req - $i;
            for ($j = 0; $j < $empty_dots; $j++) {
                $card .= "<div><span style='background-color: grey;' class='dot'></span></div>";
            }

            $card .= " </div> </div> ";
            echo $card;

        }




        // foreach(client_bookings as client => details){
        // bookings = details['bookings]
        // color = details['color']
        // requiredCount = details['requiredCount']
        // $bookings_count = len($bookings)
        // foreach(bookings){
        // 
        // }
        // 
        // 
        // }

        ?>
    </div>
</body>

</html>