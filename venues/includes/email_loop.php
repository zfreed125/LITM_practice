<?php
$email_types_sql = "SELECT * FROM email_types;";
$email_types_result = mysqli_query($conn, $email_types_sql);
$email_type_array = array();
while ($row = mysqli_fetch_assoc($email_types_result)) {
    $email_type_array[] = array('id' => $row['id'], 'emailType' => $row['emailType']);
}

//email sql loop table
$email_sql = "SELECT * FROM emails where venueId = '$venuesId';";
$email_result = mysqli_query($conn, $email_sql);
$emailRowCount = mysqli_num_rows($email_result);
if(!$emailRowCount){
    $dataset = "data-email='' ";
}else{
    $dataset = "";
}
echo "<table id='tbl_email". $venuesId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
echo "<caption><a href='../emails/add.php?venueId=". $venuesId ."' title='Add Email' data-toggle='tooltip'><span><i class='fas fa-plus'></i></span>Email</a></caption>";
echo "<a ".$dataset." href='#' title='Show/Hide Emails'style='position: relative; left: 50px;' onclick='myFunction(tbl_email". $venuesId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Emails (". $emailRowCount .")&nbsp</span></a>";
echo "<thead>";
echo "<tr>";
echo "<th></th>";
echo "<th>Email</th>";
echo "<th>Email Type</th>";
echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($email_result))
{
    foreach($email_type_array as $item){
        if($item['id'] == $row['emailTypeId']){
            $emailTypeId = $item['emailType'];
            }
    }
if($primaryEmailId == $row['id']) {
   $email_primary = "<a href='../emails/remove_primary.php?src=venues&id=".$row['id']."'><span><i style='color:green'class='fas fa-star'></i></span></a>";
}else{
    $email_primary = "<a href='primary.php?emailId=".$row['id']."&venueId=".$venuesId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
}
echo "<tr>";
echo "<td class='fitwidth'>" . "$email_primary" . "</td>";
echo "<td data-email='".strtolower($row['email'])."' class='fitwidth'>" . "$row[email]" . "</td>";
echo "<td class='fitwidth'>" . "$emailTypeId" . "</td>";
echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
echo "<td class='fitwidth'>";
echo "<a href='../emails/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
echo "<a href='../emails/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
echo "</td>";
echo "</tr>";
}//end of email loop
//end of the table from the email loop
echo "</tbody>";
echo "</table>";

?>