<?php

require_once '../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


// sql to create table
// $sql2 = "DROP TABLE contacts;";
$sql1 = "CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(44) DEFAULT NULL,
  `timezone` varchar(30) DEFAULT NULL,
  `offset` varchar(8) DEFAULT NULL,
  `alias` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 141;";
$data = "INSERT INTO `timezones` (`id`, `name`, `timezone`, `offset`, `alias`) VALUES
(1, '(GMT-11:00) Midway Island ', 'Pacific/Midway','-11:00',''),
(2, '(GMT-11:00) Samoa ', 'Pacific/Samoa','-11:00',''),
(3, '(GMT-10:00) Hawaii ', 'Pacific/Honolulu','-10:00','Hawaii'),
(4, '(GMT-09:00) Alaska ', 'America/Anchorage','-09:00',''),
(5, '(GMT-08:00) Pacific Time (US &amp; Canada) ', 'America/Los_Angeles','-08:00','Pacific'),
(6, '(GMT-08:00) Tijuana ', 'America/Tijuana','-08:00',''),
(7, '(GMT-07:00) Chihuahua ', 'America/Chihuahua','-07:00',''),
(8, '(GMT-07:00) La Paz ', 'America/Chihuahua','-07:00',''),
(9, '(GMT-07:00) Mazatlan ', 'America/Mazatlan','-07:00',''),
(10, '(GMT-07:00) Mountain Time (US &amp; Canada) ', 'America/Denver','-07:00','Mountain'),
(11, '(GMT-06:00) Central America ', 'America/Managua','-06:00',''),
(12, '(GMT-06:00) Central Time (US &amp; Canada) ', 'America/Chicago','-06:00','Central'),
(13, '(GMT-06:00) Guadalajara ', 'America/Mexico_City','-06:00',''),
(14, '(GMT-06:00) Mexico City ', 'America/Mexico_City','-06:00',''),
(15, '(GMT-06:00) Monterrey ', 'America/Monterrey','-06:00',''),
(16, '(GMT-05:00) Bogota ', 'America/Bogota','-05:00',''),
(17, '(GMT-05:00) Eastern Time (US &amp; Canada) ', 'America/New_York','-05:00','Eastern'),
(18, '(GMT-05:00) Lima ', 'America/Lima','-05:00',''),
(19, '(GMT-05:00) Quito ', 'America/Bogota','-05:00',''),
(20, '(GMT-04:00) Atlantic Time (Canada) ', 'Canada/Atlantic','-04:00',''),
(21, '(GMT-04:30) Caracas ', 'America/Caracas','-04:30',''),
(22, '(GMT-04:00) La Paz ', 'America/La_Paz','-04:00',''),
(23, '(GMT-04:00) Santiago ', 'America/Santiago','-04:00',''),
(24, '(GMT-03:30) Newfoundland ', 'America/St_Johns','-03:30',''),
(25, '(GMT-03:00) Brasilia ', 'America/Sao_Paulo','-03:00',''),
(26, '(GMT-03:00) Buenos Aires ', 'America/Argentina/Buenos_Aires','-03:00',''),
(27, '(GMT-03:00) Georgetown ', 'America/Argentina/Buenos_Aires','-03:00',''),
(28, '(GMT-03:00) Greenland ', 'America/Godthab','-03:00',''),
(29, '(GMT-02:00) Mid-Atlantic ', 'America/Noronha','-02:00',''),
(30, '(GMT-01:00) Azores ', 'Atlantic/Azores','-01:00',''),
(31, '(GMT-01:00) Cape Verde Is. ', 'Atlantic/Cape_Verde','-01:00',''),
(32, '(GMT+00:00) Casablanca ', 'Africa/Casablanca','+00:00',''),
(33, '(GMT+00:00) Edinburgh ', 'Europe/London','+00:00',''),
(34, '(GMT+00:00) Dublin ', 'Europe/Dublin','+00:00',''),
(35, '(GMT+00:00) Lisbon ', 'Europe/Lisbon','+00:00',''),
(36, '(GMT+00:00) London ', 'Europe/London','+00:00',''),
(37, '(GMT+00:00) Monrovia ', 'Africa/Monrovia','+00:00',''),
(38, '(GMT+00:00) UTC ', 'UTC','+00:00',''),
(39, '(GMT+01:00) Amsterdam ', 'Europe/Amsterdam','+01:00',''),
(40, '(GMT+01:00) Belgrade ', 'Europe/Belgrade','+01:00',''),
(41, '(GMT+01:00) Berlin ', 'Europe/Berlin','+01:00',''),
(42, '(GMT+01:00) Bern ', 'Europe/Berlin','+01:00',''),
(43, '(GMT+01:00) Bratislava ', 'Europe/Bratislava','+01:00',''),
(44, '(GMT+01:00) Brussels ', 'Europe/Brussels','+01:00',''),
(45, '(GMT+01:00) Budapest ', 'Europe/Budapest','+01:00',''),
(46, '(GMT+01:00) Copenhagen ', 'Europe/Copenhagen','+01:00',''),
(47, '(GMT+01:00) Ljubljana ', 'Europe/Ljubljana','+01:00',''),
(48, '(GMT+01:00) Madrid ', 'Europe/Madrid','+01:00',''),
(49, '(GMT+01:00) Paris ', 'Europe/Paris','+01:00',''),
(50, '(GMT+01:00) Prague ', 'Europe/Prague','+01:00',''),
(51, '(GMT+01:00) Rome ', 'Europe/Rome','+01:00',''),
(52, '(GMT+01:00) Sarajevo ', 'Europe/Sarajevo','+01:00',''),
(53, '(GMT+01:00) Skopje ', 'Europe/Skopje','+01:00',''),
(54, '(GMT+01:00) Stockholm ', 'Europe/Stockholm','+01:00',''),
(55, '(GMT+01:00) Vienna ', 'Europe/Vienna','+01:00',''),
(56, '(GMT+01:00) Warsaw ', 'Europe/Warsaw','+01:00',''),
(57, '(GMT+01:00) West Central Africa ', 'Africa/Lagos','+01:00',''),
(58, '(GMT+01:00) Zagreb ', 'Europe/Zagreb','+01:00',''),
(59, '(GMT+02:00) Athens ', 'Europe/Athens','+02:00',''),
(60, '(GMT+02:00) Bucharest ', 'Europe/Bucharest','+02:00',''),
(61, '(GMT+02:00) Cairo ', 'Africa/Cairo','+02:00',''),
(62, '(GMT+02:00) Harare ', 'Africa/Harare','+02:00',''),
(63, '(GMT+02:00) Helsinki ', 'Europe/Helsinki','+02:00',''),
(64, '(GMT+02:00) Istanbul ', 'Europe/Istanbul','+02:00',''),
(65, '(GMT+02:00) Jerusalem ', 'Asia/Jerusalem','+02:00',''),
(66, '(GMT+02:00) Kyiv ', 'Europe/Helsinki','+02:00',''),
(67, '(GMT+02:00) Pretoria ', 'Africa/Johannesburg','+02:00',''),
(68, '(GMT+02:00) Riga ', 'Europe/Riga','+02:00',''),
(69, '(GMT+02:00) Sofia ', 'Europe/Sofia','+02:00',''),
(70, '(GMT+02:00) Tallinn ', 'Europe/Tallinn','+02:00',''),
(71, '(GMT+02:00) Vilnius ', 'Europe/Vilnius','+02:00',''),
(72, '(GMT+03:00) Baghdad ', 'Asia/Baghdad','+03:00',''),
(73, '(GMT+03:00) Kuwait ', 'Asia/Kuwait','+03:00',''),
(74, '(GMT+03:00) Minsk ', 'Europe/Minsk','+03:00',''),
(75, '(GMT+03:00) Nairobi ', 'Africa/Nairobi','+03:00',''),
(76, '(GMT+03:00) Riyadh ', 'Asia/Riyadh','+03:00',''),
(77, '(GMT+03:00) Volgograd ', 'Europe/Volgograd','+03:00',''),
(78, '(GMT+03:30) Tehran ', 'Asia/Tehran','+03:30',''),
(79, '(GMT+04:00) Abu Dhabi ', 'Asia/Muscat','+04:00',''),
(80, '(GMT+04:00) Baku ', 'Asia/Baku','+04:00',''),
(81, '(GMT+04:00) Moscow ', 'Europe/Moscow','+04:00',''),
(82, '(GMT+04:00) Muscat ', 'Asia/Muscat','+04:00',''),
(83, '(GMT+04:00) St. Petersburg ', 'Europe/Moscow','+04:00',''),
(84, '(GMT+04:00) Tbilisi ', 'Asia/Tbilisi','+04:00',''),
(85, '(GMT+04:00) Yerevan ', 'Asia/Yerevan','+04:00',''),
(86, '(GMT+04:30) Kabul ', 'Asia/Kabul','+04:30',''),
(87, '(GMT+05:00) Islamabad ', 'Asia/Karachi','+05:00',''),
(88, '(GMT+05:00) Karachi ', 'Asia/Karachi','+05:00',''),
(89, '(GMT+05:00) Tashkent ', 'Asia/Tashkent','+05:00',''),
(90, '(GMT+05:30) Chennai ', 'Asia/Calcutta','+05:30',''),
(91, '(GMT+05:30) Kolkata ', 'Asia/Kolkata','+05:30',''),
(92, '(GMT+05:30) Mumbai ', 'Asia/Calcutta','+05:30',''),
(93, '(GMT+05:30) New Delhi ', 'Asia/Calcutta','+05:30',''),
(94, '(GMT+05:30) Sri Jayawardenepura ', 'Asia/Calcutta','+05:30',''),
(95, '(GMT+05:45) Kathmandu ', 'Asia/Katmandu','+05:45',''),
(96, '(GMT+06:00) Almaty ', 'Asia/Almaty','+06:00',''),
(97, '(GMT+06:00) Astana ', 'Asia/Dhaka','+06:00',''),
(98, '(GMT+06:00) Dhaka ', 'Asia/Dhaka','+06:00',''),
(99, '(GMT+06:00) Ekaterinburg ', 'Asia/Yekaterinburg','+06:00',''),
(100, '(GMT+06:30) Rangoon ', 'Asia/Rangoon','+06:30',''),
(101, '(GMT+07:00) Bangkok ', 'Asia/Bangkok','+07:00',''),
(102, '(GMT+07:00) Hanoi ', 'Asia/Bangkok','+07:00',''),
(103, '(GMT+07:00) Jakarta ', 'Asia/Jakarta','+07:00',''),
(104, '(GMT+07:00) Novosibirsk ', 'Asia/Novosibirsk','+07:00',''),
(105, '(GMT+08:00) Beijing ', 'Asia/Hong_Kong','+08:00',''),
(106, '(GMT+08:00) Chongqing ', 'Asia/Chongqing','+08:00',''),
(107, '(GMT+08:00) Hong Kong ', 'Asia/Hong_Kong','+08:00',''),
(108, '(GMT+08:00) Krasnoyarsk ', 'Asia/Krasnoyarsk','+08:00',''),
(109, '(GMT+08:00) Kuala Lumpur ', 'Asia/Kuala_Lumpur','+08:00',''),
(110, '(GMT+08:00) Perth ', 'Australia/Perth','+08:00',''),
(111, '(GMT+08:00) Singapore ', 'Asia/Singapore','+08:00',''),
(112, '(GMT+08:00) Taipei ', 'Asia/Taipei','+08:00',''),
(113, '(GMT+08:00) Ulaan Bataar ', 'Asia/Ulan_Bator','+08:00',''),
(114, '(GMT+08:00) Urumqi ', 'Asia/Urumqi','+08:00',''),
(115, '(GMT+09:00) Irkutsk ', 'Asia/Irkutsk','+09:00',''),
(116, '(GMT+09:00) Osaka ', 'Asia/Tokyo','+09:00',''),
(117, '(GMT+09:00) Sapporo ', 'Asia/Tokyo','+09:00',''),
(118, '(GMT+09:00) Seoul ', 'Asia/Seoul','+09:00',''),
(119, '(GMT+09:00) Tokyo ', 'Asia/Tokyo','+09:00',''),
(120, '(GMT+09:30) Adelaide ', 'Australia/Adelaide','+09:30',''),
(121, '(GMT+09:30) Darwin ', 'Australia/Darwin','+09:30',''),
(122, '(GMT+10:00) Brisbane ', 'Australia/Brisbane','+10:00',''),
(123, '(GMT+10:00) Canberra ', 'Australia/Canberra','+10:00',''),
(124, '(GMT+10:00) Guam ', 'Pacific/Guam','+10:00',''),
(125, '(GMT+10:00) Hobart ', 'Australia/Hobart','+10:00',''),
(126, '(GMT+10:00) Melbourne ', 'Australia/Melbourne','+10:00',''),
(127, '(GMT+10:00) Port Moresby ', 'Pacific/Port_Moresby','+10:00',''),
(128, '(GMT+10:00) Sydney ', 'Australia/Sydney','+10:00',''),
(129, '(GMT+10:00) Yakutsk ', 'Asia/Yakutsk','+10:00',''),
(130, '(GMT+11:00) Vladivostok ', 'Asia/Vladivostok','+11:00',''),
(131, '(GMT+12:00) Auckland ', 'Pacific/Auckland','+12:00',''),
(132, '(GMT+12:00) Fiji ', 'Pacific/Fiji','+12:00',''),
(133, '(GMT+12:00) International Date Line West ', 'Pacific/Kwajalein','+12:00',''),
(134, '(GMT+12:00) Kamchatka ', 'Asia/Kamchatka','+12:00',''),
(135, '(GMT+12:00) Magadan ', 'Asia/Magadan','+12:00',''),
(136, '(GMT+12:00) Marshall Is. ', 'Pacific/Fiji','+12:00',''),
(137, '(GMT+12:00) New Caledonia ', 'Asia/Magadan','+12:00',''),
(138, '(GMT+12:00) Solomon Is. ', 'Asia/Magadan','+12:00',''),
(139, '(GMT+12:00) Wellington ', 'Pacific/Auckland','+12:00',''),
(140, '(GMT+13:00) Nuku\\alofa ', 'Pacific/Tongatapu','+13:00','');";
    

    if ($conn->query($sql1) === TRUE) {
      echo "Table venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }
    if ($conn->query($data) === TRUE) {
      echo "Table venues created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

    

?>