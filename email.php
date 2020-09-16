<?php
$rawdata = file_get_contents('php://input');
$data = json_decode($rawdata,true);
// print_r($data);
$bookingType = $data['bookingType'];
$StartDate = $data['StartDate'];
$StartTime = $data['StartTime'];
$EndDate = $data['EndDate'];
$EndTime = $data['EndTime'];
$timezone = $data['timezone'];
$bookingLength = $data['bookingLength']
$clientFullName = $data['clientFullName'];
$clientNameId = $data['clientNameId']
$primaryEmail = $data['primaryEmail'];
$bookingColor = $data['bookingColor']
$clientConfirm = $data['clientConfirm']
$venueName = $data['venueName'];
$venueConfirm = $data['venueConfirm']
$bookingStatus = $data['bookingStatus'];
$to = "admin@callitweb.com";
// $to = "somebody@example.com, somebodyelse@example.com";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email2</title>
</head>
<style>
    .th {
        text-align: left;
    }
    .td {
        text-align: left;
    }
    img {
        width: 8%;
    }
</style>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th class='th'>Date:</th>
<td class='td'>9/15/2020</td>
</tr>
<tr>
<th class='th'>Time:</th>
<td class='td'>9:00pm</td> 
</tr>
<tr>
<th class='th'>Show Name:</th>
<td class='td'>Everything Imaginable</td> 
</tr>
<tr>
<th class='th'>Host:</th>
<td class='td'>Gary</td> 
</tr>
<tr>
<th class='th'>Length of Interview:</th>
<td class='td'>1-3 hours</td> 
</tr>
<tr>
<th class='th'>Website:</th>
<td class='td'>Everythingimaginable2020.com</td> 
</tr>
<tr>
<th class='th'>Notes:</th>
<td class='td'>Hi!</td> 
</tr>
<br>
<br>
</table>
<img src='https://ci3.googleusercontent.com/proxy/r5QP5P6T_WDQRE6TJNt9fDkJGl0vEl96dSnZQ9qZmWqhOdwN7GZLmfEFabihsPUa8qfrjeNxjvpxdzhdnkBc2A64i7p4mLOirNAiBo7yyRPo8JSoCmrhsN2nnt3Xr9WhXJMYe_2voaaeITFN4HS1WwhJi3d1yxJxbCNauRdhdQgkV2tKqOmg_Hl9DxIkpTQrYmq60mjVWLJRu_KAew=s0-d-e1-ft#https://docs.google.com/uc?export=download&id=1KFwppgNkPJgHCfNZb2KZsYmX6VGRuY-9&revid=0Bw3hvFN4lg78OU9pZU9zZUQzTlRlWkF6NlZMOG1GYmxmOEhvPQ'>
<p>Michelle Freed, Publicist</p>
<p>LITM Media</p>
<p>'Leave it to Michelle'</p>
<p>424-409-5486</p>
<a href='https://litmmedia.com/'>https://litmmedia.com/</a>
</body>
</html>
";
echo $message;
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <michelle@litmmedia.com>' . "\r\n";
$headers .= 'Cc: michelle@litmmedia.com' . "\r\n";

// mail($to,$subject,$message,$headers);

// echo "../email.php Done!";
?> 