<?php
require_once 'config.php';
function convertDateTimeUTCtoLocal($bookingDateTime, $tz)
{
    $utc_date = DateTime::createFromFormat(
        'Y-m-d H:i:s',  // this the format from mysql
        // 'Y-m-d G:i',  // this the format from mysql
        $bookingDateTime, // this is the output from mysql $bookingDateTime...
        new DateTimeZone('UTC')
    );
    //
    $local_date = $utc_date;
    $local_date->setTimeZone(new DateTimeZone($tz));
    //
    $bookingDate = $local_date->format('n-j-Y'); // output: 08-25-2020
    $bookingTime = $local_date->format('H:i'); // output: 10:45 PM

    return array($bookingDate, $bookingTime);
}
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$rawdata = file_get_contents('php://input');
$data = json_decode($rawdata, true);
// print_r($data);
$bookingType = $data['bookingType'];
$StartDate = $data['StartDate'];
$bookingDateTimeStart = $data['bookingDateTimeStart'];
$StartTime = $data['StartTime'];
$bookingDateTimeEnd = $data['bookingDateTimeEnd'];
$EndDate = $data['EndDate'];
$EndTime = $data['EndTime'];
$litmTimezoneName = $data['timezone'];
$litmTimezoneId = 12;
$litmTimezoneOffset = '-06:00';
$bookingLength = $data['bookingLength'];
$clientFullName = $data['clientFullName'];
$clientNameId = $data['clientNameId'];
$bookingColor = $data['bookingColor'];
$clientConfirm = $data['clientConfirm'];
$venueName = $data['venueName'];
$hostFullName = $data['hostFullName'];
$venueConfirm = $data['venueConfirm'];
$bookingStatus = $data['bookingStatus'];

$primaryVenueId = $data['primaryVenueId'];
$primaryVenueNoteId = $data['primaryVenueNoteId'];
$primaryVenueNote = $data['primaryVenueNote'];
$clientPrimaryEmailId = $data['clientPrimaryEmailId'];
$clientPrimaryEmail = $data['clientPrimaryEmail'];
$hostPrimaryEmailId = $data['hostPrimaryEmailId'];
$hostPrimaryEmail = $data['hostPrimaryEmail'];
$primaryVenueServiceId = $data['primaryVenueServiceId'];
$primaryVenueServiceName = $data['primaryVenueServiceName'];
$primaryVenueServiceUserAccount = $data['primaryVenueServiceUserAccount'];
$primaryVenueServiceWebsite = $data['primaryVenueServiceWebsite'];
$primaryVenueServiceNotes = $data['primaryVenueServiceNotes'];
$clientTzId = $data['clientTzId'];
$pacificTimezoneName = 5;
$pacificTimezoneName = 'America/Los_Angeles';
$to = "$clientPrimaryEmail";
// $to = "admin@callitweb.com, mich721@gmail.com";
// $to = "somebody@example.com, somebodyelse@example.com";
$subject = "Booking Schedule: For(" . $clientFullName . ")";


$timezone_sql = "SELECT * from timezones where id='$clientTzId';";
    $timezone_result = mysqli_query($conn, $timezone_sql);
    if (mysqli_num_rows($timezone_result) > 0) {
        $row = mysqli_fetch_assoc($timezone_result);
        $clientTzId = $row['id'];
        $clientTzOffset = $row['offset'];
        $clientTimezoneName = $row['timezone'];
    }

    (empty($bookingDateTimeStart)) ? $clientStartDate = 'unset' : $clientStartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $clientTimezoneName)[0];
    (empty($bookingDateTimeStart)) ? $clientStartTime = 'unset' : $clientStartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $clientTimezoneName)[1];
    (empty($bookingDateTimeEnd)) ? $clientEndDate = 'unset' : $clientEndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $clientTimezoneName)[0];
    (empty($bookingDateTimeEnd)) ? $clientEndTime = 'unset' : $clientEndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $clientTimezoneName)[1];
    
    (empty($bookingDateTimeStart)) ? $pacificStartDate = 'unset' : $pacificStartDate = convertDateTimeUTCtoLocal($bookingDateTimeStart, $pacificTimezoneName)[0];
    (empty($bookingDateTimeStart)) ? $pacificStartTime = 'unset' : $pacificStartTime = convertDateTimeUTCtoLocal($bookingDateTimeStart, $pacificTimezoneName)[1];
    (empty($bookingDateTimeEnd)) ? $pacificEndDate = 'unset' : $pacificEndDate = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $pacificTimezoneName)[0];
    (empty($bookingDateTimeEnd)) ? $pacificEndTime = 'unset' : $pacificEndTime = convertDateTimeUTCtoLocal($bookingDateTimeEnd, $pacificTimezoneName)[1];

$message = "
    <html>
    <head>
    <title>Booking Details</title>
    </head>
    <body>
    <h3>Booking For " . $clientFullName . " </h3>
    " . $clientDetailsHtml . "
    <table>
        <tr>
            <th style='text-align: left;'>Date:</th>
            <td style='text-align: left;'>" . $StartDate . "</td>
        </tr>
        <tr>
            <th style='text-align: left;'>Time:</th>
            <td style='text-align: left;'>" . $StartTime . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Show Name:</th>
            <td style='text-align: left;'>" . $venueName . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Timezone:</th>
            <td style='text-align: left;'>" . $litmTimezoneName . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Host:</th>
            <td style='text-align: left;'>" . $hostFullName . " (" . $hostPrimaryEmail . ")</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Length of Interview:</th>
            <td style='text-align: left;'>" . $bookingLength . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;'>Website:</th>
            <td style='text-align: left;'>" . $primaryVenueServiceWebsite . "</td> 
        </tr>
        <tr>
            <th style='text-align: left;' valign='top'>Notes:</th>
            <td style='text-align: left;'>" . $primaryVenueNote . "</td> 
        </tr>
        <tr>
        <th style='text-align: left;' valign='top'>Service Notes:</th>
        <td valign='top'>
            <table>
                <tr>
                    <th style='text-align: left;'>Service Name:</th>
                    <td style='text-align: left;'>" . $primaryVenueServiceName . "</td>
                </tr>
                <tr>
                    <th style='text-align: left;'>Service User:</th>
                    <td style='text-align: left;'>" . $primaryVenueServiceUserAccount . "</td>
                </tr>
                <tr>
                    <th style='text-align: left;'>Service Website:</th>
                    <td style='text-align: left;'>" . $primaryVenueServiceWebsite . "</td>
                </tr>
                <tr>
                    <th style='text-align: left;'>Service Notes:</th>
                    <td style='text-align: left;'>" . $primaryVenueServiceNotes . "</td>
                </tr>
            </table>
        </td>
        </tr>

        <br>
        <br>
    </table>
    <img style='width: 8%;' src='https://ci3.googleusercontent.com/proxy/r5QP5P6T_WDQRE6TJNt9fDkJGl0vEl96dSnZQ9qZmWqhOdwN7GZLmfEFabihsPUa8qfrjeNxjvpxdzhdnkBc2A64i7p4mLOirNAiBo7yyRPo8JSoCmrhsN2nnt3Xr9WhXJMYe_2voaaeITFN4HS1WwhJi3d1yxJxbCNauRdhdQgkV2tKqOmg_Hl9DxIkpTQrYmq60mjVWLJRu_KAew=s0-d-e1-ft#https://docs.google.com/uc?export=download&id=1KFwppgNkPJgHCfNZb2KZsYmX6VGRuY-9&revid=0Bw3hvFN4lg78OU9pZU9zZUQzTlRlWkF6NlZMOG1GYmxmOEhvPQ'>
    <p>Michelle Freed, Publicist</p>
    <p>LITM Media</p>
    <p>'Leave it to Michelle'</p>
    <p>424-409-5486</p>
    <a href='https://litmmedia.com/'>https://litmmedia.com/</a>
    </body>
    </html>
";
$venueWebsite = '';
if(!empty($primaryVenueServiceId)){
$venueWebsite = <<<VENUEWEBSITE
            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Website:</span>
                <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueServiceWebsite</span>
            </div>
VENUEWEBSITE;
}
$hostEmail = '';
if(!empty($hostPrimaryEmailId)){
$hostEmail = <<<HOSTEMAIL
            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Host Email:</span>
                <span style="display: inline-block;font-weight: bold; padding: 0.25em 0"><a href="mailto:$hostPrimaryEmail">$hostPrimaryEmail</a></span>
            </div>
HOSTEMAIL;
}
// purple 4A0C57 green 4FDC0E
$show = <<<SHOW
    <div class="show" style="width: 70%; margin-top: 1.5em;">
    <div style="color:#4FDC0E;background-color: #4A0C57;border: solid black 1px; border-radius: 0.25em;">
        <div style="background-color: #4FDC0E;border-bottom: solid 1px #ccc;text-align: center; border-top-left-radius: 0.25em; border-top-right-radius: 0.25em;"><h3 style="color:#4A0C57;margin:0; padding: 0;">Booking Confirmation</h3></div>
            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Show Name:</span>
                <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$venueName</span>
            </div>

            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Host:</span>
                <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$hostFullName</span>
            </div>

            $venueWebsite

            $hostEmail

            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Client Show Time:</span><span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$StartDate $StartTime</span>
                <span style="display: inline-block; width: 140px;">($litmTimezoneName)</span>
            </div>

            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Alt. Show Times:</span><span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$pacificStartDate $pacificStartTime</span>
                <span style="display: inline-block; width: 140px;">($pacificTimezoneName)</span>
            </div>

            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;"></span><span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$clientStartDate $clientStartTime</span>
                <span style="display: inline-block; width: 140px;">($clientTimezoneName)</span>
            </div>
            
            <div style="margin-left: 1em;">
                <span style="display: inline-block; width: 140px;">Length of Interview:</span>
                <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$bookingLength</span>
            </div>

        </div>
    </div>
    </div>
SHOW;

$serviceNotes = <<<SERVICENOTES
    <div class="service-notes" style="width: 70%;margin-top: 1.5em;">
        <div style="color:#4FDC0E;background-color: #4A0C57;border: solid black 1px; border-radius: 0.25em;">
            <div style="background-color: #4FDC0E;border-bottom: solid 1px #ccc;text-align: center; border-top-left-radius: 0.25em; border-top-right-radius: 0.25em;"><h3 style="color:#4A0C57;margin:0; padding: 0;">Service Notes</h3></div>
                <div style="margin-left: 1em;">
                    <span style="display: inline-block; width: 140px;">Service:</span>
                    <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueServiceName</span>
                </div>

                <div style="margin-left: 1em;">
                    <span style="display: inline-block; width: 140px;">User:</span>
                    <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueServiceUserAccount</span>
                </div>

                <div style="margin-left: 1em;">
                    <span style="display: inline-block; width: 140px;">Website:</span>
                    <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueServiceWebsite</span>
                </div>
                
                <div style="margin-left: 1em;">
                    <span style="display: inline-block; width: 140px;">Notes:</span>
                    <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueServiceNotes</span>
                </div>
            </div>
        </div>
    </div>

SERVICENOTES;

$showNotes = '';
if(!empty($primaryVenueNoteId)){
$showNotes = <<<SHOWNOTES
    <div class="show-notes" style="width: 70%;margin-top: 1.5em;">
        <div style="color:#4FDC0E;background-color: #4A0C57;border: solid black 1px; border-radius: 0.25em;">
            <div style="background-color: #4FDC0E;border-bottom: solid 1px #ccc;text-align: center; border-top-left-radius: 0.25em; border-top-right-radius: 0.25em;"><h3 style="color:#4A0C57;margin:0; padding: 0;">Instructions</h3></div>
                <div style="margin-left: 1em;">
                    <span style="display: inline-block;font-weight: bold; padding: 0.25em 0">$primaryVenueNote</span>
                </div>
            </div>
        </div>
    </div>
SHOWNOTES;

}

$signature = <<<SIGNATURE
    <div class="signature" style="height: 120px;width: 70%; margin-top: 2em;">
        <div class="logo" style="display: inline-block; margin:0; padding: 0;">
            <img
            src="https://ci3.googleusercontent.com/proxy/r5QP5P6T_WDQRE6TJNt9fDkJGl0vEl96dSnZQ9qZmWqhOdwN7GZLmfEFabihsPUa8qfrjeNxjvpxdzhdnkBc2A64i7p4mLOirNAiBo7yyRPo8JSoCmrhsN2nnt3Xr9WhXJMYe_2voaaeITFN4HS1WwhJi3d1yxJxbCNauRdhdQgkV2tKqOmg_Hl9DxIkpTQrYmq60mjVWLJRu_KAew=s0-d-e1-ft#https://docs.google.com/uc?export=download&id=1KFwppgNkPJgHCfNZb2KZsYmX6VGRuY-9&revid=0Bw3hvFN4lg78OU9pZU9zZUQzTlRlWkF6NlZMOG1GYmxmOEhvPQ"
            alt="Logo"
            height="90"
            style="display: inline-block;"
            />
        </div>

        <div class="company" style="display: inline-block;">
            <div class="employee" style="font-weight: bold">Michelle Freed, Publicist</div>
            <div class="company-name">LITM Media</div>
            <div class="byline">&quot;Leave it to Michelle&quot;</div>
            <div class="phone"><a href="tel:14244095486">424-409-5486</a></div>
            <div class="website"><a href="https://litmmedia.com/">https://litmmedia.com</a></div>
        </div>
    </div>
SIGNATURE;

$message = <<<HTML
<div>
    $show
    <!-- $serviceNotes -->
    $showNotes
    $signature
</div>
HTML;

echo $message;
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <michelle@litmmedia.com>' . "\r\n";
// $headers .= 'Cc: michelle@litmmedia.com' . "\r\n";
// $headers .= 'From: <michelle@litmmedia.com>' . "\r\n";
// $headers .= 'Cc: michelle@litmmedia.com' . "\r\n";

mail($to, $subject, $message, $headers);

// echo "../email.php Done!";
