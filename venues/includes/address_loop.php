<?php

//address sql query loop table
$address_sql = "SELECT * FROM addresses WHERE venueId = '$venuesId';";
$address_result = mysqli_query($conn, $address_sql);
$addressRowCount = mysqli_num_rows($address_result);

echo "<table id='tbl_address". $venuesId ."' style= 'display: none; position: relative; left: 50px;' class='table table-bordered table-striped'>";
echo "<caption><a href='../address/add.php?src=venues&venueId=". $venuesId ."' title='Add Address' data-toggle='tooltip'><span><i class='fas fa-plus'></i>Address</span></a></caption>";
echo "<a href='#' title='Show/Hide Addresses'style='position: relative; left: 50px;' onclick='myFunction(tbl_address". $venuesId .")'><span><i class='fas fa-chevron-down'></i>&nbsp Addresses (". $addressRowCount .")&nbsp</span></a>";
echo "<thead>";
echo "<tr>";
echo "<th></th>";
echo "<th>Street1</th>";
echo "<th>Street2</th>";
echo "<th>City</th>";
echo "<th>State</th>";
echo "<th>Zip1</th>";
echo "<th>Country</th>";
echo "<th>Created</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($address_result))
{
if($primaryAddressId == $row['id']) {
    $address_primary = "<span><i style='color:green'class='fas fa-star'></i></span>";
}else{
    $address_primary = "<a href='primary.php?addressId=".$row['id']."&venueId=".$venuesId."'><span><i style='color:green'class='far fa-star'></i></span></a>";
}
    echo "<tr>";
    echo "<td class='fitwidth'>" . "$address_primary" . "</td>";
    echo "<td class='fitwidth'>" . "$row[street1]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[street2]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[city]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[shortState]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[zip1]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[country]" . "</td>";
    echo "<td class='fitwidth'>" . "$row[created]" . "</td>";
    echo "<td class='fitwidth'>";
    echo "<a href='../address/edit.php?src=venues&id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span><i class='fas fa-edit'></i></span></a>";
    echo "<a href='../address/delete.php?src=venues&id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span><i class='fas fa-trash'></i></span></a>";
    echo "</td>";
    echo "</tr>";
}//end of address loop
//end of the table from the address loop
echo "</tbody>";
echo "</table>";

?>