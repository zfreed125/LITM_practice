<?php
$phone_types_sql = "SELECT * FROM phone_types;";
$phone_types_result = mysqli_query($conn, $phone_types_sql);
$phone_type_array = array();
while ($row = mysqli_fetch_assoc($phone_types_result)) {
    $phone_type_array[] = array('id' => $row['id'], 'phoneType' => $row['phoneType']);
}

//phone sql loop table
$phone_sql = "SELECT * FROM phones where venueId = '$venuesId';";
$phone_result = mysqli_query($conn, $phone_sql);
$phoneRowCount = mysqli_num_rows($phone_result);
echo "<table id='tbl_phone". $venuesId ."' style='display: none; position: relative; left: 50px;' class='show table table-bordered table-striped'>";
echo "<thead>";
echo "<caption><a href='../phones/add.php?venueId=". $venuesId ."' title='Add Phone' data-toggle='tooltip'><span><i class='fas fa-plus'></i>phone</span></a></caption>";
echo "<a href='#' title='Show/Hide Phones'style='position: relative; left: 50px;' onclick='myFunction(tbl_phone". $venuesId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Phones (". $phoneRowCount .")&nbsp</span></a>";
echo "<tr>";
echo "<th></th>";
echo "<th>Phone</th>";
echo "<th>Phone Type</th>";
echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($phone_result))
{
    foreach($phone_type_array as $item){
        if($item['id'] == $row['phoneTypeId']){
            $phoneTypeId = $item['phoneType'];
            }
    }
if($primaryPhoneId == $row['id']) {
    $phone_primary = "<a href='../phones/remove_primary.php?src=venues&id=".$row['id']."'><span><i style='color:green'class='fas fa-star'></i></span></a>";
}else{
    $phone_primary = "<a href='primary.php?phoneId=".$row['id']."&venueId=".$venuesId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
}
$phoneNumber = usformatPhoneNumber($row['phone']);
echo "<tr>";
echo "<td class='fitwidth'>" . "$phone_primary" . "</td>";
echo "<td class='fitwidth'>" . "$phoneNumber" . "</td>";
echo "<td class='fitwidth'>" . "$phoneTypeId" . "</td>";
echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
echo "<td class='fitwidth'>";
echo "<a href='../phones/edit.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
echo "<a href='../phones/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
echo "</td>";
echo "</tr>";
}//end of phone loop
//end of the table from the phone loop
echo "</tbody>";
echo "</table>";

?>